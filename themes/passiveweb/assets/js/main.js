(function () {
  'use strict';

  var d = document;
  var w = window;
  var root = d.documentElement;
  var body = d.body;
  var reduce = w.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = w.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var hasIO = 'IntersectionObserver' in w;

  function $(sel, ctx) {
    return (ctx || d).querySelector(sel);
  }

  function $$(sel, ctx) {
    return Array.prototype.slice.call((ctx || d).querySelectorAll(sel));
  }

  function fx(name) {
    return body.classList.contains('pw-fx-' + name);
  }

  function cssVar(name) {
    return getComputedStyle(root).getPropertyValue(name).trim();
  }

  function onVisible(el, cb, opts) {
    if (!hasIO) {
      cb(el);
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          io.unobserve(entry.target);
          cb(entry.target);
        }
      });
    }, opts || { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
    io.observe(el);
  }

  function initHeader() {
    var header = $('[data-header]');
    var bar = $('[data-progress]');
    var ticking = false;

    function update() {
      var y = w.scrollY;
      var max = Math.max(1, root.scrollHeight - w.innerHeight);
      if (header) {
        header.classList.toggle('is-scrolled', y > 24);
      }
      if (bar) {
        bar.style.transform = 'scaleX(' + Math.min(1, y / max).toFixed(4) + ')';
      }
      ticking = false;
    }

    w.addEventListener('scroll', function () {
      if (!ticking) {
        ticking = true;
        w.requestAnimationFrame(update);
      }
    }, { passive: true });
    update();
  }

  function initNav() {
    var burger = $('[data-burger]');
    var nav = $('[data-nav]');
    if (!burger || !nav) {
      return;
    }

    function setOpen(open) {
      body.classList.toggle('pw-nav-open', open);
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    }

    burger.addEventListener('click', function () {
      setOpen(!body.classList.contains('pw-nav-open'));
    });

    $$('a', nav).forEach(function (a) {
      a.addEventListener('click', function () {
        setOpen(false);
      });
    });

    d.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && body.classList.contains('pw-nav-open')) {
        setOpen(false);
        burger.focus();
      }
    });

    w.addEventListener('resize', function () {
      if (w.innerWidth > 1180) {
        setOpen(false);
      }
    });

    var links = $$('[data-nav-link]');
    if (!links.length || !hasIO) {
      return;
    }
    var map = {};
    links.forEach(function (l) {
      map[l.getAttribute('data-nav-link')] = l;
    });
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var link = map[entry.target.id];
        if (!link) {
          return;
        }
        if (entry.isIntersecting) {
          links.forEach(function (l) {
            l.classList.remove('is-active');
          });
          link.classList.add('is-active');
        }
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    Object.keys(map).forEach(function (id) {
      var sec = d.getElementById(id);
      if (sec) {
        spy.observe(sec);
      }
    });
  }

  function initReveal() {
    var items = $$('[data-reveal], [data-split]');
    if (reduce || !hasIO) {
      items.forEach(function (el) {
        el.classList.add('is-in');
      });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          el.classList.add('is-in');
          io.unobserve(el);
          setTimeout(function () {
            el.classList.add('is-done');
          }, 1800);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    items.forEach(function (el) {
      io.observe(el);
    });
  }

  function initRotator() {
    $$('[data-rotator]').forEach(function (el) {
      var words;
      try {
        words = JSON.parse(el.getAttribute('data-words') || '[]');
      } catch (e) {
        words = [];
      }
      var text = $('[data-rotator-text]', el);
      if (!text || words.length < 2 || reduce) {
        return;
      }
      var i = 0;
      var chars = words[0].length;
      var deleting = true;
      var wait = 2200;

      function tick() {
        var word = words[i];
        var delay = 55;
        if (d.hidden) {
          setTimeout(tick, 500);
          return;
        }
        if (wait > 0) {
          delay = wait;
          wait = 0;
        } else if (deleting) {
          chars--;
          text.textContent = word.slice(0, Math.max(0, chars));
          delay = 32;
          if (chars <= 0) {
            deleting = false;
            i = (i + 1) % words.length;
            delay = 250;
          }
        } else {
          word = words[i];
          chars++;
          text.textContent = word.slice(0, chars);
          delay = 60 + Math.random() * 40;
          if (chars >= word.length) {
            deleting = true;
            wait = 2000;
          }
        }
        setTimeout(tick, delay);
      }
      setTimeout(tick, 1800);
    });
  }

  function initCounters() {
    $$('[data-count]').forEach(function (el) {
      var target = parseInt(el.getAttribute('data-count'), 10) || 0;
      if (reduce || target === 0) {
        return;
      }
      var fmt = function (n) {
        return Math.round(n).toLocaleString();
      };
      el.textContent = '0';
      onVisible(el, function () {
        var start = null;
        var dur = 1800;
        function step(t) {
          if (start === null) {
            start = t;
          }
          var p = Math.min(1, (t - start) / dur);
          var eased = 1 - Math.pow(1 - p, 4);
          el.textContent = fmt(target * eased);
          if (p < 1) {
            w.requestAnimationFrame(step);
          }
        }
        w.requestAnimationFrame(step);
      }, { threshold: 0.6 });
    });
  }

  function initTilt() {
    if (!fine || reduce) {
      return;
    }
    var tilt = fx('tilt');
    $$('[data-tilt], [data-spot]').forEach(function (el) {
      var raf = null;
      var useTilt = tilt && el.hasAttribute('data-tilt');
      var max = el.classList.contains('pw-console') || el.classList.contains('pw-chat') ? 5 : 7;
      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        var x = e.clientX - r.left;
        var y = e.clientY - r.top;
        if (raf) {
          w.cancelAnimationFrame(raf);
        }
        raf = w.requestAnimationFrame(function () {
          el.style.setProperty('--mx', x + 'px');
          el.style.setProperty('--my', y + 'px');
          if (useTilt) {
            var px = x / r.width - 0.5;
            var py = y / r.height - 0.5;
            el.classList.add('is-tilting');
            el.style.setProperty('--ry', (px * max).toFixed(2) + 'deg');
            el.style.setProperty('--rx', (-py * max).toFixed(2) + 'deg');
          }
        });
      });
      el.addEventListener('pointerleave', function () {
        if (raf) {
          w.cancelAnimationFrame(raf);
        }
        el.classList.remove('is-tilting');
        el.style.setProperty('--rx', '0deg');
        el.style.setProperty('--ry', '0deg');
      });
    });
  }

  function initMagnetic() {
    if (!fine || reduce || !fx('magnetic')) {
      return;
    }
    $$('[data-magnetic]').forEach(function (el) {
      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        var x = (e.clientX - r.left - r.width / 2) * 0.28;
        var y = (e.clientY - r.top - r.height / 2) * 0.38;
        el.style.setProperty('--mx', x.toFixed(1) + 'px');
        el.style.setProperty('--my', y.toFixed(1) + 'px');
      });
      el.addEventListener('pointerleave', function () {
        el.style.setProperty('--mx', '0px');
        el.style.setProperty('--my', '0px');
      });
    });
  }

  function initCursor() {
    var cursor = $('[data-cursor]');
    if (!cursor || !fine || reduce) {
      return;
    }
    var dot = $('.pw-cursor__dot', cursor);
    var ring = $('.pw-cursor__ring', cursor);
    var mx = -100;
    var my = -100;
    var rx = -100;
    var ry = -100;
    var running = false;

    function loop() {
      rx += (mx - rx) * 0.18;
      ry += (my - ry) * 0.18;
      ring.style.transform = 'translate3d(' + rx.toFixed(1) + 'px,' + ry.toFixed(1) + 'px,0)';
      if (Math.abs(mx - rx) > 0.1 || Math.abs(my - ry) > 0.1) {
        w.requestAnimationFrame(loop);
      } else {
        running = false;
      }
    }

    d.addEventListener('pointermove', function (e) {
      if (e.pointerType !== 'mouse') {
        return;
      }
      mx = e.clientX;
      my = e.clientY;
      dot.style.transform = 'translate3d(' + mx + 'px,' + my + 'px,0)';
      cursor.classList.add('is-visible');
      if (!running) {
        running = true;
        w.requestAnimationFrame(loop);
      }
    }, { passive: true });

    d.addEventListener('pointerover', function (e) {
      var t = e.target.closest ? e.target.closest('a, button, summary, select, input, textarea, label, [data-tilt]') : null;
      cursor.classList.toggle('is-hover', !!t);
    });

    d.addEventListener('mouseleave', function () {
      cursor.classList.remove('is-visible');
    });
  }

  function initHeroArt() {
    var art = $('[data-hero-art-inner]');
    var hero = $('.pw-hero');
    if (!art || !hero || reduce || !fine) {
      return;
    }
    var raf = null;
    hero.addEventListener('pointermove', function (e) {
      var r = hero.getBoundingClientRect();
      var px = (e.clientX - r.left) / r.width - 0.5;
      var py = (e.clientY - r.top) / r.height - 0.5;
      if (raf) {
        w.cancelAnimationFrame(raf);
      }
      raf = w.requestAnimationFrame(function () {
        art.style.transform = 'perspective(900px) rotateY(' + (px * 16).toFixed(2) + 'deg) rotateX(' + (-py * 12).toFixed(2) + 'deg) translate3d(' + (px * 24).toFixed(1) + 'px,' + (py * 18).toFixed(1) + 'px,0)';
      });
    });
    hero.addEventListener('pointerleave', function () {
      art.style.transform = '';
    });
  }

  function initWeb() {
    var canvas = $('[data-web]');
    if (!canvas || reduce || !canvas.getContext) {
      return;
    }
    var ctx = canvas.getContext('2d');
    var hero = canvas.closest('.pw-hero');
    var dpr = Math.min(w.devicePixelRatio || 1, 2);
    var width = 0;
    var height = 0;
    var nodes = [];
    var mouse = { x: -9999, y: -9999, active: false };
    var visible = true;
    var rafId = null;
    var colors = [cssVar('--a1-rgb'), cssVar('--a2-rgb'), cssVar('--a3-rgb')].map(function (c) {
      return c.replace(/\s/g, '') || '255,138,61';
    });
    var linkDist = 130;

    function resize() {
      var r = canvas.getBoundingClientRect();
      width = r.width;
      height = r.height;
      canvas.width = Math.round(width * dpr);
      canvas.height = Math.round(height * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      var count = Math.round(Math.min(95, Math.max(28, (width * height) / 15000)));
      linkDist = width < 640 ? 100 : 135;
      nodes = [];
      for (var i = 0; i < count; i++) {
        nodes.push({
          x: Math.random() * width,
          y: Math.random() * height,
          vx: (Math.random() - 0.5) * 0.35,
          vy: (Math.random() - 0.5) * 0.35,
          r: Math.random() * 1.6 + 0.6,
          c: colors[i % colors.length]
        });
      }
    }

    function frame() {
      ctx.clearRect(0, 0, width, height);
      var i;
      var j;
      var n;
      var m;
      var dx;
      var dy;
      var dist;
      for (i = 0; i < nodes.length; i++) {
        n = nodes[i];
        if (mouse.active) {
          dx = mouse.x - n.x;
          dy = mouse.y - n.y;
          dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 200 && dist > 1) {
            n.vx += (dx / dist) * 0.012;
            n.vy += (dy / dist) * 0.012;
          }
        }
        n.vx *= 0.992;
        n.vy *= 0.992;
        var speed = Math.sqrt(n.vx * n.vx + n.vy * n.vy);
        if (speed < 0.12) {
          n.vx += (Math.random() - 0.5) * 0.04;
          n.vy += (Math.random() - 0.5) * 0.04;
        }
        if (speed > 1.4) {
          n.vx *= 0.9;
          n.vy *= 0.9;
        }
        n.x += n.vx;
        n.y += n.vy;
        if (n.x < -20) { n.x = width + 20; }
        if (n.x > width + 20) { n.x = -20; }
        if (n.y < -20) { n.y = height + 20; }
        if (n.y > height + 20) { n.y = -20; }
      }
      ctx.lineWidth = 0.7;
      for (i = 0; i < nodes.length; i++) {
        n = nodes[i];
        for (j = i + 1; j < nodes.length; j++) {
          m = nodes[j];
          dx = n.x - m.x;
          dy = n.y - m.y;
          if (Math.abs(dx) > linkDist || Math.abs(dy) > linkDist) {
            continue;
          }
          dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < linkDist) {
            ctx.strokeStyle = 'rgba(' + n.c + ',' + ((1 - dist / linkDist) * 0.32).toFixed(3) + ')';
            ctx.beginPath();
            ctx.moveTo(n.x, n.y);
            ctx.lineTo(m.x, m.y);
            ctx.stroke();
          }
        }
        if (mouse.active) {
          dx = n.x - mouse.x;
          dy = n.y - mouse.y;
          dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 190) {
            ctx.strokeStyle = 'rgba(' + n.c + ',' + ((1 - dist / 190) * 0.6).toFixed(3) + ')';
            ctx.beginPath();
            ctx.moveTo(n.x, n.y);
            ctx.lineTo(mouse.x, mouse.y);
            ctx.stroke();
          }
        }
        ctx.fillStyle = 'rgba(' + n.c + ',.9)';
        ctx.beginPath();
        ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
        ctx.fill();
      }
      rafId = visible && !d.hidden ? w.requestAnimationFrame(frame) : null;
    }

    function start() {
      if (!rafId && visible && !d.hidden) {
        rafId = w.requestAnimationFrame(frame);
      }
    }

    resize();
    var resizeTimer;
    w.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(resize, 200);
    });

    if (hero && fine) {
      hero.addEventListener('pointermove', function (e) {
        var r = canvas.getBoundingClientRect();
        mouse.x = e.clientX - r.left;
        mouse.y = e.clientY - r.top;
        mouse.active = true;
      });
      hero.addEventListener('pointerleave', function () {
        mouse.active = false;
      });
    }

    if (hasIO) {
      new IntersectionObserver(function (entries) {
        visible = entries[0].isIntersecting;
        if (visible) {
          start();
        }
      }).observe(canvas);
    }

    d.addEventListener('visibilitychange', start);
    start();
  }

  function initSteps() {
    var wrap = $('[data-steps]');
    if (!wrap) {
      return;
    }
    var steps = $$('[data-step]', wrap);
    var ticking = false;
    function update() {
      var r = wrap.getBoundingClientRect();
      var vh = w.innerHeight;
      var vertical = w.innerWidth <= 960;
      var p = (vh * 0.75 - r.top) / (r.height + (vertical ? 0 : vh * 0.15));
      p = Math.max(0, Math.min(1, p));
      wrap.style.setProperty('--p', p.toFixed(3));
      var active = Math.ceil(p * steps.length - 0.15);
      steps.forEach(function (s, i) {
        s.classList.toggle('is-active', i < active);
      });
      ticking = false;
    }
    w.addEventListener('scroll', function () {
      if (!ticking) {
        ticking = true;
        w.requestAnimationFrame(update);
      }
    }, { passive: true });
    w.addEventListener('resize', update);
    update();
  }

  function initFaq() {
    $$('[data-faq]').forEach(function (item) {
      var summary = $('summary', item);
      var bodyEl = $('[data-faq-body]', item);
      if (!summary || !bodyEl || reduce || !bodyEl.animate) {
        return;
      }
      var anim = null;
      summary.addEventListener('click', function (e) {
        e.preventDefault();
        if (anim) {
          anim.cancel();
        }
        if (item.open) {
          var h = bodyEl.offsetHeight;
          anim = bodyEl.animate([{ height: h + 'px', opacity: 1 }, { height: '0px', opacity: 0 }], { duration: 380, easing: 'cubic-bezier(.2,.8,.2,1)' });
          anim.onfinish = function () {
            item.open = false;
            anim = null;
          };
        } else {
          item.open = true;
          var target = bodyEl.offsetHeight;
          anim = bodyEl.animate([{ height: '0px', opacity: 0 }, { height: target + 'px', opacity: 1 }], { duration: 460, easing: 'cubic-bezier(.16,1,.3,1)' });
          anim.onfinish = function () {
            anim = null;
          };
        }
      });
    });
  }

  function initChat() {
    var chat = $('[data-chat]');
    if (!chat || reduce) {
      return;
    }
    var msgs = $$('[data-chat-msg]', chat);
    if (!msgs.length) {
      return;
    }
    msgs.forEach(function (m) {
      m.textContent = '';
      m.classList.add('is-pending');
    });

    function type(el, text, speed, done) {
      el.classList.remove('is-pending');
      el.classList.add('is-typing');
      var i = 0;
      function next() {
        i++;
        el.textContent = text.slice(0, i);
        if (i < text.length) {
          setTimeout(next, speed + Math.random() * speed);
        } else {
          el.classList.remove('is-typing');
          if (done) {
            done();
          }
        }
      }
      next();
    }

    onVisible(chat, function () {
      var user = msgs[0];
      var ai = msgs[1];
      setTimeout(function () {
        type(user, user.getAttribute('data-full') || '', 22, function () {
          if (!ai) {
            return;
          }
          chat.classList.add('is-thinking');
          setTimeout(function () {
            chat.classList.remove('is-thinking');
            type(ai, ai.getAttribute('data-full') || '', 14);
          }, 1300);
        });
      }, 500);
    }, { threshold: 0.4 });
  }

  function initFooterSpot() {
    var big = $('.pw-footer__big');
    if (!big || !fine) {
      return;
    }
    big.addEventListener('pointermove', function (e) {
      var r = big.getBoundingClientRect();
      big.style.setProperty('--mx', (e.clientX - r.left) + 'px');
      big.style.setProperty('--my', (e.clientY - r.top) + 'px');
    });
  }

  function init() {
    root.classList.add('pw-ready');
    body.classList.add('pw-ready');
    initHeader();
    initNav();
    initReveal();
    initRotator();
    initCounters();
    initTilt();
    initMagnetic();
    initCursor();
    initHeroArt();
    initWeb();
    initSteps();
    initFaq();
    initChat();
    initFooterSpot();
  }

  if (d.readyState === 'loading') {
    d.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
