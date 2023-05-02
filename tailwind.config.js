const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.svg',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                0: ['0', '0']
            },
            colors: {
                'current': 'currentColor'
            },
            padding: {
                '1/5': '20%',
                '1/2': '50%',
                full: '100%'
            }
        },
    },

    // variants: {
    //     extend: {
    //         opacity: ['disabled'],
    //     },
    // },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
