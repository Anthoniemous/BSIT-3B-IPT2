const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'dark-green': '#142C14',
                'cal-poly-green': '#2D5128',
                'fern-green': '#537B2F',
                'asparagus': '#8DA750',
                'mindaro': '#E4EB9C',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
