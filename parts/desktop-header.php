<?php

/**
 * Theme Name: Boilerplate
 * Author: Sean Verity
 * @package boilerplate
 */

$type_string = $args['type'] ?? null;
$is_sticky = $type_string === 'sticky' ? true : false;
?>

<header class="c-desk-head c-desk-head--<?= $type_string ?>">

    <div class="c-desk-head__wrap">
        <?php if ($is_sticky) : ?>
            <a class="c-desk-head__logo" href="<?= bloginfo('url'); ?>/#">
                <img src="<?= get_template_directory_uri() ?>/img/logo.svg">
            </a>
        <?php endif; ?>
    </div><!-- .desk-head__wrap -->

</header><!-- .desk-head -->
