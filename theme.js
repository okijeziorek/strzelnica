(function () {
    'use strict';

    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.primary-nav');
    const body = document.body;

    function closeMenu(restoreFocus) {
        if (!toggle || !nav) {
            return;
        }
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Otwórz menu');
        nav.classList.remove('is-open');
        body.classList.remove('menu-open');
        if (restoreFocus) {
            toggle.focus();
        }
    }

    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            const willOpen = toggle.getAttribute('aria-expanded') !== 'true';
            toggle.setAttribute('aria-expanded', String(willOpen));
            toggle.setAttribute('aria-label', willOpen ? 'Zamknij menu' : 'Otwórz menu');
            nav.classList.toggle('is-open', willOpen);
            body.classList.toggle('menu-open', willOpen);
        });

        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                closeMenu(false);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && nav.classList.contains('is-open')) {
                closeMenu(true);
            }
        });

        document.addEventListener('click', function (event) {
            if (nav.classList.contains('is-open') && !nav.contains(event.target) && !toggle.contains(event.target)) {
                closeMenu(false);
            }
        });
    }

    const serviceSelect = document.getElementById('service');
    document.querySelectorAll('.js-booking-link[data-service]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!serviceSelect) {
                return;
            }
            const requestedService = link.getAttribute('data-service');
            const matchingOption = Array.from(serviceSelect.options).find(function (option) {
                return option.value === requestedService;
            });
            if (matchingOption) {
                serviceSelect.value = requestedService;
                serviceSelect.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });

    const sections = Array.from(document.querySelectorAll('main section[id], footer[id]'));
    const navLinks = Array.from(document.querySelectorAll('.nav-list a[href*="#"]'));
    if ('IntersectionObserver' in window && sections.length && navLinks.length) {
        const linkMap = new Map();
        navLinks.forEach(function (link) {
            const hash = new URL(link.href, window.location.href).hash;
            if (hash) {
                linkMap.set(hash.slice(1), link);
            }
        });

        const observer = new IntersectionObserver(function (entries) {
            const visible = entries
                .filter(function (entry) { return entry.isIntersecting; })
                .sort(function (a, b) { return b.intersectionRatio - a.intersectionRatio; })[0];

            if (!visible || !linkMap.has(visible.target.id)) {
                return;
            }
            navLinks.forEach(function (link) { link.removeAttribute('aria-current'); });
            linkMap.get(visible.target.id).setAttribute('aria-current', 'location');
        }, { rootMargin: '-35% 0px -55% 0px', threshold: [0, 0.15, 0.4] });

        sections.forEach(function (section) { observer.observe(section); });
    }

    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function () {
            const button = bookingForm.querySelector('.form-submit');
            if (button) {
                button.disabled = true;
                button.textContent = 'Wysyłanie…';
            }
        });
    }
})();
