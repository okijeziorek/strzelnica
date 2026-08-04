<?php get_header(); ?>
<section class="content-panel">
    <h1><?php esc_html_e('Nie znaleziono strony', 'gun-resort-one'); ?></h1>
    <p><?php esc_html_e('Podany adres nie prowadzi do istniejącej treści.', 'gun-resort-one'); ?></p>
    <p><a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Wróć na stronę główną', 'gun-resort-one'); ?></a></p>
</section>
<?php get_footer(); ?>
