<?php

/*********************************************************************
 * Themeable functions for playing videos. They print a page with a player embedded.
 *********************************************************************/

/**
 * Play videos from in FLV Flash video format
 *
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_flash($video) {
  $output_dir = variable_get('flashvideo_' . $video['nodetype'] .'_outputdir', '');
  $output_dir = ($output_dir == '') ? $output_dir : ($output_dir . '/');
  
  // Creates an absolute path for the player.  
  $loader_path = check_url(file_create_url($output_dir . variable_get('flashvideo_' . $video['nodetype'] . '_player', 'Player.swf')));
  $img_vars = (variable_get('flashvideo_' . $video['nodetype'] .'_introimg', '') == '') ? '' : '&image=' . check_url(file_create_url($output_dir . variable_get('flashvideo_' . $video['nodetype'] .'_introimg', ''))); 
  $img_intro = (variable_get('flashvideo_' . $video['nodetype'] .'_introthumb', 1) == 0) ? '' : '&image=' . check_url(str_replace(".flv", ".jpg", $video['file'])); 
  $time_vars = ($img_vars == '') ? '' :  '&rotatetime=' . variable_get('flashvideo_' . $video['nodetype'] .'_introtime', '3');
  $logo_vars = (variable_get('flashvideo_' . $video['nodetype'] .'_logo', '') == '') ? '' : '&logo=' . check_url(file_create_url($output_dir . variable_get('flashvideo_' . $video['nodetype'] .'_logo', '')));
  $logo_link = (variable_get('flashvideo_' . $video['nodetype'] .'_logolink', '') == '') ? '' : '&link=' . variable_get('flashvideo_' . $video['nodetype'] .'_logolink', '');
  
  // Get the window mode
  $wmode = '';
  $wmode_param = '';
  switch(variable_get('flashvideo_' . $video['nodetype'] . '_mode', 'window')) {
    case 'transparent':
      $wmode = ' wmode="transparent"';
      $wmode_param = '<param name="wmode" value="transparent" />';
      break;
    case 'window':
      $wmode = ' wmode="window" allowfullscreen="true"';
      $wmode_param = '<param name="wmode" value="window" /><param name="allowfullscreen" value="true" />'; 
      break; 
  }

  $flashvars = 'file='. $video['file'] . $img_vars . $img_intro . $time_vars . $logo_vars . $logo_link . '&repeat=false&autostart='.$video['autostart'];
  
  $output .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$video['width'].'" height="'.$video['height'].'" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">';
  $output .= '<param name="movie" value="'. $loader_path .'" />'. $wmode_param .'<param name="FlashVars" value="'.$flashvars.'" /><param name="quality" value="high" />';
  $output .= '<embed allowScriptAccess="always" src="'. $loader_path .'" width="'.$video['width'].'" height="'.$video['height'].'" border="0" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"';
  $output .= $wmode . ' quality="high" flashvars="'.$flashvars.'" /></object>';
  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.macromedia.com/go/getflashplayer'),
                                      t('Link to Macromedia Flash Player Download Page'),
                                      t('Download latest Flash Player'));
   return $output;
}

/**
 * Play Flash .swf files.
 *
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_swf($video) {
  // this will be executed by not Internet Explorer browsers
  $output .= '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'" data="'. $video['file'] .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'" ';
  $output .= 'classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="movie" value="'. $video['file'] .'" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>';

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.macromedia.com/go/getflashplayer'), 
                              t('Link to Flash player download'), 
                              t('Download the latest Flash player'));
  return $output;
}

/**
 * Play videos hosted on youtube.com
 * Allows users to host videos on youtube.com and then use the video ID to post it in the module.
 * In the future it could also use the youtube developer API to get info and comments of the video.
 *
 * @param $video
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_youtube($video) {

  // Get the window mode
  $wmode = '';
  $wmode_param = '';
  switch(variable_get('flashvideo_' . $video['nodetype'] . '_mode', 'window')) {
    case 'transparent':
      $wmode = ' wmode="transparent"';
      $wmode_param = '<param name="wmode" value="transparent" />';
      break;
    case 'window':
      $wmode = ' wmode="window" allowfullscreen="true"';
      $wmode_param = '<param name="wmode" value="window" /><param name="allowfullscreen" value="true" />'; 
      break; 
  }

  // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="http://www.youtube.com/v/' . check_plain($video['file']) . '">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="movie" value="http://www.youtube.com/v/' . check_plain($video['file']) . '" />' . $wmode_param;
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>';

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.youtube.com/t/help_center'), t('Link to youtube.com'), t('youtube.com'));
  return $output;
}

/**
 * Play videos hosted on video.google.com
 * Allows users to host videos on video.google.com and then use the video ID to post it in the module.
 *
 * @param $video
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_googlevideo($video) {
  // Strip heading "google:"
  $videoid = substr($video['file'], 7);

  // Get the window mode  
  $wmode = '';
  $wmode_param = '';
  switch(variable_get('flashvideo_' . $video['nodetype'] . '_mode', 'window')) {
    case 'transparent':
      $wmode = ' wmode="transparent"';
      $wmode_param = '<param name="wmode" value="transparent" />';
      break;
    case 'window':
      $wmode = ' wmode="window" allowfullscreen="true"';
      $wmode_param = '<param name="wmode" value="window" /><param name="allowfullscreen" value="true" />'; 
      break; 
  }  

  // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="http://video.google.com/googleplayer.swf?docId='. check_plain($videoid) .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]><object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="movie" value="http://video.google.com/googleplayer.swf?docId=' . check_plain($videoid) . '" />';
  
  // following a list of params simply copied from old embed tag params. I don't know if this are really needed.
  $output .= '<param name="quality" value="best" />';
  $output .= '<param name="bgcolor" value="#ffffff" />';
  $output .= '<param name="allowScriptAccess" value="sameDomain" />';
  $output .= '<param name="scale" value="noScale" />';
  $output .= $wmode_param;
  $output .= '<param name="salign" value="TL" />';
  $output .= '<param name="FlashVars" value="playerMode=embedded" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>';

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://video.google.com/support'), t('Link to video.google.com'), t('video.google.com'));
  return $output;
}

/**
 * Play videos hosted on Brightcove
 * Allows users to host videos on brightcove.com and then use the video ID to post it in the module.
 *
 * @param $video
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_brightcove($video) {
  // Strip heading "google:"
  $videoid = substr($video['file'], 11);

  // Get the window mode
  $wmode = '';
  $wmode_param = '';
  switch(variable_get('flashvideo_' . $video['nodetype'] . '_mode', 'window')) {
    case 'transparent':
      $wmode = ' wmode="transparent"';
      $wmode_param = '<param name="wmode" value="transparent" />';
      break;
    case 'window':
      $wmode = ' wmode="window" allowfullscreen="true"';
      $wmode_param = '<param name="wmode" value="window" /><param name="allowfullscreen" value="true" />'; 
      break; 
  }
  
   // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="http://admin.brightcove.com/destination/player/player.swf">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]><object type="application/x-shockwave-flash" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">';
  $output .= '<![endif]-->';
  
  $output .= '<param name="movie" value="http://admin.brightcove.com/destination/player/player.swf" />';
   // following a list of params simply copied from old embed tag params. I don't know if this are really needed.
  $output .= '<param name="quality" value="best" />';
  $output .= '<param name="bgcolor" value="#ffffff" />';
  $output .= '<param name="allowScriptAccess" value="sameDomain" />';
  $output .= '<param name="scale" value="noScale" />';
  $output .= $wmode_param;
  $output .= '<param name="salign" value="TL" />';
  $output .= '<param name="FlashVars" value="allowFullScreen=true&initVideoId='.$videoid.'&servicesURL=http://www.brightcove.com&viewerSecureGatewayURL=https://www.brightcove.com&cdnURL=http://admin.brightcove.com&autoStart='.$video['autostart'].'" />';
  $output .= _flashvideo_get_parameters($video);
  $output = '<embed src="http://admin.brightcove.com/destination/player/player.swf" ';
  $output .= 'bgcolor="#FFFFFF" flashVars="allowFullScreen=true&initVideoId='.$videoid.'&servicesURL=http://www.brightcove.com&viewerSecureGatewayURL=https://www.brightcove.com&cdnURL=http://admin.brightcove.com&autoStart='.$video['autostart'].'" ';
  $output .= 'base="http://admin.brightcove.com" name="bcPlayer" width="'.$video['width'].'" height="'.$video['height'].'"'. $wmode .' allowScriptAccess="always" seamlesstabbing="false" type="application/x-shockwave-flash" swLiveConnect="true" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>';
  $output .= '</object>';
  
  return $output;
}

/**
 * Play Director .dcr/.dir files.
 *
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */

function theme_flashvideo_play_dcr($video) {
  // this will be executed by not Internet Explorer browsers
  $output .= '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-director" width="'.$video['width'].'" height="'.$video['height'].'" data="'. $video['file'] .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object type="application/x-director" width="'.$video['width'].'" height="'.$video['height'].'" ';
  $output .= 'classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,0,0,0">';
  $output .= '<![endif]-->';

   // params will be passed to both IE or not IE browsers
  $output .= '<param name="src" value="'. $video['file'] .'" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>';

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.macromedia.com/shockwave/download/'),
                                      t('Link to Macromedia Shockwave Player Download Page'),
                                      t('Download latest Shockwave Player'));
   return $output;
}

/**
 * Play videos from in Quicktime format
 *
 * @see http://developer.apple.com/internet/ieembedprep.html
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_quicktime($video) {
  //Increase the height to accommodate the player controls on the bottom.

  // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="video/quicktime" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="'. $video['file'] .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="'.$video['width'].'" height="'.$video['height'].'" scale="tofit" >';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="src" value="'. $video['file'] .'" />';
  $output .= '<param name="AUTOPLAY" value="'.$video['autostart'].'" />';
  $output .= '<param name="KIOSKMODE" value="false" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>'; 
  
  // only one </object> needed becouse only one opening tag has been parsed by browsers

  /*  Removed for now...
  $output = '<script language="JavaScript" type="text/javascript">';
  $output .= 'InsertQuicktimeVideo(\''.$video['file'].'\',\''.$video['width'].'\',\''.$video['height'].'\');';
  $output .= '</script>';
  */

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.apple.com/quicktime/download'),
                                      t('Link to QuickTime Download Page'),
                                      t('Download latest Quicktime Player'));
  return $output;
}

/**
 * Play videos from in Realmedia format
 *
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_realmedia($video) {

  // Real's embeded player includes the controls
  // in the height
  
  // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="audio/x-pn-realaudio-plugin" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="'. $video['file'] .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object type="audio/x-pn-realaudio-plugin" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" >';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="src" value="'. $video['file'] .'" />';
  $output .= '<param name="_ExtentX" value="7276" />';
  $output .= '<param name="" value="3307" />';
  $output .= '<param name="AUTOSTART" value="'.$video['autostart'].'" />';
  $output .= '<param name="SHUFFLE" value="0" />';
  $output .= '<param name="PREFETCH" value="0" />';
  $output .= '<param name="NOLABELS" value="0" />';
  $output .= '<param name="CONTROLS" value="All" />';
  $output .= '<param name="CONSOLE" value="Clip1" />';
  $output .= '<param name="LOOP" value="0" />';
  $output .= '<param name="NUMLOOP" value="0" />';
  $output .= '<param name="CENTER" value="0" />';
  $output .= '<param name="MAINTAINASPECT" value="1" />';
  $output .= '<param name="BACKGROUNDCOLOR" value="#000000" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>'; 
  
  // only one </object> needed becouse only one opening tag has been parsed by browsers

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://www.real.com/'),
                                      t('Link to Real'),
                                      t('Download latest Realmedia Player'));
  return $output;
}

/**
 * Play videos from in WindowsMediaVideo format
 *
 * @param $video
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_windowsmedia($video) {
  // Windows Media's embeded player includes the controls in the height
  // this will be executed by not Internet Explorer browsers
  $output = '<!--[if !IE]> <-->';
  $output .= '<object type="application/x-mplayer2" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' data="'. $video['file'] .'">';
  $output .= '<!--> <![endif]-->';

  // this will be executed by Internet Explorer
  $output .= '<!--[if IE]>';
  $output .= '<object type="application/x-oleobject" width="'.$video['width'].'" height="'.$video['height'].'"';
  $output .= ' classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" >';
  $output .= '<![endif]-->';

  // params will be passed to both IE or not IE browsers
  $output .= '<param name="src" value="'. $video['file'] .'" />';
  $output .= '<param name="URL" value="'.$video['file'].'" />';
  $output .= '<param name="animationatStart" value="true" />';
  $output .= '<param name="transparentatStart" value="true" />';
  $output .= '<param name="autoStart" value="'.$video['autostart'].'" />';
  $output .= '<param name="showControls" value="true" />';
  $output .= '<param name="loop" value="true" />';
  $output .= _flashvideo_get_parameters($video);
  $output .= '<p>'. t('Your browser is not able to display this multimedia content.') .'</p></object>'; 
  
  // only one </object> needed becouse only one opening tag has been parsed by browsers

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, t('http://windowsupdate.microsoft.com/'),
                                      t('Link to Windows Update'),
                                      t('Download latest Windows Media Player'));
  return $output;
}


/**
 * Play Ogg Theora videos with Cortado Applet
 *
 * @param $node
 *   object with node information
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_play_ogg_theora($video) {
  global $base_url;
  $cortado_location = variable_get('video_cortado', $base_url . '/cortado.jar');  

  $output = '<!--[if !IE]>--><object classid="java:com.fluendo.player.Cortado.class" type="application/x-java-applet"';
  $output .= ' archive="' . $cortado_location . '" width="'.$video['width'].'" height="'.$video['height'].'" ><!--<![endif]-->';
  $output .= '<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/update/1.5.0/jinstall-1_5_0-windows-i586.cab" width="'.$video['width'].'" height="'.$video['height'].'" >';
  $output .= '<param name="code" value="com.fluendo.player.Cortado" /><!--[if !IE]>--></object><!--<![endif]-->';
  $output .= '<!-- IE and Konqueror browser need the archive param -->';
  $output .= '<param name="archive" value="' . $cortado_location . '" />';
  $output .= '<param name="url" value="' . $video['file'] . '"/>';
  $output .= '<param name="local" value="false" />';
  $output .= '<param name="keepaspect" value="true" />';
  $output .= '<param name="video" value="true" />';
  $output .= '<param name="audio" value="true" />';
  $output .= '<param name="seekable" value="true" />';
  $output .= '<param name="duration" value="60" />';
  $output .= '<param name="bufferSize" value="200" />';
  $output .= '<strong>This browser does not have a Java Plug-in.<br />';
  $output .= '<a href="http://java.com/download/">Get the latest Java Plug-in here.</a></strong>';
  $output .= '</object>';

  $output = _theme_flashvideo_format_play($video['nodetype'], $output, 
    t('http://java.com/download/'), t('Link to java.com'), t('Download Java'));
  return $output;
}

/**
 * Cut down on redundant link text
 *
 * @param $url
 *   string URL to link to
 *
 * @param $title
 *   string title of link to show on mouseover
 *
 * @param $link_text
 *   string text of the link
 *
 * @return
 *   string HTML link
 */
function _theme_flashvideo_format_play($node_type, $output, $url, $title, $link_text) {
  $output = '<div id="video-player" align="center">' . $output;
  if(variable_get('flashvideo_' . $node_type . '_download', 0)) {
   $output .= '<p>'. t('Problems viewing videos?'); 
      $output .= '<br />'; 
   $output .= l($link_text, $url, array('title' => $title), NULL, NULL, TRUE) . '</p>';      
  }
  return $output . '</div>';
}


/**
 * Import the video.js script
 */
function theme_flashvideo_get_script() {
  drupal_set_html_head('<script defer="defer" type="text/javascript" src="'. check_url(base_path() . drupal_get_path('module', 'flashvideo')) . '/flashvideo.js"></script>');
}

/**
 * Takes an associative array of $fields with 'title' and 'body' keys and outputs the HTML.
 * This theme function allows the same HTML code to generate all the custom and metadata fields.
 *
 * @param $fields
 *   array with 'title' and 'body' keys
 *
 * @return
 *   string of content to display
 */
function theme_flashvideo_fields($fields) {
  $output = '';
  $odd_even = 'odd';
  foreach ($fields as $field) {
    $output .= '<div class="$odd_even"><b>' . check_plain($field['title']) . '</b> ' . check_plain($field['body']) . '</div>';
    $odd_even = ($odd_even == 'odd') ? 'even' : 'odd'; //Always switch its value.
  }
  return $output;
}

?>