/**
 * Alpine component powering every admin-configurable center "ad" popup: decides
 * WHEN to reveal itself (trigger) and whether it's allowed to show again
 * (frequency), using session/local storage keyed per-popup so multiple popups
 * don't interfere with each other. Side-of-screen widgets render independently
 * (see components/promo-popup.blade.php) since they're meant to stay visible,
 * not gated by a trigger/frequency.
 */
export function registerPopupWidget(Alpine) {
    Alpine.data('popupWidget', (config) => ({
        open: false,
        config,

        init() {
            if (!this.canShow()) {
                return;
            }

            const reveal = () => {
                this.open = true;
                this.remember();
            };

            switch (this.config.trigger) {
                case 'on_load':
                    reveal();
                    break;
                case 'delay':
                    setTimeout(reveal, (this.config.triggerValue || 0) * 1000);
                    break;
                case 'scroll_percent': {
                    const onScroll = () => {
                        const max = document.body.scrollHeight - window.innerHeight;
                        const pct = max > 0 ? (window.scrollY / max) * 100 : 100;
                        if (pct >= (this.config.triggerValue || 50)) {
                            window.removeEventListener('scroll', onScroll);
                            reveal();
                        }
                    };
                    window.addEventListener('scroll', onScroll, { passive: true });
                    break;
                }
                case 'exit_intent': {
                    const onLeave = (event) => {
                        if (event.clientY < 8) {
                            document.removeEventListener('mouseout', onLeave);
                            reveal();
                        }
                    };
                    document.addEventListener('mouseout', onLeave);
                    break;
                }
            }
        },

        canShow() {
            if (this.config.frequency === 'every_visit') {
                return true;
            }

            const key = 'acewheels_popup_' + this.config.id;

            if (this.config.frequency === 'once_per_session') {
                return sessionStorage.getItem(key) !== '1';
            }

            const last = localStorage.getItem(key);
            if (!last) {
                return true;
            }
            if (this.config.frequency === 'once_ever') {
                return false;
            }

            // once_per_day
            return Date.now() - parseInt(last, 10) > 24 * 60 * 60 * 1000;
        },

        remember() {
            if (this.config.frequency === 'every_visit') {
                return;
            }

            const key = 'acewheels_popup_' + this.config.id;

            if (this.config.frequency === 'once_per_session') {
                sessionStorage.setItem(key, '1');
            } else {
                localStorage.setItem(key, Date.now().toString());
            }
        },
    }));
}
