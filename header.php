<?php

/**
 * Theme Name: Gutenbase
 * Author: Sean Verity
 * Text Domain: gutenbase
 * Domain Path: /languages/
 * @package gutenbase
 */

$bodyClass = array();
if(wp_is_mobile()) :
    $bodyClass[] = 'is-mobile'; //add to body class
endif;
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class($bodyClass); ?>>
