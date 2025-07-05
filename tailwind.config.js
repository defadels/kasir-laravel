import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Backgrounds
        {
            pattern: /bg-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        // Text colors
        {
            pattern: /text-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        // Borders
        {
            pattern: /border-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        // Ring colors
        {
            pattern: /ring-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        // Hover states
        {
            pattern: /hover:bg-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        // Focus states
        {
            pattern: /focus:bg-(gray|red|yellow|green|blue|indigo|purple)-(50|100|200|300|400|500|600|700|800|900)/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
