<?php
// $Id: template.php,v 1.12.2.8 2007/02/16 01:32:18 jjeff Exp $

/**
 * @file
 * File which contains theme overrides for the Zen theme.
 */

/*
 * ABOUT
 *
 *  The template.php file is one of the most useful files when creating or modifying Drupal themes.
 *  You can add new regions for block content, modify or override Drupal's theme functions, 
 *  intercept or make additional variables available to your theme, and create custom PHP logic.
 *  For more information, please visit the Theme Developer's Guide on Drupal.org:
 *  http://drupal.org/node/509
 */

 
/*
 * MODIFYING OR CREATING REGIONS
 *
 * Regions are areas in your theme where you can place blocks.
 * The default regions used in themes  are "left sidebar", "right sidebar", "header", and "footer",  although you can create
 * as many regions as you want.  Once declared, they are made available to the page.tpl.php file as a variable.  
 * For instance, use <?php print $header ?> for the placement of the "header" region in page.tpl.php.
 * 
 * By going to  the administer > site building > blocks page you can choose which regions various blocks should be placed.
 * New regions you define here will automatically show up in the drop-down list by their human readable name.
 */
 
 
/*
 * Declare the available regions implemented by this engine.
 *
 * @return
 *    An array of regions.  The first array element will be used as the default region for themes.
 *    Each array element takes the format: variable_name => t('human readable name')
 */
function zen_regions() {
  return array(
       'left' => t('left sidebar'),
       'right' => t('right sidebar'),
       'content_top' => t('content top'),
       'content_bottom' => t('content bottom'),
       'header' => t('header'),
       'footer' => t('footer')
  );
} 

/*
 * OVERRIDING THEME FUNCTIONS
 *
 *  The Drupal theme system uses special theme functions to generate HTML output automatically.
 *  Often we wish to customize this HTML output.  To do this, we have to override the theme function.
 *  You have to first find the theme function that generates the output, and then "catch" it and modify it here.
 *  The easiest way to do it is to copy the original function in its entirety and paste it here, changing
 *  the prefix from theme_ to zen_.  For example:
 *
 *   original:  theme_breadcrumb() 
 *   theme override:   zen_breadcrumb()
 *
 *  See the following example. In this theme, we want to change all of the breadcrumb separator links from  >> to ::
 *
 */

 /**
  * Return a themed breadcrumb trail.
  *
  * @param $breadcrumb
  *   An array containing the breadcrumb links.
  * @return a string containing the breadcrumb output.
  */
 function zen_breadcrumb($breadcrumb) {
   if (!empty($breadcrumb)) {
     return '<div class="breadcrumb">'. implode(' :: ', $breadcrumb) .'</div>';
   }
 }
 
 
/* 
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *  The most powerful function available to themers is the _phptemplate_variables() function. It allows you
 *  to pass newly created variables to different template (tpl.php) files in your theme. Or even unset ones you don't want
 *  to use.
 *
 *  It works by switching on the hook, or name of the theme function, such as:
 *    - page
 *    - node
 *    - comment
 *    - block
 *
 * By switching on this hook you can send different variables to page.tpl.php file, node.tpl.php
 * (and any other derivative node template file, like node-forum.tpl.php), comment.tpl.php, and block.tpl.php
 *
 */

 
/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */

function _phptemplate_variables($hook, $vars = array()) {  
  // get the currently logged in user
  global $user;

  // set a new $is_admin variable
  // this is determined by looking at the currently logged in user and seeing if they are in the role 'admin'
  // the 'admin' will need to have been created manually for this to work
  // this variable is available to all templates
  $vars['is_admin'] = in_array('admin', $user->roles);

  switch ($hook) {
    // Send a new variable, $logged_in, to page.tpl.php to tell us if the current user is logged in or out.
    case 'page':
      
      global $theme, $theme_key;
      
      // if we're in the main theme
      if ($theme == $theme_key) {
        // These next lines add additional CSS files and redefine
        // the $css and $styles variables available to your page template
        // We had previously used @import declarations in the css files,
        // but these are incompatible with the CSS caching in Drupal 5
        drupal_add_css($vars['directory'] .'/layout.css', 'theme', 'all');
        drupal_add_css($vars['directory'] .'/icons.css', 'theme', 'all');
        drupal_add_css($vars['directory'] .'/zen.css', 'theme', 'all');
        $vars['css'] = drupal_add_css($vars['directory'] .'/print.css', 'theme', 'print');
        $vars['styles'] = drupal_get_css();
      }
      
      // An anonymous user has a user id of zero.      
      if ($user->uid > 0) {
        // The user is logged in.
        $vars['logged_in'] = TRUE;
      }
      else {
        // The user has logged out.
        $vars['logged_in'] = FALSE;
      }
      
      $body_classes = array();
      // classes for body element
      // allows advanced theming based on context (home page, node of certain type, etc.)
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';
      if ($vars['node']->type) {
        // if on an individual node page, put the node type in the body classes
        $body_classes[] = 'ntype-'. zen_id_safe($vars['node']->type);
      }
      switch (TRUE) {
      	case $vars['sidebar_left'] && $vars['sidebar_right'] :
      		$body_classes[] = 'both-sidebars';
      		break;
      	case $vars['sidebar_left'] :
      		$body_classes[] = 'sidebar-left';
      		break;
      	case $vars['sidebar_right'] :
      		$body_classes[] = 'sidebar-right';
      		break;
      }
      // implode with spaces
      $vars['body_classes'] = implode(' ', $body_classes);
      
      break;
      
    case 'node':
      if ($vars['submitted']) {
        // we redefine the format for submitted
        // adding macrotags and 
        $vars['submitted'] =
          t('Posted <abbr class="created" title="!microdate">@date</abbr> by !username',
            array(
              '!username' => theme('username', $vars['node']),
              '@date' => format_date($vars['node']->created,'custom', "F jS, Y"),
              '!microdate' => format_date($vars['node']->created,'custom', "Y-m-d\TH:i:sO")
            )
          );
      }

      // special classes for nodes
      $node_classes = array('node');
      if ($vars['sticky']) {
      	$node_classes[] = 'sticky';
      }
      if (!$vars['node']->status) {
      	$node_classes[] = 'node-unpublished';
      }
      if ($vars['node']->uid && $vars['node']->uid == $user->uid) {
        // node is authored by current user
        $node_classes[] = 'node-mine';
      }
      // class for node type: "ntype-page", "ntype-story", "ntype-my-custom-type", etc.
      $node_classes[] = 'ntype-'. zen_id_safe($vars['node']->type);
      // implode with spaces
      $vars['node_classes'] = implode(' ', $node_classes);
      
      break;
      
    case 'comment':
      // we load the node object that the current comment is attached to
      $node = node_load($vars['comment']->nid);
      // if the author of this comment is equal to the author of the node, we set a variable
      // then in our theme we can theme this comment differently to stand out
      $vars['author_comment'] = $vars['comment']->uid == $node->uid ? TRUE : FALSE;

      $comment_classes = array('comment');
      
      // odd/even handling
      static $comment_odd = TRUE;
      $comment_classes[] = $comment_odd ? 'odd' : 'even';
      $comment_odd = !$comment_odd;
      
      if ($vars['comment']->status == COMMENT_NOT_PUBLISHED) {
      	$comment_classes[] = 'comment-unpublished';
      }
      if ($vars['author_comment']) {
        // comment is by the node author
      	$comment_classes[] = 'comment-by-author';
      }
      if ($vars['comment']->uid == 0) {
        // comment is by an anonymous user
      	$comment_classes[] = 'comment-by-anon';
      }
      if ($user->uid && $vars['comment']->uid == $user->uid) {
        // comment was posted by current user
      	$comment_classes[] = 'comment-mine';
      }
      $vars['comment_classes'] = implode(' ', $comment_classes);
      
      // if comment subjects are disabled, don't display 'em
      if (variable_get('comment_subject_field', 1) == 0) {
        $vars['title'] = '';
      }
      
      break;
  }
  
  // allow subtheme to add/alter variables
  if (function_exists('zen_variables')) {
    $vars = zen_variables($hook, $vars);
  }
  
  return $vars;
}

/**
* Converts a string to a suitable html ID attribute.
* - Preceeds initial numeric with 'n' character.
* - Replaces space and underscore with dash.
* - Converts entire string to lowercase.
* - Works for classes too!
* 
* @param string $string
*  the string
* @return
*  the converted string
*/
function zen_id_safe($string) {
  if (is_numeric($string{0})) {
    // if the first character is numeric, add 'n' in front
    $string = 'n'. $string;
  }
  return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
}

/**
 * This bit allows the subtheme to have its own template.php
 */ 
if (path_to_subtheme()) {
  // I'm being careful not to create variables in the global scope
  if (file_exists(path_to_subtheme() .'/template.php')) {
    include_once(path_to_subtheme() .'/template.php');
  }
}

/**
 * These next functions allow subthemes to have their own
 * page.tpl.php, node.tpl.php, node-type.tpl.php, etc.
 */ 
function _phptemplate_node($vars, $suggestions) {
  array_unshift($suggestions, 'node'); // not quite sure why I need to do this...
  return _zen_default('node', $vars, $suggestions);
}

function _phptemplate_comment($vars, $suggestions) {
  array_unshift($suggestions, 'comment'); // not quite sure why I need to do this...
  return _zen_default('comment', $vars, $suggestions);
}

function _phptemplate_page($vars, $suggestions) {
  return _zen_default('page', $vars, $suggestions);
}

function _phptemplate_block($vars, $suggestions) {
  return _zen_default('block', $vars, $suggestions);
}

function _phptemplate_box($vars, $suggestions) {
  return _zen_default('box', $vars, $suggestions);
}

/**
 * return path to the subtheme directory
 * or FALSE if there is no subtheme
 */ 
function path_to_subtheme() {
  global $theme, $theme_key;
  static $theme_path;
  if (!isset($theme_path)) {
    if ($theme != $theme_key) {
      $themes = list_themes();
      $theme_path = dirname($themes[$theme_key]->filename);
    }
    else {
      $theme_path = FALSE;
    }
  }
  return $theme_path;
}

/**
 * This is an exact copy of _phptemplate_default() with the
 * addition of the $theme_path and $parent_theme_path
 */ 
function _zen_default($hook, $variables, $suggestions = array(), $extension = '.tpl.php') {
  global $theme_engine;
  global $theme;
  global $theme_key;
  
  if ($theme_path = path_to_subtheme()) {
    $parent_theme_path = path_to_theme();
  }
  else {
    $theme_path = path_to_theme();
  }
  
  // Loop through any suggestions in FIFO order.
  $suggestions = array_reverse($suggestions);
  foreach ($suggestions as $suggestion) {
    if (!empty($suggestion) && file_exists($theme_path .'/'. $suggestion . $extension)) {
      $file = $theme_path .'/'. $suggestion . $extension;
      break;
    }
    elseif (isset($parent_theme_path) && !empty($suggestion) && file_exists($parent_theme_path .'/'. $suggestion . $extension)) {
      $file = $parent_theme_path .'/'. $suggestion . $extension;
      break;
    }
  }

  if (!isset($file)) {
    if (file_exists($theme_path ."/$hook$extension")) {
      $file = $theme_path ."/$hook$extension";
    }
    else {
      if (in_array($hook, array('node', 'block', 'box', 'comment'))) {
        $file = "themes/engines/$theme_engine/$hook$extension";
      }
      else {
        $variables['hook'] = $hook;
        watchdog('error', t('%engine.engine was instructed to override the %name theme function, but no valid template file was found.', array('%engine' => $theme_engine, '%name' => $hook)));
        $file = "themes/engines/$theme_engine/default$extension";
      }
    }
  }
  if (isset($file)) {
    return call_user_func('_'. $theme_engine .'_render', $file, $variables);
  }
}