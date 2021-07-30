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

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function boilerplate_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('boilerplate_content_width', 640);
}
add_action('after_setup_theme', 'boilerplate_content_width', 0);



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
        //If IE, load IE-specific polyfills
        global $is_IE;
        if ($is_IE) :
            // Object Fit
            wp_register_script('ofi-script', get_template_directory_uri() . '/vendor/polyfills/ofi.min.js', array(), false, true); //load into footer
            wp_enqueue_script('ofi-script');
            // CSS variables
            wp_register_script('css-variables-script', get_template_directory_uri() . '/vendor/polyfills/css-vars-ponyfill.min.js', array(), false, true); //load into footer
            wp_enqueue_script('css-variables-script');
            // Classlist
            wp_register_script('classlist-script', get_template_directory_uri() . '/vendor/polyfills/classlist.js', array(), false, true); //load into footer
            wp_enqueue_script('classlist-script');
            // NodeList forEach
            wp_register_script('nodelist-foreach-script', get_template_directory_uri() . '/vendor/polyfills/nodelist-foreach.js', array(), false, true); //load into footer
            wp_enqueue_script('nodelist-foreach-script');
        endif;

        //== DEFAULT JS
        wp_enqueue_script('jquery');

        //== CRITICAL CSS
        wp_register_style('common-style', get_template_directory_uri() . '/style.css');
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
        if (!$is_IE) :
            wp_register_script('init-script', get_template_directory_uri() . '/js/index.js', array(), false, true); //load into footer
            wp_enqueue_script('init-script');
        else :
            wp_register_script('init-script-ie', get_template_directory_uri() . '/js/index-ie.js', array(), false, true); //load into footer
            wp_enqueue_script('init-script-ie');
        endif;

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


/* Script Preloader.
macarthur.me/posts/preloading-javascript-in-wordpress
----------------------------------------------- */
add_action('wp_head', function () {
    global $wp_scripts;
    foreach ($wp_scripts->queue as $handle) {
        $script = $wp_scripts->registered[$handle];
        if ($script->src) {
            $source = $script->src . ($script->ver ? "?ver={$script->ver}" : ""); // If version is set, append to end of source.
            echo "<link rel='preload' href='{$source}' as='script'/>\n"; // Spit out the tag.
        }
    }
}, 1);


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
//         <style>
//             #adminmenu #menu-posts,
//             #adminmenu #menu-comments /* Hide "Comments" menu item */
//             {
//                 display:none;
//             }
//     </style>
//     ';
// }
