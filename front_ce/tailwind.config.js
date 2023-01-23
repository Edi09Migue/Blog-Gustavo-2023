module.exports = {
  content: [
    '../storage/framework/views/*.php',
    '../resources/**/*.blade.php',
    '../resources/**/*.js',
    '../resources/**/*.vue',
    './src/**/*.vue',
  ],
  theme: {
    extend: {
      screens: {
        '3xl': '1800px',
      },
      colors: {
        'dark': '#455A64',
        'ligt': '#607D8DC',
        'azul-obscuro': '#607D8B',
        'blanco': '#ffffff',
        'azul': '#448AFF',
        'negro': '#212121',
        'plomo': '#757575',
        'plomo-light': '#BDBDBD',

        'error':'#ee2f2f4f',
        'info':'#2fc1ee59',
        'warning':'#cdee2f59'

      },
      fontFamily: {
        'gotham-medium': ["'gotham-medium'", 'sans-serif'],
        'gotham-black': ["'gotham-black'", 'sans-serif'],
      },
      letterSpacing: {
        suscribirse: '0.125em',
        enviar: '0.375em',
        tituloSuscribirse: '-0.1em'
      },

      borderRadius: {
        // 'lg': '1.025rem',
     
      }
    },
  },
  plugins: [],
}
