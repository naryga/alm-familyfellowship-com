<?php
// $Id: image.imagemagick.inc,v 1.3.2.11 2007/08/19 19:03:40 drewish Exp $

/**
 * Return information about the imagemagick toolkit
 */
function image_imagemagick_info() {
  return array('name' => 'imagemagick', 'title' => 'ImageMagick Toolkit.');
}

/**
 * Validate and return toolkit specific settings
 */
function image_imagemagick_settings() {
  $form['#after_build'] = array('_image_imagemagick_build_version');
  
  $form['imagemagick_binary'] = array(
    '#type' => 'fieldset',
    '#title' => t('ImageMagick Binary'),
    '#collapsible' => FALSE,
    '#description' => t('ImageMagick is a standalone program used to manipulate images. To use it, it must be installed on your server and you need to know where it is located. If you are unsure of the exact path consult your ISP or server administrator.'),
  );
  $form['imagemagick_binary']['image_imagemagick_convert'] = array(
    '#type' => 'textfield',
    '#title' => t('Path to the "convert" binary'),
    '#default_value' => variable_get('image_imagemagick_convert', '/usr/bin/convert'),
    '#required' => TRUE,
    '#description' => t('Specify the complete path to the ImageMagic <kbd>convert</kbd> binary. For example: <kbd>/usr/bin/convert</kbd> or <kbd>C:\Program Files\ImageMagick-6.3.4-Q16\convert.exe</kbd>'),
  );

  $form['imagemagick_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('ImageMagick Advanced Options'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('These are advanced options for controling the ImageMagick. If you do not understand what these settings do you should not change them.'),
  );
  $form['imagemagick_options']['image_imagemagick_option_strip'] = array(
    '#type' => 'checkbox',
    '#title' => t('Strip the image of any profiles or comments'),
    '#default_value' => variable_get('image_imagemagick_option_strip', 0),
    '#description' => t('Checking this option may reduce file sizes by removing any color profiles or comments embedded in the image. <a href="!link">More information on -strip</a>', array('!link' => url('http://www.imagemagick.org/script/command-line-options.php#strip'))),
  );
  return $form;
}

function _image_imagemagick_build_version($form, $form_element) {
  // Don't check the path when another toolkit is being selected.  
  if (!isset($form['#post']['image_toolkit']) || $form['#post']['image_toolkit'] == 'imagemagick') {
    $valid = _image_imagemagick_check_path($form_element['image_imagemagick_convert'], 'image_imagemagick_convert');
    if ($valid) {
      _image_imagemagick_convert_exec('-version', $output, $errors);
      $form['imagemagick_binary']['version'] = array(
        '#type' => 'item',
        '#value' => '<pre>'. check_plain(trim($output)) .'</pre>',
      );
    }
  }
  return $form;
}

function _image_imagemagick_check_path($path, $attach_error_to = FALSE) {
  if (is_file($path)) {
    return TRUE;
  }
  if ($attach_error_to) {
    if ($open_basedir = ini_get('open_basedir')) {
      form_set_error($attach_error_to, t("No file %file could be found. PHP's <a href='!open-basedir'>open_basedir</a> security resriction is set to %open-basedir, which may be interfearing with the attempts to locate ImageMagick.", array('%file' => $path, '%open-basedir' => $open_basedir, '!info-link' => url('http://php.net/features.safe-mode#ini.open-basedir') )));
    }
    else {
      form_set_error($attach_error_to, t('The specified ImageMagic path %file does not exist.', array('%file' => $path)));
    }
  }
  return FALSE;
}

/**
 * Resize an image to the given width and height.
 */
function image_imagemagick_resize($source, $dest, $width, $height) {
  $filter = ' -scale '. $width .'x'. $height .'! -filter QUADRATIC';
  return _image_imagemagick_convert($source, $dest, $filter);
}

/**
 * Rotate an image.
 */
function image_imagemagick_rotate($source, $dest, $degrees, $bg_color = 0x000000) {
  $filter = ' -rotate '. escapeshellarg($degrees) .' -background #'. str_pad(dechex($bg_color), 6, 0);
  return _image_imagemagick_convert($source, $dest, $filter);
}

/**
 * Crop an image to the specified dimensions.
 */
function image_imagemagick_crop($source, $dest, $x, $y, $width, $height) {
  $filter = ' -crop '. $width .'x'. $height .'+'. $x .'+'. $y;
  return _image_imagemagick_convert($source, $dest, $filter);
}

/**
 * Calls the convert executable with the specified filter.
 */
function _image_imagemagick_convert($source, $dest, $filter) {
  if (variable_get('image_imagemagick_option_strip', 0)) {
    $filter .= ' -strip ';
  }

  $command = implode(' ', array(
    preg_replace("/[^A-Za-z0-9\!\.\-\+\040]/", '', $filter),
    escapeshellarg($source),
    escapeshellarg($dest),
  ));

  if (0 != _image_imagemagick_convert_exec($command, $output, $errors)) {
    return FALSE;
  }
  return file_exists($dest);
}

function _image_imagemagick_convert_exec($command_args, &$output, &$errors) {
  $convert_path = variable_get('image_imagemagick_convert', '/usr/bin/convert');
  if (!_image_imagemagick_check_path($convert_path)) {
    drupal_set_message(t("ImageMagick could not be found. The admin will need to set the path on the <a href='@image-toolkit-settings'>image toolkit page</a>.", array('@image-toolkit-settings' => url('admin/settings/image-toolkit'))), 'error');
    return FALSE;
  }

  if (strstr($_SERVER['SERVER_SOFTWARE'], 'Win32') || strstr($_SERVER['SERVER_SOFTWARE'], 'IIS')) {
    // Use Window's start command to avoid the "black window" from showing up:
    // http://us3.php.net/manual/en/function.exec.php#56599
    // Use /D to run the command from PHP's current working directory so the
    // file paths don't have to be absolute.
    $convert_path = 'start "window title" /D'. getcwd() .' /b '. escapeshellarg($convert_path);
  }

  $descriptors = array(
    0 => array('pipe', 'r'), // stdin
    1 => array('pipe', 'w'), // stdout
    2 => array('pipe', 'w')  // stderr
  );
  if ($h = proc_open($convert_path .' '. $command_args, $descriptors, $pipes)) {
    $output = '';
    while (!feof($pipes[1])) {
      $output .= fgets($pipes[1]);
    }

    $errors = '';
    while (!feof($pipes[2])) {
      $errors .= fgets($pipes[2]);
    }

    #drupal_set_message(t("ImageMagick command: %command", array('%command' => $convert_path .' '. $command_args)));
    #drupal_set_message(t("ImageMagick output: %output", array('%output' => $output)));
    if ($errors) {
      drupal_set_message(t("ImageMagick reported an error: %error", array('%error' => $errors)), 'error');
    }

    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    return proc_close($h);
  }
  return FALSE;
}

