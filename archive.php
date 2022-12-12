<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

get_header();
?>


<div class="c-wrapper">

  <?php if (have_posts()) : ?>

    <ul class="c-arch">

      <?php
      while (have_posts()) :
        the_post();
        get_template_part('src/parts/archive/archive-item');
      endwhile;
      ?>

    </ul>

    <div class="c-pagination">
      <?php projectname_pagination('＜', '＞'); ?>
    </div>

  <?php else : ?>

    <p class="c-empty-content">投稿の内容が見つかりませんでした。</p>

  <?php endif; ?>

</div>


<?php
get_footer();
