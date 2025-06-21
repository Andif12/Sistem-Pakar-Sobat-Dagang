import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                istok: ['"Istok Web"', "sans-serif"],
            },

            colors: {
                primary: "#083458",
                "primary-dark": "#062b48",
                secondary: "#F49F1E",
                "secondary-dark": "#d88d13",
                link: "#0671E0",
            },
        },
    },
    plugins: [],
};
