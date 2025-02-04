import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                Poppins: ["Poppins", "sans-serif"],
                Opensans: ["Open Sans", "sans-serif"],
            },
            colors: {
                ungumain: "#7E5DC1",
                ungusec: "#EB3678",
                goldmain: "#FCF596",
                goldsec: "#FBD288",
            },
            animation: {
                "loop-scroll": "loop-scroll 24s linear infinite",
            },
            keyframes: {
                "loop-scroll": {
                    from: { transform: "translateX(0)" },
                    to: { transform: "translateX(-100%)" },
                },
            },
        },
    },

    plugins: [forms],
};
