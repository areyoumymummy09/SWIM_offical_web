<?php
$page_title_classname = str_replace(' ', '-', strtolower(get_the_title()));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($page_title_classname); ?>>
	<div class="entry-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
