<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */

$fb_link = get_field('site_link_fb', 'option');
$yt_link = get_field('site_link_yt', 'option');
$twitter_link = get_field('site_link_twitter', 'option');
$insta_link = get_field('site_link_insta', 'option');

if ($fb_link) :
?>
    <li>
        <a href="<?= esc_url($fb_link) ?>" title="Facebook" target="_blank" rel="noopener norel">
            Facebook
        </a>
    </li>
<?php
endif;

if ($yt_link) :
?>
    <li>
        <a href="<?= esc_url($twitter_link) ?>" title="Youtube" target="_blank" rel="noopener sponsored">
            Youtube
        </a>
    </li>
<?php
endif;

if ($twitter_link) :
?>
    <li>
        <a href="<?= esc_url($twitter_link) ?>" title="Twitter" target="_blank" rel="noopener sponsored">
            Twitter
        </a>
    </li>
<?php
endif;

if ($insta_link) :
?>
    <li>
        <a href="<?= esc_url($insta_link) ?>" title="Instagram" target="_blank" rel="noopener norel">
            Instagram
        </a>
    </li>
<?php
endif;
