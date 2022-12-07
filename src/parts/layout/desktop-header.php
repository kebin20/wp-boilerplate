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


<header class="hidden md:block group-[.js-scrolled]/root:shadow sticky left-0 top-0 z-header bg-white transition-shadow shadow-transparent">

  <div class="o-wrapper group-[.js-scrolled]/root:py-10 flex justify-between items-center py-16 transition-all">

    <a class="w-[12rem] group-[.js-scrolled]/root:w-[8rem] transition-all" href="<?= bloginfo('url'); ?>/#" title="トップへ戻る">
      <?php if (is_home()) : ?>
        <h1>
        <?php endif; ?>

        <img src="<?= get_template_directory_uri() ?>/dist/img/logo.svg" alt="<?= $site_name; ?>">

        <?php if (is_home()) : ?>
        </h1>
      <?php endif; ?>
    </a>

    <div class="flex justify-between items-center">

      <ul class="flex items-center">
        <?php get_template_part('src/parts/menus/nav-items'); ?>
      </ul>

    </div>

  </div>

</header>