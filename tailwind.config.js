/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./src/views/**/*.php",
        "./public/js/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#2D5F4A',
                    light: '#3D7A62',
                    dark: '#1E4233',
                },
                accent: {
                    DEFAULT: '#D4883A',
                    light: '#E8A85C',
                    dark: '#B8722E',
                },
                success: '#2B8A3E',
                warning: '#E67700',
                danger: '#C92A2A',
                info: '#1971C2',
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            boxShadow: {
                'sm': '0 1px 2px rgba(0,0,0,0.05)',
                'md': '0 4px 6px rgba(0,0,0,0.07)',
                'lg': '0 10px 15px rgba(0,0,0,0.1)',
                'xl': '0 20px 25px rgba(0,0,0,0.15)',
            },
            borderRadius: {
                'sm': '4px',
                'md': '8px',
                'lg': '12px',
                'xl': '16px',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
            width: {
                'sidebar': '240px',
                'sidebar-collapsed': '64px',
            },
            transitionDuration: {
                '200': '200ms',
                '300': '300ms',
            },
        },
    },
    plugins: [],
}
