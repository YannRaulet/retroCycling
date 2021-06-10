/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/crud.scss';
import './styles/navBar.scss';
import './styles/footer.scss';
import './styles/home.scss';
import './styles/blog.scss';
import './styles/article.scss';
import './styles/collection.scss';
import './styles/cyclingShirt.scss';
import './styles/login.scss';
import './styles/registrer.scss';
import './styles/contact.scss';
import './styles/user.scss';
import './styles/legalNotices.scss';
import './styles/map.scss';

// start the Stimulus application
require('bootstrap');

// ---------------------------------------------------------------------------------
// Functions Scroll to  the top
var mybutton = document.getElementById("btnScroll");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

let intervalId = 0; // Needed to cancel the scrolling when we're at the top of the page
const $scrollButton = document.getElementById("btnScroll");

function scrollStep() {
  // Check if we're at the top already. If so, stop scrolling by clearing the interval
  if (window.pageYOffset === 0) {
    clearInterval(intervalId);
  }
  //returns the number of pixels the document scrolls
  window.scroll(0, window.pageYOffset - 50);  
}

function scrollToTop() {
  // Call the function scrollStep() every 8 millisecons
  intervalId = setInterval(scrollStep, 8);
}
$scrollButton.addEventListener('click', scrollToTop);

// ---------------------------------------------------------------------------------
// Lazy loading pictures
document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");    
  var lazyloadThrottleTimeout;

  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }
    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});
