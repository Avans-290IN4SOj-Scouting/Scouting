
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "node_modules/preline/dist/*.js"
    ],
    safelist: [
        'toast-info',
        'toast-success',
        'toast-warning',
        'toast-error',
    ],
    theme: {
        screens: {
            'sm': '640px',
            'md': '768px',
            'test': '990px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        }
    },
    plugins: [
        require('preline/plugin')
    ],
}


