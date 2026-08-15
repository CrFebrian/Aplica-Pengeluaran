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
        background: 'rgb(var(--color-background) / <alpha-value>)',
        surface: 'rgb(var(--color-surface) / <alpha-value>)',
        'surface-dim': 'rgb(var(--color-surface-dim) / <alpha-value>)',
        'surface-bright': 'rgb(var(--color-surface-bright) / <alpha-value>)',
        'surface-container-lowest': 'rgb(var(--color-surface-container-lowest) / <alpha-value>)',
        'surface-container-low': 'rgb(var(--color-surface-container-low) / <alpha-value>)',
        'surface-container': 'rgb(var(--color-surface-container) / <alpha-value>)',
        'surface-container-high': 'rgb(var(--color-surface-container-high) / <alpha-value>)',
        'surface-container-highest': 'rgb(var(--color-surface-container-highest) / <alpha-value>)',
        'on-surface': 'rgb(var(--color-on-surface) / <alpha-value>)',
        'on-surface-variant': 'rgb(var(--color-on-surface-variant) / <alpha-value>)',
        'on-background': 'rgb(var(--color-on-background) / <alpha-value>)',
        outline: 'rgb(var(--color-outline) / <alpha-value>)',
        'outline-variant': 'rgb(var(--color-outline-variant) / <alpha-value>)',

        // Primary (Indigo) — brand color, konsisten di light & dark
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
        border: 'rgb(var(--color-outline-variant) / <alpha-value>)',
      },
      boxShadow: {
        brutal: '6px 6px 0px 0px rgb(var(--color-shadow-ink))',
        'brutal-sm': '2px 2px 0px 0px rgb(var(--color-shadow-ink))',
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