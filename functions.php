<?php

/**
 * Theme Name: Boilerplate
 * Author: Sean Verity
 * @package boilerplate
 */


if (!function_exists('boilerplate_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function boilerplate_setup()
    {

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Delete Gutenburg core block patterns.
        remove_theme_support('core-block-patterns');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
    }
endif;
add_action('after_setup_theme', 'boilerplate_setup');


/* Remove Features
----------------------------------------------- */
// Removes features from post and pages
add_action('init', function () {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}, 100);

// Removes comment feature from admin bar
add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});

// Removes automatic addition of <p> tags to content and excerpt
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

// Removes "Customize" menu and comment-edit button from admin menu
add_action('admin_menu', function () {
    remove_menu_page('themes.php');
    remove_menu_page('edit-comments.php');
});


/* Base Custom Code
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/* Move jQuery to footer
----------------------------------------------- */
function move_jquery_to_footer()
{
    wp_scripts()->add_data('jquery', 'group', 1);
    wp_scripts()->add_data('jquery-core', 'group', 1);
    wp_scripts()->add_data('jquery-migrate', 'group', 1);
}
add_action('wp_enqueue_scripts', 'move_jquery_to_footer');


/* Queueing for Header scripts and styles.
----------------------------------------------- */
add_filter('wpcf7_load_css', '__return_false'); // Remove Contact Form 7 CSS
remove_action('wp_print_styles', 'print_emoji_styles'); // Remove default loading of emoji files
remove_action('wp_head', 'print_emoji_detection_script', 7); // Remove default loading of emoji files


function boilerplate_enqueue_assets()
{
    if (!is_admin()) {
        //== DEFAULT JS
        wp_enqueue_script('jquery');

        //== CRITICAL CSS
        wp_register_style('common-style', get_template_directory_uri() . '/style.css?v=1.0');
        wp_enqueue_style('common-style');

        //=== FONTAWESOME
        wp_register_style('font-awesome', get_template_directory_uri() . '/vendor/fontawesome/css/all.min.css');
        wp_enqueue_style('font-awesome');

        //=== AOS
        //Scripts
        if (!wp_is_mobile() and is_home()) :
            wp_register_script('aos-script', get_template_directory_uri() . '/vendor/aos/aos.js', array(), false, true); //load into footer
            wp_enqueue_script('aos-script');
            wp_register_style('aos-styles', get_template_directory_uri() . '/vendor/aos/aos.css');
            wp_enqueue_style('aos-styles');
        endif;

        //=== SLICK
        //Scripts
        wp_register_script('slick-script', get_template_directory_uri() . '/vendor/slick/slick.js', array(), false, true); //load into footer
        wp_enqueue_script('slick-script');

        //=== INIT
        //Scripts
        wp_register_script('init-script', get_template_directory_uri() . '/js/index.js?v=1.0', array(), false, true); //load into footer
        wp_enqueue_script('init-script');

        //=== LIGHTBOX
        if (is_page()) :
            wp_register_style('lightbox-style', get_template_directory_uri() . '/vendor/lightbox/css/lightbox.css');
            wp_enqueue_style('lightbox-style');
            wp_register_script('lightbox-script', get_template_directory_uri() . '/vendor/lightbox/js/lightbox.min.js', array(), false, true); //load into footer
            wp_enqueue_script('lightbox-script');
        endif;
    }
}
add_action('wp_enqueue_scripts', 'boilerplate_enqueue_assets', 1); //load before block editor


/* Script Defer/Async.
wordpress.stackexchange.com/questions/359599/add-extra-parameter-in-script-tag-using-script-loader-tag
----------------------------------------------- */
function defer_scripts($tag, $handle)
{
    # add script handles to the array below
    $scripts_to_defer = array(
        'aos-script',
        'slick-script',
        'init-script',
        'lightbox-script',
    );
    foreach ($scripts_to_defer as $defer_script) {
        if ($defer_script === $handle) {
            return str_replace(' src', ' defer src', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'defer_scripts', 10, 2);


/* Add ACF options page
----------------------------------------------- */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'サイト設定',
        'menu_title'    => 'サイト設定',
        'menu_slug'     => 'site-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));
}


/* Dequeue loading of default Gutenburg stylesheet (for sites using legacy editors)
----------------------------------------------- */
function remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'remove_wp_block_library_css', 100);


/* Add browser-type to body class
www.wpbeginner.com/wp-themes/how-to-add-user-browser-and-os-classes-in-wordpress-body-class/
----------------------------------------------- */
function add_browser_type_to_body_classes($classes)
{
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if ($is_lynx) $classes[] = 'lynx';
    elseif ($is_gecko) $classes[] = 'gecko';
    elseif ($is_opera) $classes[] = 'opera';
    elseif ($is_NS4) $classes[] = 'ns4';
    elseif ($is_safari) $classes[] = 'safari';
    elseif ($is_chrome) $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie' . $browser_version[1];
    } else $classes[] = 'unknown';
    if ($is_iphone) $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
}
add_filter('body_class', 'add_browser_type_to_body_classes');


/* Optional Custom Code
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/* Contact Form 7
----------------------------------------------- */
/**
 * Stop <p> & <br> auto-generation
 */
// add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Email Check Validation
 * https://contactform7.com/2015/03/28/custom-validation/
 */
// function custom_email_confirmation_validation_filter($result, $tag)
// {
//     if ('your-email-confirm' == $tag->name) {
//         $your_email = isset($_POST['your-email']) ? trim($_POST['your-email']) : '';
//         $your_email_confirm = isset($_POST['your-email-confirm']) ? trim($_POST['your-email-confirm']) : '';

//         if ($your_email != $your_email_confirm) {
//             $result->invalidate($tag, "メールアドレスは一致しません。");
//         }
//     }

//     return $result;
// }
// add_filter('wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2);


/**
 * Front-end Spam protection (validation)
 * https://wp-labo.com/contact-form-7-spam-mail-shutout/
 */
// function wpcf7_validate_anti_spam_message_name($result, $tag)
// {
//     $value = str_replace(array(PHP_EOL, ' '), '', esc_attr($_POST['your-name']));
//     if (!empty($value)) {
//         if (!preg_match("/^[ぁ-んァ-ヶ一-龠々+ー+]+$/u", $value)) {
//             $result['valid'] = false;
//             $result['reason'] = array('your-name' => 'お名前は日本語で入力してください');
//         }
//     }
//     return $result;
// }
// add_filter('wpcf7_validate', 'wpcf7_validate_anti_spam_message_name', 10, 2);


/**
 * Back-end Spam protection (filter)
 */
// add_filter('wpcf7_spam', function ($spam) {
//     if ($spam) {
//         return $spam;
//     }

//     $value = $_POST['your-name'];
//     if (!empty($value)) {
//         if (!preg_match("/^[ぁ-んァ-ヶ一-龠々+ー+]+$/u", $value)) {
//             $spam = true;
//         }
//     }

//     return $spam;
// }, 10, 1);



/* Function for retrieving top parent ID
http://www.stevendobbelaere.be/get-the-current-pages-parent-page-id-in-wordpress/
----------------------------------------------- */
// function get_top_parent_page_id()
// {
//     global $post;
//     if ($post->ancestors) {
//         return end($post->ancestors);
//     } else {
//         return $post->ID;
//     }
// }


/* Overide default <title>
----------------------------------------------- */
// function override_title($title_parts)
// {
//     if (is_404()) {
//         $title_parts['title'] = 'ページが見つかりません';
//     }
//     return $title_parts;
// }
// add_filter('document_title_parts', 'override_title');


/* Retrieve page URL using slug
----------------------------------------------- */
// function get_url_by_slug($page_slug)
// {
//     $page = get_page_by_path($page_slug);
//     if ($page) {
//         $pageID = $page->ID;
//         return get_page_link($pageID);
//     } else {
//         echo 'Page not found';
//         return null;
//     }
// }


/* Admin Area Custom CSS
----------------------------------------------- */
// add_action('admin_head', 'my_admin_area_custom_css');
// function my_admin_area_custom_css()
// {
//     echo '
//          <style>
//             #adminmenu #menu-posts {
//                 display:none;
//             }
//          </style>
//     ';
// }
