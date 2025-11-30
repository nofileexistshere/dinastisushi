/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "primary-background": "#fff7ed", //ini orange muda
        "primary-navbar": "#ffedd5", //ini orange apa ya
        "primary-dashboard": "#FF8C00", //ini orange terang
        "primary-button": "#F57C00", //ini orange agak gelap
        "primary-card": "#E65100", //ini orange gelap banget
      },
    },
  },
  plugins: [],
}
