<?php
/*
 * Plugin Name: qTranslate Menu Item
 * Plugin URI: http://ekologik.se/arild
 * Description: Adds language switcher menu items to end of main menu.
 * Version: 0.1
 * Author: Arild <arild@ekologik.se>
 * Author URI: http://ekologik.se/arild
 * License: GPL2
 * Text Domain: langswitch-item
 */
// TODO Require qTranslate

load_plugin_textdomain( 'langswitch-item', false,
  dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if (!function_exists('langswitch_item')):
// TODO Use wp_get_nav_menu_items?
// http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items
function langswitch_item( $items, $args ) {
  // TODO Enable user to choose menu

  // Iterate through languages
  $langs = qtrans_getSortedLanguages();
  foreach ($langs as $lang) {

    // Don't display for current language
    if ($lang == qtrans_getLanguage())
      continue;

    // Prepare variables
    $URL = qtrans_convertURL($_SERVER["REQUEST_URI"], $lang);
    // I wanted to do as below but it's ugly when language names are not translated
    //$title = sprintf(__('In %s', 'langswitch-item'),
    //  qtrans_getLanguageName($lang));
    $title = qtrans_getLanguageName($lang);

    // Modify output
    // TODO If exists, use function for menu link html
    $items .= sprintf('<li><a href="%1$s" title="%2$s">%2$s</a></li>'."\n",
      $URL, $title);
  }

  return $items;
}
endif;

add_filter('wp_nav_menu_items', 'langswitch_item', 10, 2);
