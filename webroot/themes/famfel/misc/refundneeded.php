<?php
global $user;
if (count($user->roles) > 1): ?>

<div class="tabs"><?php print $tabs; ?></div>
<?php endif; ?>