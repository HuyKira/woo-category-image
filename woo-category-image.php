<?php
/*
Plugin Name: Category with image
Plugin URI: https://huykira.net
Description: Plugin get list category with image for woocommerce
Author: Huy Kira
Version: 1.0
Author URI: http://www.huykira.net
*/
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('HK_CATIMG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('HK_CATIMG_PLUGIN_RIR', plugin_dir_path(__FILE__));

// add css
wp_enqueue_style( 'catimg', HK_CATIMG_PLUGIN_URL . 'css/catimg.css',false, '1.0','all');

// add js
wp_enqueue_script('jquery');
wp_enqueue_script( 'catimg', HK_CATIMG_PLUGIN_URL . 'js/catimg.js',true, '1.0','all');

require_once(HK_CATIMG_PLUGIN_RIR . 'include/widget.php');