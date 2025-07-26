/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./**/*.html",
    "./**/*.js",
    "./admin/**/*.php",
    "./API/**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fef7e0',
          100: '#fdecc1',
          200: '#fbd583',
          300: '#f9be45',
          400: '#f7a726',
          500: '#f7b315', // Your existing gold color
          600: '#e89c0d',
          700: '#c17a0a',
          800: '#9a5f0c',
          900: '#7d4e10',
        },
        secondary: {
          50: '#fdf2f8',
          100: '#fce7f3',
          200: '#fbcfe8',
          300: '#f9a8d4',
          400: '#f472b6',
          500: '#b76e79', // Your existing rose gold
          600: '#a05a63',
          700: '#8b4a52',
          800: '#6b3a41',
          900: '#5a2f35',
        },
        neutral: {
          50: '#f8f9fa',
          100: '#f1f3f4',
          200: '#e8eaed',
          300: '#dadce0',
          400: '#bdc1c6',
          500: '#bfc1c2', // Your existing silver
          600: '#9aa0a6',
          700: '#80868b',
          800: '#5f6368',
          900: '#202124',
        }
      },
      fontFamily: {
        'serif': ['Playfair Display', 'serif'],
        'sans': ['Poppins', 'Arial', 'sans-serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'float': 'float 6s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideUp: {
          '0%': { transform: 'translateY(100%)' },
          '100%': { transform: 'translateY(0)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
} 