<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

get_header();


if (is_404()) :
?>

  <div class="o-wrapper">
    <p class="o-empty-content">ページが見つかりませんでした。</p>
  </div>

<?php
endif;


get_footer();
