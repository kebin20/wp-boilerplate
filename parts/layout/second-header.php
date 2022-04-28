<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */


/**
 * Title / Shortname
 */
$title = get_the_title();

if (is_404()) :
    $title = "404 - Page Not Found";
elseif (is_post_type_archive("blog")) :
    $title = "ブログ";
elseif (is_tax("blog_type")) :
    $term = get_term(get_queried_object_id());
    $title = "タイプ：" . $term->name;
endif;

/**
 * Thumbnail
 */
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), "second-header");

if (!$thumbnail_url or is_404()) :
    $thumbnail_url = get_field("site_bgimg_404", "option")["sizes"]["second-header"];
endif;
?>


<div id="js-page-banner" class="c-sec-head">


    <?php if (is_single()) : ?>
        <h3 class="c-sec-head__tit"><?= $title ?></h3>
    <?php else : ?>
        <h1 class="c-sec-head__tit"><?= $title ?></h1>
    <?php endif; ?>


    <div class="c-sec-head__img">
        <img src="<?= $thumbnail_url ?>" alt="<?= $title ?>">
    </div>


    <?php if (function_exists('yoast_breadcrumb')) : ?>
        <div class="c-sec-head__bc">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>


</div>