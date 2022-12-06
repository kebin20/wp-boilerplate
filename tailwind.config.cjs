/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}", "*.php"],
  theme: {
    height: {
      screen: "calc(var(--js-vh) * 100)",
    },
  },
  plugins: [require("@tailwindcss/typography")],
};
