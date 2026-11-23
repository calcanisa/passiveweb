(function () {
  'use strict';

  var forms = document.querySelectorAll('[data-pwc-form]');
  if (!forms.length || !window.fetch || !window.FormData) {
    return;
  }

  var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  var phoneRe = /^[0-9+()\s.-]{6,30}$/;

  Array.prototype.forEach.call(forms, function (form) {
    var tokenInput = form.querySelector('input[name="pwc_token"]');
    var pageInput = form.querySelector('input[name="pwc_page"]');
    var status = form.querySelector('[data-status]');
    var button = form.querySelector('.pwc-submit');
    var label = form.querySelector('[data-label]');
    var labelText = label ? label.textContent : '';
    var fresh = false;
    var fetching = null;
    var busy = false;
    var tokenAt = 0;

    if (pageInput) {
      pageInput.value = window.location.href.split('#')[0];
    }

    function refreshToken() {
      if (fresh) {
        return Promise.resolve();
      }
      if (fetching) {
        return fetching;
      }
      fetching = fetch(form.getAttribute('data-token-endpoint'), {
        method: 'GET',
        credentials: 'same-origin',
        cache: 'no-store',
        headers: { 'Accept': 'application/json' }
      }).then(function (r) {
        return r.ok ? r.json() : null;
      }).then(function (json) {
        if (json && typeof json.token === 'string' && tokenInput) {
          tokenInput.value = json.token;
          tokenAt = Date.now();
          fresh = true;
        }
      }).catch(function () {
        fresh = false;
      }).then(function () {
        fetching = null;
      });
      return fetching;
    }

    form.addEventListener('focusin', refreshToken);
    form.addEventListener('pointerdown', refreshToken);

    function setStatus(text, type) {
      if (!status) {
        return;
      }
      status.textContent = text || '';
      status.classList.remove('is-success', 'is-error');
      if (type) {
        status.classList.add(type);
      }
    }

    function setError(name, message) {
      var holder = form.querySelector('[data-error="' + name + '"]');
      var field = form.querySelector('[data-field="' + name + '"]');
      if (holder) {
        holder.textContent = message || '';
      }
      if (field) {
        field.classList.toggle('is-invalid', !!message);
        if (message) {
          field.setAttribute('aria-invalid', 'true');
          if (holder && holder.id === '') {
            holder.id = field.id + '-error';
          }
          if (holder) {
            field.setAttribute('aria-describedby', holder.id);
          }
        } else {
          field.removeAttribute('aria-invalid');
          field.removeAttribute('aria-describedby');
        }
      }
    }

    function clearErrors() {
      Array.prototype.forEach.call(form.querySelectorAll('[data-error]'), function (el) {
        setError(el.getAttribute('data-error'), '');
      });
    }

    function value(name) {
      var el = form.querySelector('[data-field="' + name + '"]');
      return el ? el.value.trim() : '';
    }

    function validate() {
      var errors = {};
      var req = form.getAttribute('data-msg-required');
      if (value('name').length < 2) {
        errors.name = req;
      }
      if (!emailRe.test(value('email'))) {
        errors.email = form.getAttribute('data-msg-email');
      }
      if (value('phone') !== '' && !phoneRe.test(value('phone'))) {
        errors.phone = form.getAttribute('data-msg-phone');
      }
      if (value('message').length < 10) {
        errors.message = req;
      }
      return errors;
    }

    function showErrors(errors) {
      var first = null;
      Object.keys(errors || {}).forEach(function (key) {
        setError(key, errors[key]);
        if (!first) {
          first = form.querySelector('[data-field="' + key + '"]');
        }
      });
      if (first) {
        first.focus();
      }
      return !!first;
    }

    Array.prototype.forEach.call(form.querySelectorAll('[data-field]'), function (el) {
      el.addEventListener('input', function () {
        if (el.classList.contains('is-invalid')) {
          setError(el.getAttribute('data-field'), '');
        }
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (busy) {
        return;
      }
      clearErrors();
      setStatus('', null);
      var errors = validate();
      if (showErrors(errors)) {
        return;
      }
      busy = true;
      button.disabled = true;
      form.classList.add('is-busy');
      if (label) {
        label.textContent = form.getAttribute('data-sending') || labelText;
      }

      send(0);
    });

    function finish() {
      busy = false;
      button.disabled = false;
      form.classList.remove('is-busy');
      if (label) {
        label.textContent = labelText;
      }
    }

    function wait(ms) {
      return new Promise(function (resolve) {
        setTimeout(resolve, Math.max(0, ms));
      });
    }

    function send(attempt) {
      refreshToken().then(function () {
        return wait(tokenAt ? 3300 - (Date.now() - tokenAt) : 0);
      }).then(function () {
        return fetch(form.getAttribute('data-endpoint'), {
          method: 'POST',
          body: new FormData(form),
          credentials: 'same-origin',
          headers: { 'Accept': 'application/json' }
        });
      }).then(function (r) {
        return r.json().catch(function () {
          return { ok: false };
        });
      }).then(function (json) {
        if (json && json.ok) {
          form.reset();
          if (pageInput) {
            pageInput.value = window.location.href.split('#')[0];
          }
          fresh = false;
          form.classList.add('is-sent');
          setStatus(json.message || '', 'is-success');
          finish();
          return;
        }
        if (json && (json.code === 'fast' || json.code === 'expired') && attempt === 0) {
          if (json.code === 'expired') {
            fresh = false;
          }
          send(1);
          return;
        }
        if (json && json.code === 'expired') {
          fresh = false;
        }
        if (json && json.errors && showErrors(json.errors)) {
          setStatus(json.message || '', 'is-error');
        } else {
          setStatus((json && json.message) || form.getAttribute('data-msg-error'), 'is-error');
        }
        finish();
      }).catch(function () {
        setStatus(form.getAttribute('data-msg-error'), 'is-error');
        finish();
      });
    }
  });
})();
