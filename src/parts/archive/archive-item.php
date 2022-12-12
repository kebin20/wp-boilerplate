<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

?>


<li>
  <a class="block" href="<?= get_the_permalink(); ?>">
    <article>

      <div>

        <?php if (has_post_thumbnail()) : ?>
          <img src="<?= get_the_post_thumbnail_url(get_the_ID(), "thumbnail"); ?>" alt="<?= get_the_title(); ?>">
        <?php else : ?>
          <img src="<?= get_template_directory_uri() ?>/dist/img/none-thumb.svg" alt="<?= get_the_title(); ?>">
        <?php endif; ?>

      </div>


      <header>

        <time datetime="<?= get_the_date("Y-m-d") ?>"><?= get_the_date("Y-m-d"); ?></time>

        <p><?= get_the_title(); ?></p>

      </header>

    </article>
  </a>
</li>