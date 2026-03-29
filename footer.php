</main>
</div>
</div>

<?php get_template_part('template-parts/footer/footer-widgets'); ?>

<footer class="site-footer" role="contentinfo">
	<div class="footer-content">
		<?php if (has_custom_logo()) : ?>
			<div class="site-logo">
				<?php the_custom_logo(); ?>
			</div>
		<?php endif; ?>
		<?php if (has_nav_menu('social')) : ?>
			<nav aria-label="<?php esc_attr_e('Social links', 'swim'); ?>" class="footer-social-links">
				<ul class="social-links">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'social',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
							'walker'		 => new SWIM_Social_Walker()
						)
					);
					?>
				</ul>
			</nav>
		<?php endif; ?>
		<?php if (has_nav_menu('footer')) : ?>
			<nav aria-label="<?php esc_attr_e('Secondary menu', 'swim'); ?>" class="footer-navigation">
				<ul class="footer-navigation-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul>
			</nav>
		<?php endif; ?>
		<div class="site-info-container">
			<h5><?php echo __('Contact Info'); ?></h5>
			<hr />
			<p class="site-address"><?php echo esc_html__(get_option('swim_address')); ?></p>
			<p><strong><?php echo esc_html__('Phone'); ?>: </strong><?php echo esc_html__(get_option('swim_phone')); ?></p>
			<p><strong><?php echo esc_html__('Email'); ?>: </strong><?php echo esc_html__(get_option('swim_email')); ?></p>
		</div>
	</div>
	<div class="bottom-bar">
		<p class="copyright">&#169; <?php echo esc_html(date("Y") . ' ' . get_bloginfo('description') . '. All rights reserved', "swim"); ?></p>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>