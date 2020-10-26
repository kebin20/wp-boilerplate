<?php

/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 * Text Domain: gutenbase
 * Domain Path: /languages/
 * @package gutenbase
 */

get_header();
?>

    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>

<?php
get_footer();
