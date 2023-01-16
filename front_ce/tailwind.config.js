module.exports = {
  content: [
    '../storage/framework/views/*.php',
    '../resources/**/*.blade.php',
    '../resources/**/*.js',
    '../resources/**/*.vue',
    './components/**/*.vue',
  ],
  theme: {
    extend: {
      screens: {
        '3xl': '1800px',
      },
      colors: {
        'bgSuscribirse': '#1b2a2f', //azul oscuro
        'tituloSuscribirse': '#ef0d33', //rojo
        'infoSuscribirse': '#dae9f4', //blanco

        'verde': '#0B6C3D',
        'rojo': '#E51313',
        'blanco': '#EFEFEF',
        // 'blanco': '#F4F4F4',
        'plomo': '#30323F',

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
