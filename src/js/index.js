/**
 * Theme Name: Projectname
 * Author: Sean Verity
 */

import Swiper from "swiper";
import "swiper/css";

import AOS from "aos";
import "aos/dist/aos.css";

/* Global
----------------------------------------------- */
let isMobile = false;
const MOBILE_THRESHOLD = 768; // same as TW "screens.md" value

/* Init
----------------------------------------------- */
window.addEventListener("load", function () {
  try {
    varsInitiate();
    window.onresize = debounce(varsInitiate, 5);
  } catch (e) {
    console.error("varsInitiate Error: ", e.stack);
  }

  try {
    desktopHeaderInitiate();
  } catch (e) {
    console.error("desktopHeaderInitiate Error: ", e.stack);
  }

  try {
    mobNaviInitiate();
  } catch (e) {
    console.error("mobNaviInitiate Error: ", e.stack);
  }

  try {
    sliderInitiate();
  } catch (e) {
    console.error("sliderInitiate Error: ", e.stack);
  }

  try {
    aosInitiate();
  } catch (e) {
    console.error("aosInitiate Error: ", e.stack);
  }
});

/* Functions
----------------------------------------------- */
/**
 * Init CSS & JS Vars
 */
function varsInitiate() {
  // Set CSS vars
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--js-vh", `${vh}px`);

  // Set JS vars
  isMobile =
    document.body.classList.contains("is-mobile") ||
    window.matchMedia(`(max-width: ${MOBILE_THRESHOLD})`).matches;
}

/**
 * Sticky Header
 */
function desktopHeaderInitiate() {
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
  // Init vars
  const HAM_TRANSITION_TIME = parseInt(
    window
      .getComputedStyle(document.documentElement)
      .getPropertyValue("--js-mob-transition-dur")
      .replace("ms", "")
  );
  const hamburgerEl = document.getElementById("js-navi-open");
  const closeNavMenuEl = document.getElementById("js-navi-close");
  const docEl = document.documentElement;

  // Hamburger init
  hamburgerEl.addEventListener("click", () => {
    if (docEl.classList.contains("js-navi-open")) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  // Close init
  closeNavMenuEl.addEventListener("click", closeMenu);

  // Helpers
  function openMenu() {
    hamburgerEl.setAttribute("aria-expanded", true);
    docEl.classList.add("js-navi-open");
    window.setTimeout(function () {
      closeNavMenuEl.focus();

      // ESC key
      document.addEventListener("keyup", (e) => {
        if (e.keyCode === 27) closeMenu();
      });
    }, HAM_TRANSITION_TIME);
  }

  function closeMenu() {
    hamburgerEl.setAttribute("aria-expanded", false);
    docEl.classList.remove("js-navi-open");
    docEl.classList.add("js-navi-closing");
    window.setTimeout(function () {
      docEl.classList.remove("js-navi-closing");
      hamburgerEl.focus();
    }, HAM_TRANSITION_TIME);
  }
}

/**
 * Slider
 */
function sliderInitiate() {
  if (document.querySelector(".swiper")) {
    const swiper = new Swiper(".swiper", {
      // effect: "fade",
      loop: true,
      speed: 500,

      autoplay: {
        delay: 5000,
      },

      // pagination: {
      //     el: ".swiper-pagination",
      // },

      // navigation: {
      //     nextEl: ".swiper-button-next",
      //     prevEl: ".swiper-button-prev",
      // },
    });
  }
}

/**
 * AOS
 */
function aosInitiate() {
  if (typeof AOS != "undefined") {
    AOS.init({
      delay: 0, // values from 0 to 3000, with step 50ms
      duration: 1000, // values from 0 to 3000, with step 50ms
      easing: "ease", // default easing for AOS animations
      once: true, // whether animation should happen only once - while scrolling down
    });
  }
}

/* Helpers
----------------------------------------------- */
/**
 * Debouncer
 */
function debounce(func, wait = 20, immediate = true) {
  let timeout;
  return function () {
    const context = this;
    const args = arguments;

    const later = function () {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };

    const callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}
