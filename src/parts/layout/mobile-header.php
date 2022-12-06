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


<header class="c-mob-head">

  <a class="c-mob-head__logo" href="<?= bloginfo('url'); ?>/#" title="トップへ戻る">
    <img src="<?= get_template_directory_uri() ?>/dist/img/logo.svg" alt="<?= $site_name; ?>">
  </a>

  <div class="c-mob-head__wrap">

    <button id="js-navi-open" class="c-mob-head__ham" aria-label="ナビゲーションメニュ" aria-expanded="false">

      <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 11" width="26" height="11">
        <line y1="0.5" x2="26" y2="0.5" fill="none" stroke="currentColor" />
        <line y1="5.5" x2="26" y2="5.5" fill="none" stroke="currentColor" />
        <line y1="10.5" x2="26" y2="10.5" fill="none" stroke="currentColor" />
      </svg>

    </button>

  </div>

</header>



<nav class="c-mob-navi" aria-labelledby="js-navi-open">

  <button id="js-navi-close" class="c-mob-navi__close" aria-label="ナビゲーションメニューを閉じる">

    <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.09 19.09">
      <line x1="0.35" y1="0.35" x2="18.74" y2="18.74" fill="none" stroke="currentColor" stroke-width="1" />
      <line x1="0.35" y1="18.74" x2="18.74" y2="0.35" fill="none" stroke="currentColor" stroke-width="1" />
    </svg>

  </button>

  <div class="c-mob-navi__wrap">

    <ul class="c-mob-navi__nav">
      <?php get_template_part('src/parts/menus/nav-items'); ?>
    </ul>

  </div>

</nav>