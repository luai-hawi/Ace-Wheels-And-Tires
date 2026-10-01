import './bootstrap';
import Alpine from 'alpinejs';
import { initScrollReveal } from './scroll-reveal';
import { registerPopupWidget } from './popup-widget';

window.Alpine = Alpine;
registerPopupWidget(Alpine);
Alpine.start();

window.handleImageLoadError = function (img) {
    if (img && img.parentElement) {
        img.parentElement.style.display = 'none';
    }
};

document.addEventListener('DOMContentLoaded', initScrollReveal);
