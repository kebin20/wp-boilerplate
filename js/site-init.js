/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 * 
 * Insert code to be loaded last here. jQuery has been loaded by the time this script is called.
 */

/* === AOS === */
AOS.init();

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
