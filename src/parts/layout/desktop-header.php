<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

$site_name = get_bloginfo("name");
if (function_exists("YoastSEO")) :
  $site_name = YoastSEO()->meta->for_current_page()->title;
endif;

?>


<header class="c-desk-head">

  <div class="c-desk-head__wrap o-wrapper">

    <a class="c-desk-head__logo" href="<?= bloginfo('url'); ?>/#" title="トップへ戻る">
      <?php if (is_home()) : ?>
        <h1>
        <?php endif; ?>

        <img src="<?= get_template_directory_uri() ?>/dist/img/logo.svg" alt="<?= $site_name; ?>">

        <?php if (is_home()) : ?>
        </h1>
      <?php endif; ?>
    </a>

    <div class="c-desk-head__cont">

      <ul class="c-desk-head__nav">
        <?php get_template_part('src/parts/menus/nav-items'); ?>
      </ul>

    </div>

  </div>

</header>