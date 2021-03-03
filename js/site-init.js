/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 * 
 * Insert code to be loaded last here. jQuery has been loaded by the time this script is called.
 */
const errorStyles = 'color: red';
const isMobile = document.body.classList.contains("is-mobile") || window.matchMedia("(max-width: 900px)").matches;
const isHome = document.body.classList.contains("home");

/* Launch Site
----------------------------------------------- */
window.addEventListener('load', function () {
    try {
        slickInitiate();
    } catch (err) {
        console.log("%c slickInitiate Error: " + err + ".", errorStyles);
    }

    try {
        aosInitiate();
    } catch (err) {
        console.log("%c aosInitiate Error: " + err + ".", errorStyles);
    }
});


/**
 * Slick Slider
 */
function slickInitiate() {
    jQuery(document).ready(function () {
        if (jQuery('.slick-slider')) {
            jQuery('.slick-slider').each(function () {
                var slider = jQuery(this);
                if (slider.children().length > 1) {
                    slider.slick({
                        arrows: true,
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 4000,
                        speed: 1000,
                        fade: true,
                        infinite: true,
                        loop: true,
                    });
                }
            });
        }
    });
}


/**
 * AOS
 */
function aosInitiate() {
    //Must be initiated after slick if there are animations in the slider
    if (typeof AOS != "undefined") {
        AOS.init({
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 1000, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: true, // whether animation should happen only once - while scrolling down
        });
    }
}
