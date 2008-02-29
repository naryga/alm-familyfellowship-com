<div class="<?php print $comment_classes; ?>">
<?php if ($new != '') { ?><span class="new"><?php print $new; ?></span><?php } ?>
<?php if ($title) { ?><h3 class="title"><?php print $title; ?></h3><?php } ?>
<?php if ($picture) print $picture; ?>
    <div class="submitted"><?php print t('On ') . format_date($comment->timestamp, 'custom', 'F jS, Y'); ?> <?php print theme('username', $comment) . t(' said:'); ?></div>
    <div class="content"><?php print $content; ?></div>
    <div class="links"><?php print $links; ?></div>
</div> <!-- /comment -->
