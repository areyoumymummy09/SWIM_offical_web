<?php
$show_title   = (true === get_theme_mod('display_title_and_tagline', true));
if (has_custom_logo() && $show_title) : ?>
	<div class="site-logo"><?php the_custom_logo(); ?></div>
<?php endif; ?>