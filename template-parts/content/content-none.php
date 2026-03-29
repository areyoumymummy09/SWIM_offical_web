<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<section class="no-results">
	<div class="page-content">
		<h1 class="page-title"><?php esc_html_e('Sorry! That page doesn&rsquo;t seem to exist.', 'swim'); ?></h1>
		<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps go back to the home page for more information.', 'swim'); ?></p>
		<a href="/" class="button"><?php esc_html_e('Home', 'swim'); ?></a>
	</div><!-- .page-content -->
</section><!-- .no-results -->