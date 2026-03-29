<?php

/**
 * Template part for displaying post archives and search results
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-header">
		<figure class="post-thumbnail">
			<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail('post-thumbnail'); ?>
			</a>
			<?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
				<figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
			<?php endif; ?>
		</figure>
	</div><!-- .entry-header -->

	<div class="post-content">
		<?php
		the_title(sprintf('<h2 class="post-title"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
		?>
		<?php the_excerpt(); ?>
		<a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html("Learn More"); ?></a>
	</div>
</article>