/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "node_modules/preline/dist/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('preline/plugin')
  ],
}

