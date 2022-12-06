<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

?>


<li class="c-arch-item">
  <a href="<?= get_the_permalink(); ?>">


    <div class="c-arch-item__img">

      <?php if (has_post_thumbnail()) : ?>
        <img src="<?= get_the_post_thumbnail_url(get_the_ID(), "thumbnail"); ?>" alt="<?= get_the_title(); ?>">
      <?php else : ?>
        <img src="<?= get_template_directory_uri() ?>/dist/img/none-thumb.svg" alt="<?= get_the_title(); ?>">
      <?php endif; ?>

    </div>


    <div class="c-arch-item__cont">

      <time class="c-arch-item__date" datetime="<?= get_the_date("Y-m-d") ?>"><?= get_the_date("Y-m-d"); ?></time>

      <p class="c-arch-item__tit"><?= get_the_title(); ?></p>

    </div>


  </a>
</li>