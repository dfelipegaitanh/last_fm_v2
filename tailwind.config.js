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

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                // Colores para el modo claro
                'light': {
                    // Fondo y texto
                    'background': '#f3f4f6', // gray-100
                    'text': '#1f2937', // gray-800

                    // Header
                    'header-bg': '#ffffff', // white

                    // Navegación
                    'nav-bg': '#ffffff', // white
                    'nav-border': '#f3f4f6', // gray-100

                    // Navegación - Active
                    'nav-link-active-border': '#6366f1', // indigo-500
                    'nav-link-active-hover': '#6366f1', // indigo-500
                    'nav-link-active-text': '#111827', // gray-900
                    // Navegación - Inactive
                    'nav-link-inactive-focus': '#374151', // gray-700
                    'nav-link-inactive-hover': '#4b5563', // gray-600
                    'nav-link-inactive-text': '#6b7280', // gray-500

                    // Contenedor reutilizable
                    'reusable-bg': '#ffffff', // white

                    // Iconos SVG
                    'svg-icon-primary': '#3b82f6', // blue-500
                    'svg-icon-secondary': '#3b82f6', // blue-500
                    'svg-icon-danger': '#ef4444', // red-500

                    // Botón de configuración de usuario
                    'user-settings-button-bg': '#ffffff', // Blanco para fondo en light mode
                    'user-settings-button-text': '#6b7280', // Gray-500
                    'user-settings-button-hover-text': '#374151', // Gray-700

                    'button-bg': '#6366f1', // indigo-500
                    'button-bg-active': '#4f46e5', // indigo-600
                    'button-bg-hover': '#818cf8', // indigo-400
                    'button-ring-focus': '#93c5fd', // indigo-300
                    'button-ring-active': '#818cf8', // indigo-400
                    'button-text': '#ffffff', // white

                },
                // Colores para el modo oscuro
                'dark': {
                    // Fondo y texto
                    'background': '#111827', // gray-900
                    'text': '#e5e7eb', // gray-200

                    // Header
                    'header-bg': '#1f2937', // gray-800

                    // Navegación
                    'nav-bg': '#1f2937', // gray-800
                    'nav-border': '#374151', // gray-700

                    // Navegación - Active
                    'nav-link-active-border': '#4338ca', // indigo-700
                    'nav-link-active-hover': '#818cf8', // indigo-300
                    'nav-link-active-text': '#e5e7eb', // gray-200
                    // Navegación - Inactive
                    'nav-link-inactive-focus': '#d1d5db', // gray-300
                    'nav-link-inactive-hover': '#6b7280', // gray-500
                    'nav-link-inactive-text': '#9ca3af', // gray-400

                    // Contenedor reutilizable
                    'reusable-bg': '#1f2937', // gray-800

                    // Iconos SVG
                    'svg-icon-primary': '#93c5fd', // blue-300
                    'svg-icon-secondary': '#60a5fa', // blue-400
                    'svg-icon-danger': '#f87171', // red-300

                    // Botón de configuración de usuario
                    'user-settings-button-bg': '#1f2937', // Gray-800 para fondo en dark mode
                    'user-settings-button-text': '#9ca3af', // Gray-400
                    'user-settings-button-hover-text': '#e5e7eb', // Gray-200

                    'button-bg': '#4338ca', // indigo-700
                    'button-bg-active': '#3730a3', // indigo-800
                    'button-bg-hover': '#6366F1', // indigo-500
                    'button-ring-focus': '#6366f1', // indigo-500
                    'button-ring-active': '#4f46e5', // indigo-600
                    'button-text': '#e5e7eb', // gray-200
                }
            },

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
                '.interactive-transform': {
                    transitionProperty: 'transform',
                    transitionTimingFunction: 'ease-in-out',
                    transitionDuration: '300ms',
                    transform: 'scale(1)',
                    '&:active': {
                        transform: 'scale(0.9)',
                    },
                },
            });
        }),
    ],
};
