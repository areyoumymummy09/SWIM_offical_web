<?php
get_header();
$description = get_the_archive_description();
?>

<?php if (have_posts()) : ?>
    <div class="page-heading" <?php if (SWIM_taxonomy_image_url()) : ?>style="background-image:url(<?php echo SWIM_taxonomy_image_url(); ?>);" <?php endif; ?>>
        <div class="background-overlay"></div>
        <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
    </div>

    <?php if ($description) : ?>
        <div class=" archive-description"><?php echo wp_kses_post(wpautop($description)); ?></div>
        <hr class="primary">
    <?php endif; ?>

    <div class="posts">
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <?php get_template_part('template-parts/content/content-excerpt'); ?>
        <?php endwhile; ?>
    </div>

<?php else : ?>
    <?php get_template_part('template-parts/content/content-none'); ?>
<?php endif; ?>

<?php get_footer(); ?>