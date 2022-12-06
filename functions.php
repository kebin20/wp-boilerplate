<?php

/**
 * Theme Name: Projectname
 * Author: Sean Verity
 * @package projectname
 */


/* Theme Support
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
if (!function_exists('projectname_setup')) :
  function projectname_setup()
  {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Delete Gutenburg core block patterns.
    remove_theme_support('core-block-patterns');

    // Let WordPress manage the <title> tag
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ));
  }
endif;
add_action('after_setup_theme', 'projectname_setup');


/* Add / Remove Features
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
// Turn off WordPress Homepage URL redirection
remove_filter('template_redirect', 'redirect_canonical');

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

// Removes "Customize" menu and comment-edit button from admin menu
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});

// Removes automatic addition of <p> tags to content and excerpt
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');


/* Asset Queueing
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/**
 * Dequeue default Gutenburg stylesheet
 */
function projectname_remove_wp_block_library_css()
{
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'projectname_remove_wp_block_library_css', 100);

/**
 * Misc. Dequeue
 */
add_filter('wpcf7_load_css', '__return_false'); // Remove Contact Form 7 CSS
remove_action('wp_print_styles', 'print_emoji_styles'); // Remove default loading of emoji files
remove_action('wp_head', 'print_emoji_detection_script', 7); // Remove default loading of emoji files

/**
 * Enqueue
 */
function projectname_enqueue_assets()
{
  $VERSION_NUMBER = "1.0.0"; // cache bust

  if (!is_admin()) {
    wp_register_style('common-style', get_template_directory_uri() . '/style.css?v=' . $VERSION_NUMBER, array(), null);
    wp_enqueue_style('common-style');
    wp_register_script('common-script', get_template_directory_uri() . '/dist/js/index.js?v=' . $VERSION_NUMBER, array(), null, true); //load into footer
    wp_enqueue_script('common-script');
  }
}
add_action('wp_enqueue_scripts', 'projectname_enqueue_assets', 1);

/**
 * Enqueue (Admin)
 */
function projectname_enqueue_admin()
{
  wp_register_style('admin-style', get_template_directory_uri() . '/style-admin.css');
  wp_enqueue_style('admin-style');
}
add_action('admin_enqueue_scripts', 'projectname_enqueue_admin', 1);


/**
 * Script Defer/Async.
 */
function projectname_defer_scripts($tag, $handle)
{
  // add script handles to the array below
  $scripts_to_defer = array('common-script');
  foreach ($scripts_to_defer as $defer_script) {
    if ($defer_script === $handle) {
      return str_replace(' src', ' defer src', $tag);
    }
  }
  return $tag;
}
add_filter('script_loader_tag', 'projectname_defer_scripts', 10, 2);


/* Core Setup
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/**
 * Add browser-type to body class
 * www.wpbeginner.com/wp-themes/how-to-add-user-browser-and-os-classes-in-wordpress-body-class/
 */
function projectname_add_browser_type_to_body_classes($classes)
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
add_filter('body_class', 'projectname_add_browser_type_to_body_classes');

/**
 * Pagination
 */
function projectname_pagination($prev = '<', $next = '>')
{
  global $wp_query, $wp_rewrite;
  $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
  $pagination = array(
    'base' => @add_query_arg('paged', '%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => __($prev),
    'next_text' => __($next),
    'type' => 'plain'
  );
  if ($wp_rewrite->using_permalinks())
    $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');

  if (!empty($wp_query->query_vars['s']))
    $pagination['add_args'] = array('s' => get_query_var('s'));

  echo paginate_links($pagination);
};

/**
 * Disable automatic update emails
 */
// Disable for WP core
add_filter('auto_core_update_send_email', function ($send, $type, $core_update, $result) {
  if (!empty($type) && $type == 'success') {
    return false;
  }
  return true;
}, 10, 4);

// Disable for plugins
add_filter('auto_plugin_update_send_email', '__return_false');

/**
 * Second Header Thumbnail
 */
add_image_size('second-header', 1300, 384, true);


/* CPTs
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/**
 * Post Type: ブログ.
 */
function projectname_register_cpt_blog()
{
  $args = [
    "label" => __("ブログ"),
    "labels" => [
      "name" => __("ブログ"),
      "singular_name" => __("ブログ"),
      "menu_name" => __("ブログ"),
    ],
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "can_export" => false,
    "rewrite" => ["slug" => "blog", "with_front" => true],
    "query_var" => true,
    "menu_icon" => "dashicons-admin-post", // https://developer.wordpress.org/resource/dashicons/
    "supports" => ["title", "editor", "thumbnail", "excerpt"],
    "taxonomies" => ["blog-type"],
    "show_in_graphql" => false,
  ];

  register_post_type("blog", $args);
}
add_action('init', 'projectname_register_cpt_blog');

/**
 * Taxonomy: タイプ（ブログ）.
 */
function projectname_register_tax_blog_type()
{
  $args = [
    "label" => __("タイプ（ブログ）"),
    "labels" => [
      "name" => __("タイプ（ブログ）"),
      "singular_name" => __("タイプ（ブログ）"),
    ],
    "public" => true,
    "publicly_queryable" => true,
    "hierarchical" => true,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => ['slug' => 'blog-type', 'with_front' => true],
    "show_admin_column" => false,
    "show_in_rest" => true,
    "show_tagcloud" => false,
    "rest_base" => "blog_type",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("blog_type", ["blog"], $args);
}
add_action('init', 'projectname_register_tax_blog_type');


/* ACF
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/**
 * ACF Options Pages
 */
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'     => 'サイト設定',
    'menu_title'    => 'サイト設定',
    'menu_slug'     => 'site-settings',
    'capability'    => 'edit_posts',
    'redirect'        => false
  ));

  acf_add_options_page(array(
    'page_title'     => 'トップ設定',
    'menu_title'    => 'トップ設定',
    'menu_slug'     => 'home-settings',
    'capability'    => 'edit_posts',
    'redirect'        => false
  ));
}


/* Contact Form 7
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ */
/**
 * Dequeue CF7 script on irrelevant pages
 */
function projectname_remove_wpcf7_script()
{
  if (!is_page("contact")) {
    wp_dequeue_script("contact-form-7");
    wp_dequeue_script('google-recaptcha');
  }
}
add_action('wp_enqueue_scripts', 'projectname_remove_wpcf7_script', 100);

/**
 * Stop <p> & <br> auto-generation
 */
add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Email Check Validation
 */
function projectname_email_match_validation_filter($result, $tag)
{
  if ('your-email-confirm' == $tag->name) {
    $your_email = isset($_POST['your-email']) ? trim($_POST['your-email']) : '';
    $your_email_confirm = isset($_POST['your-email-confirm']) ? trim($_POST['your-email-confirm']) : '';

    if ($your_email != $your_email_confirm) {
      $result->invalidate($tag, "メールアドレスは一致しません。");
    }
  }

  return $result;
}
add_filter('wpcf7_validate_email*', 'projectname_email_match_validation_filter', 20, 2);

/**
 * Front-end Spam protection (validation)
 */
function projectname_wpcf7_validate_anti_spam_frontend($result, $tag)
{
  $value = str_replace(array(PHP_EOL, ' '), '', esc_attr($_POST['your-name']));
  if (!empty($value)) {
    if (!preg_match("/^[ぁ-んァ-ヶ一-龠々+ー+]+$/u", $value)) {
      $result['valid'] = false;
      $result['reason'] = array('your-name' => 'お名前は日本語で入力してください');
    }
  }
  return $result;
}
add_filter('wpcf7_validate', 'projectname_wpcf7_validate_anti_spam_frontend', 10, 2);

/**
 * Back-end Spam protection (filter)
 */
function  projectname_wpcf7_validate_anti_spam_backend($spam)
{
  if ($spam) {
    return $spam;
  }

  $value = $_POST['your-name'];
  if (!empty($value)) {
    if (!preg_match("/^[ぁ-んァ-ヶ一-龠々+ー+]+$/u", $value)) {
      $spam = true;
    }
  }

  return $spam;
}
add_filter('wpcf7_spam', "projectname_wpcf7_validate_anti_spam_backend", 10, 1);
