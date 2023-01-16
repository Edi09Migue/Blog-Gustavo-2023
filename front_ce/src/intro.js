import { gsap, Power2  } from "gsap";

function setWithExpiry(key, value, ttl) {
  const now = new Date()

  // `item` is an object which contains the original value
  // as well as the time when it's supposed to expire
  const item = {
    value: value,
    expiry: now.getTime() + ttl,
  }
  localStorage.setItem(key, JSON.stringify(item))
}

function getWithExpiry(key) {
  const itemStr = localStorage.getItem(key)

  // if the item doesn't exist, return null
  if (!itemStr) {
    return null
  }

  const item = JSON.parse(itemStr)
  const now = new Date()

  // compare the expiry time of the item with the current time
  if (now.getTime() > item.expiry) {
    // If the item is expired, delete the item from storage
    // and return null
    localStorage.removeItem(key)
    return null
  }
  return item.value
} 

export function initIntro(){

    let skipIntro = getWithExpiry('introTime');

    var imgLogo = document.getElementById('logo'), 
    introDiv = document.getElementsByClassName('intro')[0],
    mainDiv = document.getElementById('main'),
    downFlag = document.getElementById('down-flag'),
    debugInfo = document.getElementById('debug-info');
    
    
    //Get DOM elements to show screen data
    var widthScreen = document.getElementById('width-screen'),
    heightScreen = document.getElementById('height-screen');
    //Get Width and height screen
    let hScreen =  window.innerHeight;
    let wScreen =  window.innerWidth;
    //write values to DOM
    widthScreen.innerHTML = wScreen;
    heightScreen.innerHTML = hScreen;
    
    //Get DOM elements to show logo data
    var widthLogo = document.getElementById('width-logo'),
    heightLogo = document.getElementById('height-logo');
    //Get Width and height of logo image
    let wLogo = gsap.getProperty("#logo", "width");
    let hLogo = gsap.getProperty("#logo", "height");
    //write values to DOM
    widthLogo.innerHTML = wLogo;
    heightLogo.innerHTML = hLogo;
    
    //let tlIntro = new TimelineMax();
    let tlIntro = gsap.timeline();
    
    if(skipIntro ){
      
      setWithExpiry('introTime',true,5000);

      //Entrada de Logo
      tlIntro.from( imgLogo, 1, {y: -hScreen/2, x: wScreen, opacity: 0, } );        
      //Centrar logo
      tlIntro.to( imgLogo, { y: 0 , x: 0, duration: 1, opacity: 1 , ease: Power2.easeInOut } );
      
      //Animar letras
      tlIntro.fromTo('#text span',{color:'#03a84d'},{duration: 1, opacity:1, y: "random(-200, 200)", stagger: 0.1, color:'white'},'-=0.4');
      
      //Agrandar y desaparacer
      tlIntro.to( imgLogo, { 
          scale: 5, 
          opacity: 0, 
          boxShadow:"0px 40px 70px 0px rgba(0, 0, 0, 0.22), 0px 27px 24px 0px rgba(0, 0, 0, 0.2)",
          duration: 2
      });
      
      //Salida de texto hacia abajo
      tlIntro.fromTo( '#text',  { color: 'gray' }, { color:'black', duration:2, opacity: 0.5, y: '+190', scale: 1.5,  ease: Power2.easeOut },'<' );
      //Agrandar y desaparecer
      //tlIntro.to( '#text', { scale: 4, opacity: 0, duration: 1});
    }
    
    //Cambiar fondo a blanco
    tlIntro.fromTo( introDiv,{opacity: 1, }, {height:0, backgroundColor : '#ffffff', opacity: 0.0,duration: 2, display: 'none'});
    
    tlIntro.to('#main',{ duration: 2, display:'block', onComplete: animateSections},'<');
    
    function animateSections() {
      //  alert('fin intro');
    }
}
