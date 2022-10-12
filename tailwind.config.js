const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['IBM Plex Sans Thai', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [{
            mytheme: {

                "primary": "#440a54",

                "secondary": "#D5B9DD",

                "accent": "#37CDBE",

                "neutral": "#3D4451",

                "base-100": "#FFFFFF",

                "info": "#3ABFF8",

                "success": "#36D399",

                "warning": "#FBBD23",

                "error": "#F87272",
            },
        }, ],
    },

    // plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require("daisyui")]
};
