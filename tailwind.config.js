import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        // Section/SectionItem models emit literal Tailwind class names for the
        // admin-configurable text styling feature — scan them too so those
        // utilities actually get compiled into the CSS bundle.
        './app/**/*.php',
    ],
    safelist: [
        // Best-effort coverage for whatever an admin types into a "custom
        // HTML / CSS / Tailwind" box — these never appear literally in our own
        // Blade files, so without a safelist they'd be purged from the build.
        { pattern: /^(bg|text)-(white|black|brand-dark|brand-red|brand-light)$/ },
        { pattern: /^(bg|text|border)-(red|blue|green|yellow|gray|slate|orange|amber)-(100|200|300|400|500|600|700|800|900)$/ },
        { pattern: /^text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl)$/ },
        { pattern: /^font-(light|normal|medium|semibold|bold|extrabold)$/ },
        { pattern: /^(p|m|px|py|mx|my|pt|pb|pl|pr|mt|mb|ml|mr|gap)-(0|1|2|3|4|5|6|8|10|12|16|20)$/ },
        { pattern: /^(rounded)(-(sm|md|lg|xl|2xl|3xl|full))?$/ },
        { pattern: /^shadow(-(sm|md|lg|xl|2xl))?$/ },
        { pattern: /^(flex|grid|hidden|block|inline-block|inline-flex|items-center|justify-center|justify-between|text-center|text-left|text-right|uppercase|italic|underline)$/ },
    ],
    theme: {
        extend: {
            // Brand tokens pulled from the original Ace Wheels & Tires site.
            colors: {
                brand: {
                    dark: '#242424',
                    red: '#e81926',
                    'red-dark': '#b81420',
                    light: '#f4f4f4',
                },
            },
            fontFamily: {
                heading: ['Oswald', 'sans-serif'],
                body: ['Montserrat', 'sans-serif'],
            },
            maxWidth: {
                content: '1200px',
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: 0, transform: 'translateY(24px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
                'zoom-in': {
                    '0%': { opacity: 0, transform: 'scale(0.92)' },
                    '100%': { opacity: 1, transform: 'scale(1)' },
                },
                'slide-in-right': {
                    '0%': { opacity: 0, transform: 'translateX(40px)' },
                    '100%': { opacity: 1, transform: 'translateX(0)' },
                },
                'slide-in-left': {
                    '0%': { opacity: 0, transform: 'translateX(-40px)' },
                    '100%': { opacity: 1, transform: 'translateX(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-8px)' },
                },
                'pulse-ring': {
                    '0%': { boxShadow: '0 0 0 0 rgba(232, 25, 38, 0.45)' },
                    '100%': { boxShadow: '0 0 0 14px rgba(232, 25, 38, 0)' },
                },
            },
            animation: {
                'fade-up': 'fade-up 0.7s ease-out both',
                'fade-in': 'fade-in 0.8s ease-out both',
                'zoom-in': 'zoom-in 0.7s ease-out both',
                'slide-in-right': 'slide-in-right 0.6s ease-out both',
                'slide-in-left': 'slide-in-left 0.6s ease-out both',
                float: 'float 3.5s ease-in-out infinite',
                'pulse-ring': 'pulse-ring 2.2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
        },
    },
    plugins: [forms],
};
