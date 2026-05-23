<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="site-header__inner">
        
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                ?>
                <img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> Logo" class="site-header__logo" src="<?php echo get_theme_file_uri( 'images/logo.png' ); ?>"/>
                <?php
            }
            ?>
        </a>

        <button class="site-header__toggle" aria-label="Toggle Navigation">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <?php
        $header_btn_text = get_theme_mod( 'johannahp_header_button_text', 'Resume' );
        $header_btn_url  = get_theme_mod( 'johannahp_header_button_url', '#' );
        ?>

        <?php
        wp_nav_menu( [
            'theme_location'  => 'primary',
            'container'       => 'nav',
            'container_class' => 'site-header__nav',
            'fallback_cb'     => 'johannahp_primary_nav_fallback',
            'walker'          => new Johannahp_Flat_Nav_Walker(),
            'items_wrap'      => '%3$s' . '<a href="' . esc_url( $header_btn_url ) . '" class="nav-link nav-link--resume-mobile">' . esc_html( $header_btn_text ) . '</a>',
            'depth'           => 1,
        ] );
        ?>
        
        <a href="<?php echo esc_url( $header_btn_url ); ?>" class="site-header__resume"><?php echo esc_html( $header_btn_text ); ?></a>
    </div>
</header>
