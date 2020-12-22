/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 * 
 * Insert code to be loaded last here. jQuery has been loaded by the time this script is called.
 */

/* === Slick Slider === */
jQuery('.slick-slider').slick({
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

/* === AOS === */
//Must be initiated after slick if there are animations in the slider
if(typeof AOS != "undefined"){
    AOS.init({
        delay: 0, // values from 0 to 3000, with step 50ms
        duration: 1000, // values from 0 to 3000, with step 50ms
        easing: 'ease', // default easing for AOS animations
        once: true, // whether animation should happen only once - while scrolling down
    });
}
