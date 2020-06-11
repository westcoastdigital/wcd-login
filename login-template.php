<?php
/**
* Template Name: WCD Login
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php wp_head(); ?>
</head>
<body>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="login-page-wrapper">
        <?php
        $custom_logo_id = get_theme_mod( 'wcd_custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $backgroundcolor= get_theme_mod('wcd_login_background') ? get_theme_mod('wcd_login_background') : '#03132b';
        $overlaycolor= get_theme_mod('wcd_login_overlay') ? get_theme_mod('wcd_login_overlay') : '#000';
        $overlayopacity= get_theme_mod('wcd_login_opacity') ? get_theme_mod('wcd_login_opacity') : '50';
        ?>
        <div class="left-column"  style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full'); ?>);">
            <div class="overlay" style="background-color: <?php echo $overlaycolor; ?>; opacity: <?php echo $overlayopacity; ?>%;"></div>
            <?php do_action('wcd-login-before-logo'); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
                <?php
                if ( $custom_logo_id ) {
                        echo '<img src="' . esc_url( $custom_logo_id ) . '" alt="' . get_bloginfo( 'name' ) . '">';
                } else {
                        echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
                }
                ?>
            </a>
            <?php do_action('wcd-login-after-logo'); ?>
        </div>
        <div class="right-column" style="background-color: <?php echo $backgroundcolor; ?>;">
            <?php do_action('wcd-login-before-form-wrapper'); ?>
            <div class="form-wrapper">
                <?php do_action('wcd-login-before-form'); ?>
                <?php wcd_login_form(); ?>
                <?php do_action('wcd-login-after-form'); ?>
            </div>
            <?php do_action('wcd-login-after-form-wrapper'); ?>
        </div>
    </div>
<?php endwhile; endif; ?>
<?php wp_footer(); ?>
</body>
</html>