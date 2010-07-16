<?php
/**
 * Simple add pages or posts.
 *
 * @category      Wordpress Plugins
 * @package       Plugins
 * @author        Simon Dirlik, Ramon Fincken
 * @copyright     Yes, Open source
 * @version       v 1.1
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

/**
 * Displays the admin page
 */
function plugin_sapp_initpage() {
   if (isset ($_GET['page']) && $_GET['page'] == 'simple-add-pages-or-posts/sapp.php') {
      require_once PLUGIN_SAPP_DIR . '/form.php';
   }
}

/**
 * Additional links on the plugin page
 */
function plugin_sapp_RegisterPluginLinks($links, $file) {
   if ($file == 'simple-add-pages-or-posts/simple_add_pages_or_posts.php') {
      $links[] = '<a href="plugins.php?page=simple-add-pages-or-posts/sapp.php">' . __('Settings') . '</a>';
      $links[] = '<a href="http://donate.ramonfincken.com">' . __('Donate') . '</a>';
      $links[] = '<a href="http://www.mijnpress.nl">' . __('Custom WordPress coding nodig?') . '</a>';      
   }
   return $links;
}

add_filter('plugin_row_meta','plugin_sapp_RegisterPluginLinks', 10, 2);

/**
 * Left menu display in Plugin menu
 */
function plugin_sapp_addMenu() {
   add_submenu_page("plugins.php", "Simple add pages or posts", "Simple add pages and posts", 10, __FILE__, 'plugin_sapp_initpage');
}

add_action('admin_menu', 'plugin_sapp_addMenu');

/**
 * Loading the CSS file
 *//*
function plugin_find_replace_css() {
   $admin_stylesheet_url = plugin_find_replace_plugin_url('styles/style.css');
   echo '<link rel="stylesheet" href="' . $admin_stylesheet_url . '" type="text/css" />';
}
add_action('admin_head', 'plugin_find_replace_css');
*/
/**
 * Generating the url for current Plugin
 *
 * @param String $path
 * @return String
 */
function plugin_sapp_plugin_url($path = '') {
   global $wp_version;

   if (version_compare($wp_version, '2.8', '<')) { // Using WordPress 2.7
      $folder = dirname(plugin_basename(__FILE__));
      if ('.' != $folder)
         $path = path_join(ltrim($folder, '/'), $path);
      return plugins_url($path);
   }
   return plugins_url($path, __FILE__);
}
?>
