import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
    extend: {
      colors: {
        main: '#76fbd9',
        income: '#7dd956',
        expense: '#ff6b9d',
        warning: '#ffdb33',
        border: '#000000',
      },
      boxShadow: {
        brutal: '4px 4px 0px 0px #000',
        'brutal-sm': '2px 2px 0px 0px #000',
      },
      borderRadius: {
        base: '5px',
      },
    },
  },
  plugins: [],
}