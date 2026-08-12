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

    darkMode: 'class',

    theme: {
    extend: {
      colors: {
        // Base surfaces (Catatuang Dark Neubrutalism)
        background: '#131316',
        surface: '#131316',
        'surface-dim': '#131316',
        'surface-bright': '#39393c',
        'surface-container-lowest': '#0e0e11',
        'surface-container-low': '#1b1b1e',
        'surface-container': '#1f1f22',
        'surface-container-high': '#2a2a2d',
        'surface-container-highest': '#353438',
        'on-surface': '#e4e1e6',
        'on-surface-variant': '#c7c4d7',
        'on-background': '#e4e1e6',
        outline: '#908fa0',
        'outline-variant': '#464554',

        // Primary (Indigo)
        primary: '#6366f1',
        'primary-container': '#4f46e5',
        'on-primary': '#ffffff',
        'inverse-primary': '#494bd6',
        'primary-fixed': '#e1e0ff',
        'primary-fixed-dim': '#c0c1ff',

        // Secondary / Income (Emerald)
        secondary: '#34d399',
        'secondary-container': '#00bd85',
        'on-secondary': '#003825',
        'on-secondary-container': '#00452e',
        income: '#34d399',

        // Tertiary / Expense (Rose)
        tertiary: '#fb7185',
        'tertiary-container': '#ea6479',
        'on-tertiary': '#67001f',
        expense: '#fb7185',

        // Warning (Amber)
        warning: '#fbbf24',
        'on-warning': '#78350f',

        error: '#ffb4ab',
        'on-error': '#690005',
        'error-container': '#93000a',

        // Legacy tokens kept for backward-compatibility with existing views
        main: '#6366f1',
        border: '#52525b',
      },
      boxShadow: {
        brutal: '6px 6px 0px 0px #3f3f46',
        'brutal-sm': '2px 2px 0px 0px #3f3f46',
        'brutal-primary': '6px 6px 0px 0px #4f46e5',
        'brutal-success': '6px 6px 0px 0px #34d399',
        'brutal-danger': '6px 6px 0px 0px #fb7185',
        'brutal-warning': '6px 6px 0px 0px #fbbf24',
      },
      borderRadius: {
        base: '0.25rem',
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        display: ['Montserrat', ...defaultTheme.fontFamily.sans],
      },
      fontSize: {
        'display-lg': ['48px', { lineHeight: '1.1', letterSpacing: '-0.02em', fontWeight: '900' }],
        'display-lg-mobile': ['36px', { lineHeight: '1.1', fontWeight: '900' }],
        'headline-md': ['24px', { lineHeight: '1.2', fontWeight: '700' }],
        'title-sm': ['18px', { lineHeight: '1.4', fontWeight: '700' }],
        'body-lg': ['18px', { lineHeight: '1.6', fontWeight: '500' }],
        'body-md': ['16px', { lineHeight: '1.5', fontWeight: '400' }],
        'label-caps': ['12px', { lineHeight: '1', letterSpacing: '0.05em', fontWeight: '700' }],
        'mono-data': ['14px', { lineHeight: '1', letterSpacing: '-0.01em', fontWeight: '600' }],
      },
      spacing: {
        base: '4px',
        xs: '8px',
        sm: '16px',
        md: '24px',
        lg: '40px',
        xl: '64px',
        gutter: '16px',
        'margin-mobile': '16px',
        'margin-desktop': '32px',
      },
    },
  },
  plugins: [forms],
}