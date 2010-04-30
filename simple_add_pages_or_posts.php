<?php
/*
Plugin Name: Simple add pages or posts
Plugin URI: http://www.websitefreelancers.nl
Description: Lets you add multiple pages or posts
Version: 1.1
Author: Simon Dirlik, Ramon Fincken
Author URI: http://www.websitefreelancers.nl
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

if (!defined('PLUGIN_sapp_DIR')) {
   define('PLUGIN_SAPP_DIR', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)));
}

if (!defined('PLUGIN_SAPP_BASENAME')) {
   define('PLUGIN_SAPP_BASENAME', plugin_basename(__FILE__));
}

// Admin only :)
if (is_admin()) {
   require_once PLUGIN_SAPP_DIR . '/sapp.php';
}
?>
