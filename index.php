<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

get_header();
?>


<div class="c-wrapper">


  <?php if (is_404()) : ?>


    <p class="c-empty-content">ページが見つかりませんでした。</p>


  <?php else : ?>


    <div class="py-40 prose">
      <?= the_content(); ?>
    </div>

  <?php endif; ?>


</div>


<?php
get_footer();
