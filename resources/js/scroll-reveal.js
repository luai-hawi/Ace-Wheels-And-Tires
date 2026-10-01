/**
 * Watches every [data-reveal] element and adds `.is-revealed` once it scrolls into view,
 * which triggers the CSS transition defined in app.css. Centralised here so every section
 * of the site gets the same scroll-in animation behaviour from one place.
 */
export function initScrollReveal() {
    const targets = document.querySelectorAll('[data-reveal]');

    if (!targets.length) {
        return;
    }

    // Skip the animation entirely for users who prefer reduced motion.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        targets.forEach((el) => el.classList.add('is-revealed'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const delay = entry.target.dataset.revealDelay || 0;
                setTimeout(() => entry.target.classList.add('is-revealed'), delay);
                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -50px 0px' }
    );

    targets.forEach((el) => observer.observe(el));
}
