<?php
$link = menu_item_link($mid);
// replace spaces with "_", and strip HTML
$css_id = str_replace(' ', '_', strip_tags($link));
// render the menu link with unique CSS id.
$output = '<li id="'.$css_id.'" class="'. ($leaf ? 'leaf' : ($children ? 'expanded' : 'collapsed')) .'">'. $link . $children ."</li>\n";
print $output;
?>