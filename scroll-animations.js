/* Scroll transition & interactivity enhancements (self-contained). */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* 1) Hero entrance stagger (plays once on load) */
        if (!reducedMotion) {
            var heroOrder = [
                document.querySelector('main h1'),
                document.querySelector('main .order-first'),
                document.querySelector('[data-lang-key="heroSubGreeting"]'),
                document.querySelector('[data-lang-key="heroRole"]'),
                document.querySelector('[data-lang-key="heroGreeting"]')
            ];
            heroOrder.forEach(function (el, i) {
                if (!el) return;
                el.style.setProperty('--hero-delay', (i * 130) + 'ms');
                el.classList.add('hero-entrance');
            });
        }

        /* 2) Own reveal observer for enhancements (titles, footer) */
        var revealObserver = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { root: null, rootMargin: '0px', threshold: 0.1 });

        /* Section titles get an accent underline sweep when they reveal */
        document.querySelectorAll('main h2.fade-in-up, #contact h2').forEach(function (h2) {
            h2.classList.add('section-reveal');
            revealObserver.observe(h2);
        });

        /* 3) Cursor-following glow + shine sweep on cards */
        document.querySelectorAll('.card-hover-effect').forEach(function (card) {
            card.classList.add('glow-hover');
        });
        document.querySelectorAll('.project-card').forEach(function (card) {
            card.classList.add('shine');
        });
        document.querySelectorAll('.glow-hover').forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--gx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--gy', (e.clientY - r.top) + 'px');
            });
        });

        /* 4) Footer reveal: page bottom slides up over the footer */
        var footer = document.querySelector('footer');
        var main = document.querySelector('main');
        if (footer && main) {
            main.classList.add('relative', 'z-10');
            footer.classList.add('footer-reveal');
            revealObserver.observe(footer);
        }

        /* 5) Navbar elevates once the page is scrolled */
        var header = document.querySelector('header');
        if (header) {
            var onScrollHeader = function () {
                header.classList.toggle('is-scrolled', window.scrollY > 24);
            };
            window.addEventListener('scroll', onScrollHeader, { passive: true });
            onScrollHeader();
        }

        /* 6) Subtle parallax on the hero background text */
        var heroBgText = document.querySelector('.hero-gradient [data-lang-key="heroBgText"]');
        var hero = document.querySelector('.hero-gradient');
        if (heroBgText && hero && !reducedMotion) {
            window.addEventListener('scroll', function () {
                if (window.scrollY < hero.offsetHeight) {
                    heroBgText.style.transform = 'translateY(' + (window.scrollY * 0.18) + 'px)';
                }
            }, { passive: true });
        }
    });
})();
