<?php

/**
* Theme Name: Gutenbase
* Author: Sean Verity
* Text Domain: gutenbase
* Domain Path: /languages/
* @package gutenbase
 */

$type_string = $args['type'] ?? null;
$is_sticky = $type_string === 'sticky' ? true : false;
?>

<header class="desk-head desk-head--<?= $type_string ?>">

    <div class="desk-head__wrap">
        <?php if ($is_sticky) : ?>
            <a class="desk-head__item" href="<?= bloginfo('url'); ?>/#">
                <img src="<?= get_template_directory_uri() ?>/img/logo.svg">
            </a>
        <?php endif; ?>
    </div><!-- .desk-head__wrap -->

</header><!-- .desk-head -->