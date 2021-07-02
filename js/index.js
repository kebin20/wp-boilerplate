/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 *
 * Insert code to be loaded last here. jQuery has been loaded by the time this script is called.
 */

const isMobile =
    document.body.classList.contains("is-mobile") ||
    window.matchMedia("(max-width: 900px)").matches;
const isHome = document.body.classList.contains("home");

/* Launch Site
----------------------------------------------- */
window.addEventListener("load", function () {
    try {
        initCSSVars();
    } catch (e) {
        console.error("initCSSVars Error: ", e.stack);
    }

    try {
        stickyHeaderInitiate();
    } catch (e) {
        console.error("stickyHeaderInitiate Error: ", e.stack);
    }

    try {
        mobNaviInitiate();
    } catch (e) {
        console.error("mobNaviInitiate Error: ", e.stack);
    }

    try {
        slickInitiate();
    } catch (e) {
        console.error("slickInitiate Error: ", e.stack);
    }

    try {
        aosInitiate();
    } catch (e) {
        console.error("aosInitiate Error: ", e.stack);
    }
});

/**
 * Init CSS Vars
 */
function initCSSVars() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", `${vh}px`);
}

/**
 * Debouncer
 */
function debounce(func, wait = 20, immediate = true) {
    var timeout;
    return function () {
        var context = this,
            args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

/**
 * Sticky Header
 */
function stickyHeaderInitiate() {
    const pageBannerEl = document.getElementById("js-page-banner");

    function checkStickyScroll() {
        let bannerBottom = pageBannerEl.offsetTop + pageBannerEl.offsetHeight;

        if (window.pageYOffset > bannerBottom) {
            document.documentElement.classList.add("js-scrolled");
        } else {
            document.documentElement.classList.remove("js-scrolled");
        }
    }

    window.addEventListener("scroll", debounce(checkStickyScroll, 5));
}

/**
 * Mobile Navigation Logic
 */
function mobNaviInitiate() {
    const mobNaviOpenEl = document.getElementById("js-navi-open");
    mobNaviOpenEl.addEventListener("click", openNavi);

    const mobNaviCloseEl = document.getElementById("js-navi-close");
    mobNaviCloseEl.addEventListener("click", closeNavi);
    document.querySelectorAll(".mob-navi__wrap a").forEach((element) => {
        element.addEventListener("click", closeNavi);
    });

    function openNavi() {
        document.documentElement.classList.add("js-navi-open");
    }

    function closeNavi() {
        document.documentElement.classList.remove("js-navi-open");
    }
}

/**
 * Slick Slider
 */
function slickInitiate() {
    jQuery(document).ready(function () {
        if (jQuery(".slick-slider")) {
            jQuery(".slick-slider").each(function () {
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
            easing: "ease", // default easing for AOS animations
            once: true, // whether animation should happen only once - while scrolling down
        });
    }
}
