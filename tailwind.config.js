
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
        'cancelled',
        'payment_refunded',
        'awaiting_payment',
        'processing',
        'delivered',
        'finalized',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('preline/plugin')
    ],
}


