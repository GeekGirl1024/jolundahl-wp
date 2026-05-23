<footer class="site-footer">
    <div class="site-footer__branding">
        <span class="site-footer__name"><?php bloginfo( 'name' ); ?></span>
        <p class="site-footer__copyright">
            &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
        </p>
    </div>
    <?php
    wp_nav_menu( [
        'theme_location'  => 'footer',
        'container'       => 'nav',
        'container_class' => 'site-footer__nav',
        'fallback_cb'     => 'johannahp_footer_nav_fallback',
        'walker'          => new Johannahp_Flat_Nav_Walker(),
        'items_wrap'      => '%3$s',
        'depth'           => 1,
        'link_class'      => 'footer-nav-link',
    ] );
    ?>
    <br />
    <div class="site-footer__social">
        <?php
        $has_social = false;
        for ( $i = 1; $i <= 8; $i++ ) {
            $icon = get_theme_mod( "johannahp_social_icon_$i" );
            $url  = get_theme_mod( "johannahp_social_url_$i" );

            if ( ! empty( $icon ) && ! empty( $url ) ) {
                $has_social = true;
                ?>
                <a class="site-footer__social-link" href="<?php echo esc_url( $url ); ?>">
                    <?php echo johannahp_get_social_icon_svg( $icon ); ?>
                </a>
                <?php
            }
        }

        // Fallback if no social links are set in Customizer
        if ( ! $has_social ) {
            ?>
            <a class="site-footer__social-link" href="#"><span class="material-symbols-outlined">share</span></a>
            <a class="site-footer__social-link" href="#"><span class="material-symbols-outlined">mail</span></a>
            <?php
        }
        ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
