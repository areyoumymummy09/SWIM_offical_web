<?php
get_header();
if (have_posts()) {

	// Load posts loop.
	while (have_posts()) {
		the_post();

		get_template_part('template-parts/content/content-page');
	}
} else {
	get_template_part('template-parts/content/content-none');
}

get_footer();
