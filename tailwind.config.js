/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js,php}", "./*.php"],
  theme: {
    extend: {
      backdropBlur: {
        none: "none",
        sm: "4px",
        md: "8px",
        lg: "12px",
        xl: "16px",
        "2xl": "24px",
        "3xl": "40px",
      },
      fontFamily: {
        inter: ["Inter"],
        average: ["Average"],
        domine: ["Domine"],
        istok: ["Istok+Web"],
        itim: ["Itim"],
        joan: ["Joan"],
        judson: ["Judson"],
      },
      colors: {
        background1: "#1f0b0b",
        background2: "#852E2E",
        bg_red: "#1F0B0B",
        bg_red_2: "#852E2E",
      },
    },
  },
  plugins: [],
};
