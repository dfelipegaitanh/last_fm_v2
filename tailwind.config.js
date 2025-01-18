import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // darkMode: 'selector',
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'light-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.25), 0 4px 6px -2px rgba(0, 0, 0, 0.15)',
                'dark-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.8), 0 4px 6px -2px rgba(0, 0, 0, 0.7)',
                'light-hover': '0 20px 30px -5px rgba(0, 0, 0, 0.5), 0 8px 12px -3px rgba(0, 0, 0, 0.35)',
                'dark-hover': '0 20px 30px -5px rgba(0, 0, 0, 1), 0 8px 12px -3px rgba(0, 0, 0, 0.95)',
            },
        },
    },

    plugins: [
        forms,
        plugin(function ({addUtilities}) {
            addUtilities({
                '.transition-colors-base': {
                    transitionProperty: 'color, background-color, border-color, text-decoration-color, fill, stroke',
                    transitionTimingFunction: 'ease-in-out',
                    transitionDuration: '200ms',
                },
            });
        }),
    ],
};
