/** @type {import('tailwindcss').Config} */

const plugin = require("tailwindcss/plugin");
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: ["./src/**/*.{html,js,php}", "*.php"],

  theme: {
    borderRadius: {
      none: "0",
      DEFAULT: "0.5rem", // 5px
      full: "999vw",
    },
    borderWidth: {
      DEFAULT: "1px",
    },
    boxShadow: {
      transparent: "0 0.1875rem 0.375rem rgba(0, 0, 0, 0);",
      DEFAULT: "0 0.1875rem 0.375rem rgba(0, 0, 0, 0.3);",
    },
    colors: {
      // system
      curr: "currentColor",
      transparent: "transparent",

      // theme
      black: "#000000",
      white: "#ffffff",
      grey: "#444444",
      theme: "#6e98cc",
    },
    fontFamily: {
      sans: ["Custom-font-goes-here", ...defaultTheme.fontFamily.sans],
    },
    fontSize: {
      body: ["1.6rem", "19.2rem"], // 16 / 19.2px
    },
    fontWeight: {
      normal: 400,
    },
    letterSpacing: {
      normal: "0",
    },
    opacity: {
      0: "0",
      50: "0.5",
      100: "1",
    },
    maxWidth: {
      none: "none",
      0: "0rem",
      full: "100%",
      min: "min-content",
      max: "max-content",
      fit: "fit-content",
      content: "1240px",
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      "2xl": "1536px",
    },
    spacing: {
      0: "0rem", // 0px
      1: "0.1rem", // 1px
      2: "0.2rem", // 2px
      4: "0.4rem", // 4px
      6: "0.6rem", // 6px
      8: "0.8rem", // 8px
      10: "0.8rem", // 8px
      12: "1.2rem", // 12px
      14: "1.4rem", // 14px
      16: "1.6rem", // 16px
      18: "1.8rem", // 16px
      20: "2.0rem", // 20px
      22: "2.2rem", // 22px
      24: "2.4rem", // 24px
      26: "2.6rem", // 26px
      28: "2.8rem", // 28px
      30: "3.0rem", // 30px
      32: "3.2rem", // 32px
      34: "3.4rem", // 34px
      36: "3.6rem", // 36px
      38: "3.8rem", // 38px
      40: "4.0rem", // 40px

      padding: "2rem", // Side-padding
    },
    transitionDuration: { DEFAULT: "300ms" },
    zIndex: {
      1: 1,
      2: 2,
      header: 1000,
      "mob-navi": 2000,
    },

    extend: {
      height: {
        screen: "calc(var(--js-vh) * 100)",
      },
    },
  },

  plugins: [
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/typography"),
    plugin(function ({ addVariant, e }) {
      addVariant("hocus", ["&:hover", "&:focus", "&:active"]); // "Hocus" variant – used in buttons
    }),
  ],
};
