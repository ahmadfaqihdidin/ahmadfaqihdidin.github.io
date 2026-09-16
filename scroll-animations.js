/**
 * ============================================================================
 * CINEMATIC PARALLAX & 3D INTERACTION ENGINE
 * Ahmad Faqih Imaduddin - HSE & Training Professional Portfolio
 * ============================================================================
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

        // ========================================================================
        // 1. SCROLL PARALLAX ENGINE (Multi-Layer Depth via RAF & Lerp)
        // ========================================================================
        const heroSection = document.querySelector('.hero-gradient');
        const heroWatermark = document.getElementById('hero-watermark') || document.querySelector('.hero-gradient .absolute.inset-x-0 span');
        const heroPortrait = document.getElementById('hero-portrait-img') || document.querySelector('.hero-gradient video, .hero-gradient img');
        const heroCard = document.getElementById('hero-status-card');

        if (heroPortrait && heroPortrait.tagName === 'VIDEO') {
            heroPortrait.play().catch(() => {});
        }

        let currentScrollY = window.scrollY || 0;
        let targetScrollY = currentScrollY;
        let isHeroVisible = true;

        if (heroSection) {
            const heroObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    isHeroVisible = entry.isIntersecting;
                });
            }, { threshold: 0 });
            heroObserver.observe(heroSection);
        }

        function updateScrollParallax() {
            if (!prefersReducedMotion && isHeroVisible) {
                targetScrollY = window.scrollY || document.documentElement.scrollTop;
                // Linear interpolation for silky smooth movement
                currentScrollY += (targetScrollY - currentScrollY) * 0.12;

                const scrollOffset = currentScrollY;

                // Hero Watermark typography drifts downward with deep background speed
                if (heroWatermark) {
                    heroWatermark.style.transform = `translate3d(0, ${scrollOffset * 0.35}px, 0)`;
                }

                // Hero Portrait moves slightly upward for multi-plane camera depth
                if (heroPortrait && scrollOffset < 800) {
                    heroPortrait.style.transform = `translate3d(0, ${scrollOffset * -0.08}px, 0)`;
                }

                // Floating Hero pill card
                if (heroCard && scrollOffset < 800) {
                    heroCard.style.transform = `translate3d(0, ${scrollOffset * -0.14}px, 0)`;
                }
            }

            requestAnimationFrame(updateScrollParallax);
        }

        requestAnimationFrame(updateScrollParallax);

        // ========================================================================
        // 2. INTERACTIVE 3D MOUSE PARALLAX (Hero Section Depth)
        // ========================================================================
        if (!prefersReducedMotion && !isTouchDevice && heroSection) {
            let mouseX = 0, mouseY = 0;
            let targetMouseX = 0, targetMouseY = 0;

            heroSection.addEventListener('mousemove', (e) => {
                const rect = heroSection.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                targetMouseX = x * 30; // Max tilt / translation pixels
                targetMouseY = y * 30;
            });

            heroSection.addEventListener('mouseleave', () => {
                targetMouseX = 0;
                targetMouseY = 0;
            });

            function renderMouseParallax() {
                if (isHeroVisible) {
                    mouseX += (targetMouseX - mouseX) * 0.08;
                    mouseY += (targetMouseY - mouseY) * 0.08;

                    if (heroWatermark) {
                        heroWatermark.style.translate = `${-mouseX * 0.6}px ${-mouseY * 0.6}px`;
                    }
                    if (heroPortrait) {
                        heroPortrait.style.translate = `${mouseX * 0.5}px ${mouseY * 0.5}px`;
                    }
                }
                requestAnimationFrame(renderMouseParallax);
            }

            requestAnimationFrame(renderMouseParallax);
        }

        // ========================================================================
        // 3. 3D CARD TILT & SPECULAR GLOW SHINE (Interactive Cards with Lift & Click Animation)
        // ========================================================================
        const interactiveCards = document.querySelectorAll('.project-card, .card-hover-effect, #about-photo-card');

        if (!prefersReducedMotion && !isTouchDevice) {
            interactiveCards.forEach((card) => {
                card.classList.add('tilt-card');

                let isDown = false;

                card.addEventListener('mousemove', (e) => {
                    if (isDown) return;
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -5;
                    const rotateY = ((x - centerX) / centerX) * 5;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
                    card.style.setProperty('--mouse-x', `${(x / rect.width) * 100}%`);
                    card.style.setProperty('--mouse-y', `${(y / rect.height) * 100}%`);
                });

                card.addEventListener('mousedown', () => {
                    isDown = true;
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(-2px) scale(0.99)';
                });

                window.addEventListener('mouseup', () => {
                    if (isDown) {
                        isDown = false;
                        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(-5px)';
                    }
                });

                card.addEventListener('mouseleave', () => {
                    isDown = false;
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0)';
                });
            });
        }

        // ========================================================================
        // 4. NAVBAR ELEVATION ON SCROLL
        // ========================================================================
        const header = document.querySelector('header');
        if (header) {
            const onScrollHeader = () => {
                const scrolled = window.scrollY > 20;
                if (scrolled) {
                    header.classList.add('shadow-md', 'bg-white/95');
                    header.classList.remove('bg-white/90');
                } else {
                    header.classList.remove('shadow-md', 'bg-white/95');
                    header.classList.add('bg-white/90');
                }
            };
            window.addEventListener('scroll', onScrollHeader, { passive: true });
            onScrollHeader();
        }
    });
})();
