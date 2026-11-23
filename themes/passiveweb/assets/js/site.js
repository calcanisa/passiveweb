(() => {
	'use strict';

	const dialog = document.getElementById('pw-modal');

	if (!dialog || typeof dialog.showModal !== 'function') {
		return;
	}

	const triggers = Array.from(document.querySelectorAll('[data-pw-open]'));
	const ids = [];

	triggers.forEach((trigger) => {
		const id = trigger.dataset.pwOpen;
		if (id && !ids.includes(id)) {
			ids.push(id);
		}
	});

	if (ids.length === 0) {
		return;
	}

	const shot = dialog.querySelector('[data-pw-shot]');
	const info = dialog.querySelector('[data-pw-info]');
	const count = dialog.querySelector('[data-pw-count]');
	const host = dialog.querySelector('[data-pw-host]');
	const closeButton = dialog.querySelector('[data-pw-close]');
	const prevButton = dialog.querySelector('[data-pw-prev]');
	const nextButton = dialog.querySelector('[data-pw-next]');

	let current = null;
	let opener = null;

	const show = (id) => {
		const template = document.getElementById('pw-project-' + id);

		if (!template) {
			return false;
		}

		const fragment = template.content.cloneNode(true);
		const shotSource = fragment.querySelector('.pw-m-shot');
		const infoSource = fragment.querySelector('.pw-m-info');

		shot.replaceChildren(...(shotSource ? Array.from(shotSource.childNodes) : []));
		info.replaceChildren(...(infoSource ? [infoSource] : []));
		shot.scrollTop = 0;
		host.textContent = template.dataset.host || '';

		const position = ids.indexOf(id);
		count.textContent = 'Project ' + (position + 1) + ' of ' + ids.length;

		const single = ids.length < 2;
		prevButton.hidden = single;
		nextButton.hidden = single;

		current = id;
		return true;
	};

	const step = (direction) => {
		if (current === null) {
			return;
		}
		const index = Math.max(0, ids.indexOf(current));
		show(ids[(index + direction + ids.length) % ids.length]);
	};

	triggers.forEach((trigger) => {
		trigger.addEventListener('click', () => {
			if (!show(trigger.dataset.pwOpen)) {
				return;
			}
			opener = trigger;
			dialog.showModal();
			document.documentElement.classList.add('pw-lock');
			closeButton.focus();
		});
	});

	closeButton.addEventListener('click', () => dialog.close());
	prevButton.addEventListener('click', () => step(-1));
	nextButton.addEventListener('click', () => step(1));

	dialog.addEventListener('click', (event) => {
		if (event.target === dialog) {
			dialog.close();
		}
	});

	dialog.addEventListener('keydown', (event) => {
		if (event.key === 'ArrowRight') {
			event.preventDefault();
			step(1);
		} else if (event.key === 'ArrowLeft') {
			event.preventDefault();
			step(-1);
		}
	});

	dialog.addEventListener('close', () => {
		document.documentElement.classList.remove('pw-lock');
		shot.replaceChildren();
		info.replaceChildren();
		current = null;
		if (opener) {
			opener.focus();
		}
	});
})();
