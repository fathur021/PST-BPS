/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        // "node_modules/preline/dist/*.js",
        
    ],
    theme: {
        extend: {
            colors: {
                grey: "#EEEEEE",
                lightYellow: "#fd9e02",
                darkBlue: "#031d44",
                lightBlue: "#04395e",
                darkGreen: "#70a288",
                darkRed: "#d5896f",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
