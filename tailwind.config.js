import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                surface: {
                    DEFAULT: '#F8FAFC',
                    dark: '#0F172A',
                },
                premium: {
                    50: '#EEF2FF',
                    100: '#E0E7FF',
                    200: '#C7D2FE',
                    300: '#A5B4FC',
                    400: '#818CF8',
                    500: '#6366F1',
                    600: '#4F46E5',
                    700: '#4338CA',
                    800: '#3730A3',
                    900: '#312E81',
                },
            },

            boxShadow: {
                'soft': '0 1px 3px 0 rgba(0,0,0,0.03), 0 1px 2px -1px rgba(0,0,0,0.02)',
                'card': '0 1px 4px 0 rgba(0,0,0,0.04), 0 2px 8px -1px rgba(0,0,0,0.03)',
                'card-hover': '0 4px 16px -2px rgba(0,0,0,0.06), 0 2px 8px -1px rgba(0,0,0,0.03)',
                'elevated': '0 8px 32px -4px rgba(0,0,0,0.08), 0 2px 8px -1px rgba(0,0,0,0.04)',
                'modal': '0 16px 48px -8px rgba(0,0,0,0.12), 0 4px 16px -2px rgba(0,0,0,0.06)',
                'dark-soft': '0 1px 3px 0 rgba(0,0,0,0.2), 0 1px 2px -1px rgba(0,0,0,0.15)',
                'dark-card': '0 1px 4px 0 rgba(0,0,0,0.25), 0 2px 8px -1px rgba(0,0,0,0.2)',
                'dark-elevated': '0 8px 32px -4px rgba(0,0,0,0.4), 0 2px 8px -1px rgba(0,0,0,0.3)',
            },

            animation: {
                'fade-in': 'fadeIn 0.2s ease-out',
                'fade-in-up': 'fadeInUp 0.35s ease-out',
                'slide-in-right': 'slideInRight 0.3s ease-out',
                'scale-in': 'scaleIn 0.2s ease-out',
                'spin-slow': 'spin 2s linear infinite',
                'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                'float': 'float 3s ease-in-out infinite',
            },

            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(8px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-4px)' },
                },
            },

            transitionTimingFunction: {
                'out-expo': 'cubic-bezier(0.16, 1, 0.3, 1)',
                'out-quart': 'cubic-bezier(0.25, 1, 0.5, 1)',
            },
        },
    },

    plugins: [forms],
};
