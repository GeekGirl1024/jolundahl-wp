<?php

function johannahp_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'johannahp' ),
        'footer'  => __( 'Footer Navigation', 'johannahp' ),
    ] );
}
add_action( 'after_setup_theme', 'johannahp_setup' );

/**
 * Register Customizer settings.
 */
function johannahp_customize_register( $wp_customize ) {
    // Hero Section
    $wp_customize->add_section( 'johannahp_hero_section', [
        'title'    => __( 'Hero Section', 'johannahp' ),
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'johannahp_hero_image', [
        'default'           => get_theme_file_uri( 'images/swing.jpg' ),
        'sanitize_callback' => 'esc_url_raw',
    ] );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'johannahp_hero_image', [
        'label'    => __( 'Hero Image', 'johannahp' ),
        'section'  => 'johannahp_hero_section',
        'settings' => 'johannahp_hero_image',
    ] ) );

    $wp_customize->add_setting( 'johannahp_hero_button_text', [
        'default'           => __( 'View my Work', 'johannahp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'johannahp_hero_button_text', [
        'label'   => __( 'Button Text', 'johannahp' ),
        'section' => 'johannahp_hero_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'johannahp_hero_button_url', [
        'default'           => '#updates',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'johannahp_hero_button_url', [
        'label'   => __( 'Button URL', 'johannahp' ),
        'section' => 'johannahp_hero_section',
        'type'    => 'text',
    ] );

    // Header Options
    $wp_customize->add_section( 'johannahp_header_section', [
        'title'    => __( 'Header Options', 'johannahp' ),
        'priority' => 35,
    ] );

    $wp_customize->add_setting( 'johannahp_header_button_text', [
        'default'           => __( 'Resume', 'johannahp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'johannahp_header_button_text', [
        'label'   => __( 'Button Text', 'johannahp' ),
        'section' => 'johannahp_header_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'johannahp_header_button_url', [
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'johannahp_header_button_url', [
        'label'   => __( 'Button URL', 'johannahp' ),
        'section' => 'johannahp_header_section',
        'type'    => 'text',
    ] );

    // Social Links Section
    $wp_customize->add_section( 'johannahp_social_section', [
        'title'    => __( 'Social Links', 'johannahp' ),
        'priority' => 40,
        'description' => __( 'Enter Material Symbol names (e.g., share, mail, facebook) and links.', 'johannahp' ),
    ] );

    $social_icons = [
        ''          => __( 'Select Icon', 'johannahp' ),
        'share'     => __( 'Share', 'johannahp' ),
        'mail'      => __( 'Mail', 'johannahp' ),
        'facebook'  => __( 'Facebook', 'johannahp' ),
        'twitter'   => __( 'Twitter / X', 'johannahp' ),
        'instagram' => __( 'Instagram', 'johannahp' ),
        'linkedin'  => __( 'LinkedIn', 'johannahp' ),
        'youtube'   => __( 'YouTube', 'johannahp' ),
        'public'    => __( 'Website/Global', 'johannahp' ),
    ];

    for ( $i = 1; $i <= 8; $i++ ) {
        // Icon
        $wp_customize->add_setting( "johannahp_social_icon_$i", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ] );
        $wp_customize->add_control( "johannahp_social_icon_$i", [
            'label'   => sprintf( __( 'Icon %d', 'johannahp' ), $i ),
            'section' => 'johannahp_social_section',
            'type'    => 'select',
            'choices' => $social_icons,
        ] );

        // URL
        $wp_customize->add_setting( "johannahp_social_url_$i", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ] );
        $wp_customize->add_control( "johannahp_social_url_$i", [
            'label'   => sprintf( __( 'Icon %d Link', 'johannahp' ), $i ),
            'section' => 'johannahp_social_section',
            'type'    => 'url',
        ] );
    }
}
add_action( 'customize_register', 'johannahp_customize_register' );

function johannahp_enqueue_scripts() {
    wp_enqueue_style(
        'johannahp-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Source+Serif+4:ital,wght@0,400;0,600;1,400&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'johannahp-style',
        get_stylesheet_uri(),
        [ 'johannahp-google-fonts' ],
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'johannahp_enqueue_scripts' );

/**
 * Mobile menu toggle script.
 */
function johannahp_mobile_menu_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.querySelector('.site-header__toggle');
        var nav = document.querySelector('.site-header__nav');
        if (toggle && nav) {
            toggle.addEventListener('click', function() {
                nav.classList.toggle('is-open');
                var icon = toggle.querySelector('.material-symbols-outlined');
                if (nav.classList.contains('is-open')) {
                    icon.textContent = 'close';
                } else {
                    icon.textContent = 'menu';
                }
            });
        }
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'johannahp_mobile_menu_script' );

// Flat nav walker — outputs <a> tags directly, no <ul>/<li> wrapper.
class Johannahp_Flat_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;

        if ( ! empty( $args->link_class ) ) {
            $link_class = $args->link_class;
        } else {
            $is_current = in_array( 'current-menu-item', $classes, true );
            $link_class = 'nav-link' . ( $is_current ? ' nav-link--current' : '' );
        }

        $atts            = [];
        $atts['href']    = ! empty( $item->url ) ? $item->url : '#';
        $atts['class']   = $link_class;
        if ( ! empty( $item->attr_title ) ) $atts['title']  = $item->attr_title;
        if ( ! empty( $item->target ) )     $atts['target'] = $item->target;
        if ( ! empty( $item->xfn ) )        $atts['rel']    = $item->xfn;
        if ( $item->current )               $atts['aria-current'] = 'page';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $output .= '<a' . $attributes . '>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</a>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}

/**
 * Get official SVG icons for social media.
 */
function johannahp_get_social_icon_svg( $icon_name ) {
    $svgs = [
        'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932 6.064-6.932zm-1.292 19.494h2.039L6.486 3.24H4.298l13.311 17.407z"/></svg>',
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/></svg>',
        'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',
        'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
    ];

    if ( isset( $svgs[ $icon_name ] ) ) {
        return $svgs[ $icon_name ];
    }

    // Default Material Symbol if not a brand
    return sprintf( '<span class="material-symbols-outlined">%s</span>', esc_html( $icon_name ) );
}

function johannahp_primary_nav_fallback() {
    $links = [
        'Updates'      => '#updates',
        'Research'     => '#research',
        'Storytelling' => '#storytelling',
        'About'        => '#about',
    ];
    echo '<nav class="site-header__nav">';
    foreach ( $links as $label => $href ) {
        echo '<a class="nav-link" href="' . esc_attr( $href ) . '">' . esc_html( $label ) . '</a>';
    }
    echo '</nav>';
}

function johannahp_footer_nav_fallback() {
    $links = [
        'Privacy Policy' => '#',
        'Contact'        => '#',
        'Mailing List'   => '#',
        'Archive'        => '#',
    ];
    echo '<nav class="site-footer__nav">';
    foreach ( $links as $label => $href ) {
        echo '<a class="footer-nav-link" href="' . esc_attr( $href ) . '">' . esc_html( $label ) . '</a>';
    }
    echo '</nav>';
}
