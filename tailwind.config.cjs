/** @type {import('tailwindcss').Config} */

const TW_TYPO_STYLES = require("@tailwindcss/typography/src/styles");

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
      body: ["1.6rem", "1.92rem"], // 16 / 19.2px
    },
    fontWeight: {
      normal: 400,
      bold: 700,
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
    transitionDuration: { DEFAULT: "300ms", "mob-nav": "800ms" },
    zIndex: {
      1: 1,
      2: 2,
      header: 1000,
      "mob-navi": 2000,
    },

    typography: (theme) => {
      // Provides the default styling (`DEFAULT`) while also disabling modifiers (`prose-lg`, `prose-stone` etc.)

      return {
        DEFAULT: {
          css: [
            ...TW_TYPO_STYLES.DEFAULT.css,
            {
              // Base styles
              fontSize: theme("fontSize.body")[0],
              lineHeight: theme("fontSize.body")[1],
              maxWidth: "100%",

              "--tw-prose-body": theme("colors.grey"),
              "--tw-prose-headings": theme("colors.grey"),
              "--tw-prose-lead": theme("colors.grey"),
              "--tw-prose-links": theme("colors.theme"),
              "--tw-prose-bold": theme("colors.grey"),
              "--tw-prose-counters": theme("colors.grey"),
              "--tw-prose-bullets": theme("colors.grey"),
              "--tw-prose-hr": theme("colors.black"),
              "--tw-prose-quotes": theme("colors.grey"),
              "--tw-prose-quote-borders": theme("colors.theme"),
              "--tw-prose-captions": theme("colors.grey"),
              "--tw-prose-code": theme("colors.theme"),
              "--tw-prose-pre-code": theme("colors.white"),
              "--tw-prose-pre-bg": theme("colors.black"),
              "--tw-prose-th-borders": theme("colors.black"),
              "--tw-prose-td-borders": theme("colors.grey"),

              // Individual element styles
              a: {
                color: theme("colors.theme"),
                fontWeight: theme("fontWeight.bold"),
                textDecoration: "none",

                "&:hover": {
                  opacity: theme("opacity.50"),
                },
              },

              em: {
                fontStyle: "italic",
              },
            },
          ],
        },
      };
    },

    extend: {
      height: {
        screen: "calc(var(--js-vh) * 100)",
      },
      transitionTimingFunction: {
        "mob-nav": "cubic-bezier(0.19, 1, 0.22, 1)",
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
