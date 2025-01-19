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
            colors: {

                // $blue-50: #eff6ff;
                // $blue-100: #dbeafe;
                // $blue-200: #bfdbfe;
                // $blue-300: #93c5fd;
                // $blue-400: #60a5fa;
                // $blue-500: #3b82f6;
                // $blue-600: #2563eb;
                // $blue-700: #1d4ed8;
                // $blue-800: #1e40af;
                // $blue-900: #1e3a8a;

                // $gray-50: #f9fafb;
                // $gray-100: #f3f4f6;
                // $gray-200: #e5e7eb;
                // $gray-300: #d1d5db;
                // $gray-400: #9ca3af;
                // $gray-500: #6b7280;
                // $gray-600: #4b5563;
                // $gray-700: #374151;
                // $gray-800: #1f2937;
                // $gray-900: #111827;

                // $indigo-50: #eef2ff;
                // $indigo-100: #e0e7ff;
                // $indigo-200: #c7d2fe;
                // $indigo-300: #a5b4fc;
                // $indigo-400: #818cf8;
                // $indigo-500: #6366f1;
                // $indigo-600: #4f46e5;
                // $indigo-700: #4338ca;
                // $indigo-800: #3730a3;
                // $indigo-900: #312e81;


                'light-': {
                    'bg': '#f3f4f6',
                    'text': '#1f2937',

                    'header': {
                        'bg': '#ffffff',
                    },
                    'nav': {
                        'bg': '#ffffff',
                        'border': '#f3f4f6',

                        'link': {
                            'active-': {
                                'border': '#6366f1',
                                'hover': '#6366f1',
                                'text': '#111827',
                            },
                            'inactive-': {
                                'focus': '#374151',
                                'hover': '#4b5563',
                                'text': '#6b7280',
                            }
                        },

                    },
                    'reusable': {
                        'bg': '#ffffff',
                    },
                    'svg': {
                        'icon': {
                            'primary': '#3b82f6',
                            'secondary': '#3b82f6',
                            'danger': '#ef4444',
                        }
                    },

                },

                'dark-': {
                    'bg': '#111827',
                    'text': '#e5e7eb',

                    'header': {
                        'bg': '#1f2937',
                    },
                    'nav': {
                        'bg': '#1f2937',
                        'border': '#374151',
                        'link': {
                            'active-': {
                                'border': '#4338ca',
                                'hover': '#818cf8',
                                'text': '#e5e7eb',
                            },
                            'inactive-': {
                                'focus': '#d1d5db',
                                'text': '#9ca3af',
                                'hover': '#6b7280',
                            }
                        },
                    },
                    'reusable': {
                        'bg': '#1f2937',
                    },
                    'svg': {
                        'icon': {
                            'primary': '#93c5fd',
                            'secondary': '#60a5fa',
                            'danger': '#f87171',
                        }
                    },
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
            });
        }),
    ],
};
