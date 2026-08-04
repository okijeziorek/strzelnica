<?php get_header(); ?>
<section class="content-panel">
<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>><h1><?php the_title(); ?></h1><?php the_content(); ?></article>
<?php endwhile; ?>
</section>
<?php get_footer(); ?>
