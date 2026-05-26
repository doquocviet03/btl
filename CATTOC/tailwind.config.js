import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Be Vietnam Pro"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 22px 70px rgba(15, 23, 42, .10)',
            },
        },
    },
    plugins: [forms],
};
