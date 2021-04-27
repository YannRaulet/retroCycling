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

// start the Stimulus application
require('bootstrap');

// ---------------------------------------------------------------------------------
// Functions Scroll to  the top
//Get the button
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

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

btnScroll.addEventListener("click", topFunction);
