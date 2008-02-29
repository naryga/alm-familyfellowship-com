<?php

/**
 * The Zen theme allows its subthemes to have their own template.php files
 * The only restriction with these files is that they cannot redefine any of the
 * functions that are already defined in Zen's main template.php file.
 *
 * Also remember that the "main" theme is still Zen, so your theme functions
 * should be named as such:
 *  theme_block()  becomes  zen_block()
 *  theme_feed_icon() becomes zen_feed_icon() as well
 *
 * Additionally, it is not possible for subthemes to redefine regions.
 *
 * For a subtheme to add its own variables, use the function name
 *   zen_variables($hook, $vars)
 */



function zen_variables($hook, $vars) {
  $vars['subtheme_directory'] = path_to_subtheme();
  
  switch ($hook) {
    case 'page':
      // add main Zen styles
      drupal_add_css($vars['directory'] .'/layout.css', 'theme', 'all');
      drupal_add_css($vars['directory'] .'/icons.css', 'theme', 'all');
      drupal_add_css($vars['directory'] .'/zen.css', 'theme', 'all');
      drupal_add_css($vars['directory'] .'/print.css', 'theme', 'print');
      // then load the overrides for the above css
      $vars['css'] = drupal_add_css($vars['subtheme_directory'] .'/overrides.css', 'theme', 'all');
      $vars['styles'] = drupal_get_css();
  }
  return $vars;
}