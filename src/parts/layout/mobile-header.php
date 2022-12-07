<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 * 
 *  Credit to Louis Lazarus for the accessible hamburger menu
 * https://impressivewebs.com/accessible-keyboard-friendly-hamburger-menu-slide-out-navigation/
 */

$site_name = get_bloginfo("name");
if (function_exists("YoastSEO")) :
  $site_name = YoastSEO()->meta->for_current_page()->title;
endif;

?>


<header class="md:hidden group-[.js-scrolled]/root:shadow sticky z-header left-0 top-0 right-0 w-full flex justify-between items-center py-16 px-padding bg-white transition-shadow shadow-transparent">

  <a class="w-[8rem]" href="<?= bloginfo('url'); ?>/#" title="トップへ戻る">
    <img src="<?= get_template_directory_uri() ?>/dist/img/logo.svg" alt="<?= $site_name; ?>">
  </a>

  <div class="flex items-center">

    <button id="js-navi-open" class="w-26" aria-label="ナビゲーションメニュ" aria-expanded="false">

      <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 11" width="26" height="11">
        <line y1="0.5" x2="26" y2="0.5" fill="none" stroke="currentColor" />
        <line y1="5.5" x2="26" y2="5.5" fill="none" stroke="currentColor" />
        <line y1="10.5" x2="26" y2="10.5" fill="none" stroke="currentColor" />
      </svg>

    </button>

  </div>

</header>


<?php
$open_classes = "group-[.js-navi-open]/root:scale-100 group-[.js-navi-open]/root:opacity-100 | group-[.js-navi-open]/root:z-mob-navi group-[.js-navi-open]/root:visible group-[.js-navi-open]/root:pointer-events-auto";
$closing_classes = "group-[.js-navi-closing]/root:z-mob-navi group-[.js-navi-closing]/root:visible group-[.js-navi-closing]/root:pointer-events-auto";
?>


<nav aria-labelledby="js-navi-open" class="md:hidden <?= $open_classes ?> <?= $closing_classes ?> fixed -z-1 top-0 left-0 w-full h-full overflow-y-scroll py-28 px-padding text-white bg-theme pointer-events-none invisible scale-110 opacity-0 transition-all">

  <button id="js-navi-close" class="w-18 h-18 absolute top-28 right-padding" aria-label="ナビゲーションメニューを閉じる">

    <svg class="w-18 h-18" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.09 19.09">
      <line x1="0.35" y1="0.35" x2="18.74" y2="18.74" fill="none" stroke="currentColor" stroke-width="1" />
      <line x1="0.35" y1="18.74" x2="18.74" y2="0.35" fill="none" stroke="currentColor" stroke-width="1" />
    </svg>

  </button>

  <div class="pt-[10.4rem] pb-[6rem] overflow-y-scroll">

    <ul class="text-center">
      <?php get_template_part('src/parts/menus/nav-items'); ?>
    </ul>

  </div>

</nav>