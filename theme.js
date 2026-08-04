(function () {
    'use strict';

    const labels = window.groTheme || {};
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.primary-nav');
    const body = document.body;

    function closeMenu(restoreFocus) {
        if (!toggle || !nav) {
            return;
        }
        toggle.setAttribute('aria-expanded', 'false');
        if (labels.openMenu) {
            toggle.setAttribute('aria-label', labels.openMenu);
        }
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
            if (willOpen && labels.closeMenu) {
                toggle.setAttribute('aria-label', labels.closeMenu);
            } else if (!willOpen && labels.openMenu) {
                toggle.setAttribute('aria-label', labels.openMenu);
            }
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
    }

    const serviceSelect = document.getElementById('service');
    document.querySelectorAll('.js-booking-link[data-service]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!serviceSelect) {
                return;
            }
            const requestedService = link.getAttribute('data-service');
            const exists = Array.from(serviceSelect.options).some(function (option) {
                return option.value === requestedService;
            });
            if (exists) {
                serviceSelect.value = requestedService;
                serviceSelect.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });

    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function () {
            const button = bookingForm.querySelector('.form-submit');
            if (button) {
                button.disabled = true;
                if (labels.sending) {
                    button.textContent = labels.sending;
                }
            }
        });
    }
})();
