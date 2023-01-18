
// // core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

// // import Swiper and modules styles
// // import 'swiper/css';
// // import 'swiper/css/navigation';
// // import 'swiper/css/pagination';

// // configure Swiper to use modules
// Swiper.use([Navigation, Pagination]);

const swiper = new Swiper('.swiper', {
    // Optional parameters
    //direction: 'vertical',
    
  
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    loop: true,

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
//      type: "progressbar",
    },
  
    // Navigation arrows
    // navigation: {
    //   nextEl: '.swiper-button-next',
    //   prevEl: '.swiper-button-prev',
    // },
  
    // And if we need scrollbar
    // scrollbar: {
    //   el: '.swiper-scrollbar',
    // },
  });
  


  // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btns = document.getElementsByClassName("img-pagina");
for (let index = 0; index < btns.length; index++) {
  const element = btns[index];
  // When the user clicks on the button, open the modal
  element.onclick = function() {
    modal.style.display = "block";
  }
}

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];


// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 