<?php get_header(); ?>
<main>

<!-- Hero Section -->
<section class="hero">
    <div class="hero__bg">
        <?php
        $hero_image = get_theme_mod( 'johannahp_hero_image');
        if ( ! $hero_image ) {
            $hero_image = get_theme_file_uri( 'images/swing.jpg' );
        }
        
        ?>
        <img alt="Community organizers in Seattle" src="<?php echo esc_url( $hero_image ); ?>"/>
    </div>
    <div class="hero__content">
        <div class="hero__inner">
            <span class="hero__label">ADVOCACY &amp; RESEARCH</span>
            <h1 class="hero__title headline-xl"><?php bloginfo( 'name' ); ?></h1>
            <p class="hero__description body-lg"><?php bloginfo( 'description' ); ?></p>
            <div class="hero__ctas">
                <?php
                $hero_btn_text = get_theme_mod( 'johannahp_hero_button_text', 'View my Work' );
                $hero_btn_url  = get_theme_mod( 'johannahp_hero_button_url', '#updates' );
                ?>
                <a href="<?php echo esc_url( $hero_btn_url ); ?>" class="btn-primary"><?php echo esc_html( $hero_btn_text ); ?></a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Updates Section (Bento Style) -->
<section id="updates" class="updates-section">
    <div class="updates-section__header">
        <div>
            <h2 class="updates-section__title headline-lg">Latest Updates</h2>
            <p class="updates-section__subtitle body-lg">Ongoing community actions and dispatches from the field.</p>
        </div>
        <a class="updates-section__view-all" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">View All Updates</a>
    </div>
    <div class="updates-grid">

        <!-- Main Update Card: post tagged "pinned", or static fallback -->
        <?php
        $pinned_query = new WP_Query( [
            'tag'            => 'pinned',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        ] );
        $has_pinned = $pinned_query->have_posts();
        $pinned_id  = $has_pinned ? $pinned_query->posts[0]->ID : 0;
        ?>
        <?php if ( $has_pinned ) : ?>
            <?php $pinned_query->the_post(); ?>
            <div class="updates-main">
                <div class="updates-main__inner">
                    <div>
                        <div class="updates-card-date">
                            <span class="material-symbols-outlined">calendar_today</span>
                            <span class="updates-card-date__text label-caps"><?php echo esc_html( strtoupper( get_the_date( 'F j, Y' ) ) ); ?></span>
                        </div>
                        <h3 class="updates-main__title headline-lg"><?php the_title(); ?></h3>
                        <p class="updates-main__body body-lg"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40, '...' ) ); ?></p>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <img class="updates-main__img" alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>"/>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="btn-text-link">
                        Read More <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <!-- Static fallback: Federal Building Fridays (no post tagged "pinned") -->
            <div class="updates-main">
                <div class="updates-main__inner">
                    <div>
                        <div class="updates-card-date">
                            <span class="material-symbols-outlined">calendar_today</span>
                            <span class="updates-card-date__text label-caps">EVERY FRIDAY &bull; SEATTLE FEDERAL BUILDING</span>
                        </div>
                        <h3 class="updates-main__title headline-lg">Federal Building Fridays</h3>
                        <p class="updates-main__body body-lg">A weekly gathering of organizers, researchers, and community members demanding accountability and visibility in poverty policy implementation. Join us for open dialogue and collective advocacy sessions.</p>
                    </div>
                    <img class="updates-main__img" alt="Johanna Lundahl presenting on Climate Resiliency" src="<?php echo get_theme_file_uri( 'images/swing.jpg' ); ?>"/>
                    <button class="btn-text-link">
                        Join the Movement <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Sidebar: 2 most recent non-pinned posts -->
        <div class="updates-sidebar">
            <?php
            $recent_args = [
                'posts_per_page' => 2,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post_status'    => 'publish',
            ];
            if ( $pinned_id ) {
                $recent_args['post__not_in'] = [ $pinned_id ];
            }
            $recent_query = new WP_Query( $recent_args );
            ?>
            <?php if ( $recent_query->have_posts() ) : ?>
                <?php while ( $recent_query->have_posts() ) : $recent_query->the_post(); ?>
                    <div class="updates-sidebar-card">
                        <?php $cats = get_the_category(); ?>
                        <?php if ( ! empty( $cats ) ) : ?>
                            <span class="updates-sidebar-card__label label-caps"><?php echo esc_html( strtoupper( $cats[0]->name ) ); ?></span>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="updates-sidebar-card__title headline-md"><?php the_title(); ?></a>
                        <p class="updates-sidebar-card__excerpt body-sm"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?></p>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="updates-sidebar-card">
                    <span class="updates-sidebar-card__label label-caps">EVENT RECAP</span>
                    <span class="updates-sidebar-card__title headline-md">Dismantling Poverty Summit</span>
                    <p class="updates-sidebar-card__excerpt body-sm">Insights from the statewide strategy meeting held in Olympia.</p>
                </div>
                <div class="updates-sidebar-card">
                    <span class="updates-sidebar-card__label label-caps">COMMUNITY CALL</span>
                    <span class="updates-sidebar-card__title headline-md">Lived Experience Panel</span>
                    <p class="updates-sidebar-card__excerpt body-sm">Seeking participants for the next legislative feedback loop.</p>
                </div>
            <?php endif; ?>

            <!-- Stat card — always static -->
            <div class="updates-stat-card">
                <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e3e3e3"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg>
                <p class="updates-stat-card__number">1,200+ Active Organizers</p>
                <p class="updates-stat-card__label">Across Washington State</p>
            </div>
        </div>

    </div>
</section>

<!-- Research & Policy Section -->
<section id="research" class="research-section">
    <div class="research-section__inner">
        <div class="research-section__heading">
            <h2 class="research-section__title headline-lg">Research &amp; Policy</h2>
            <p class="research-section__subtitle body-lg">Evidence-based advocacy for structural change.</p>
        </div>
        <div class="research-grid">
            <?php
            $research_query = new WP_Query( [
                'category_name'  => 'research',
                'posts_per_page' => 2,
                'post_status'    => 'publish',
            ] );

            $static_research = [
                [
                    'title'      => 'The Amazingness of Johanna',
                    'excerpt'    => 'A comprehensive policy report detailing the legislative framework for mandated community oversight in Washington State social services.',
                    'icon_url'   => get_theme_file_uri( 'images/swing.jpg' ),
                    'link_label' => 'Download PDF Report',
                    'permalink'  => '#',
                ],
                [
                    'title'      => 'Washington State Poverty Dismantling',
                    'excerpt'    => '2026 Data Analysis on wealth gaps and systemic barriers affecting rural and urban workers across the Pacific Northwest.',
                    'icon_url'   => get_theme_file_uri( 'images/swing.jpg' ),
                    'link_label' => 'Download Data Set',
                    'permalink'  => '#',
                ],
            ];

            if ( $research_query->have_posts() ) :
                $fallback_icons = array_column( $static_research, 'icon_url' );
                $card_index     = 0;
                while ( $research_query->have_posts() ) : $research_query->the_post();
                    $icon_url   = get_post_meta( get_the_ID(), 'research_icon_url', true );
                    $link_label = get_post_meta( get_the_ID(), 'research_link_label', true ) ?: 'Read More';
                    if ( empty( $icon_url ) && isset( $fallback_icons[ $card_index ] ) ) {
                        $icon_url = $fallback_icons[ $card_index ];
                    }
            ?>
                <div class="research-card">
                    <?php if ( ! empty( $icon_url ) ) : ?>
                        <div class="research-card__icon-wrap">
                            <img class="research-card__icon" alt="<?php echo esc_attr( get_the_title() ); ?> icon" src="<?php echo esc_url( $icon_url ); ?>"/>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="research-card__title headline-md"><?php the_title(); ?></h3>
                        <p class="research-card__excerpt body-sm"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30, '...' ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="research-card__link">
                            <span class="material-symbols-outlined">download</span> <?php echo esc_html( $link_label ); ?>
                        </a>
                    </div>
                </div>
            <?php
                    $card_index++;
                endwhile;
                wp_reset_postdata();
            else :
                foreach ( $static_research as $item ) :
            ?>
                <div class="research-card">
                    <div class="research-card__icon-wrap">
                        <img class="research-card__icon" alt="<?php echo esc_attr( $item['title'] ); ?> icon" src="<?php echo esc_url( $item['icon_url'] ); ?>"/>
                    </div>
                    <div>
                        <h3 class="research-card__title headline-md"><?php echo esc_html( $item['title'] ); ?></h3>
                        <p class="research-card__excerpt body-sm"><?php echo esc_html( $item['excerpt'] ); ?></p>
                        <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="research-card__link">
                            <span class="material-symbols-outlined">download</span> <?php echo esc_html( $item['link_label'] ); ?>
                        </a>
                    </div>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Archive & Storytelling Section -->
<section id="storytelling" class="storytelling-section">
    <h2 class="storytelling-section__title headline-lg">Storytelling</h2>
    <div class="story-grid">
        <?php
        $story_query = new WP_Query( [
            'category_name'  => 'storytelling',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
        ] );

        $static_stories = [
            [
                'label'   => 'ESSAY',
                'title'   => 'Food Sovereignty in the Pacific Northwest',
                'excerpt' => '',
                'link'    => '#',
                'img_url' => get_theme_file_uri( 'images/swing.jpg' ),
            ],
            [
                'label'   => 'JOURNALISM &bull; THE DAILY UW',
                'title'   => 'Labor Rights and Student Advocacy',
                'excerpt' => 'An archive of reported pieces focusing on the intersection of academic labor and municipal policy during my time at the University of Washington.',
                'link'    => '#',
                'img_url' => get_theme_file_uri( 'images/swing.jpg' ),
            ],
            [
                'label'   => 'TRANSCRIPT',
                'title'   => 'The Ethics of Community Research',
                'excerpt' => 'Reflections on a Decade of Advocacy.',
                'link'    => '#',
                'img_url' => get_theme_file_uri( 'images/swing.jpg' ),
            ],
            [
                'label'   => 'PODCAST',
                'title'   => "Seattle's Invisible Workforce",
                'excerpt' => 'Oral histories of urban labor.',
                'link'    => '#',
                'img_url' => get_theme_file_uri( 'images/swing.jpg' ),
            ],
        ];

        if ( $story_query->have_posts() ) :
            $story_posts = [];
            while ( $story_query->have_posts() ) :
                $story_query->the_post();
                $cats      = get_the_category();
                $cat_label = ! empty( $cats ) ? strtoupper( $cats[0]->name ) : 'STORY';
                $story_posts[] = [
                    'label'   => get_post_meta( get_the_ID(), 'story_type_label', true ) ?: $cat_label,
                    'title'   => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'link'    => get_the_permalink(),
                    'img_url' => get_the_post_thumbnail_url( null, 'large' ) ?: '',
                ];
            endwhile;
            wp_reset_postdata();
            $stories = $story_posts;
        else :
            $stories = $static_stories;
        endif;

        foreach ( $stories as $i => $story ) :
            $img_url = isset( $story['img_url'] ) ? $story['img_url'] : '';
            $has_img = ! empty( $img_url );

            if ( $i === 0 ) :
                // Tall left column — image background with gradient overlay
        ?>
            <div class="story-item story-item--tall">
                <?php if ( $has_img ) : ?>
                    <img class="story-item__bg" alt="<?php echo esc_attr( $story['title'] ); ?>" src="<?php echo esc_url( $img_url ); ?>"/>
                <?php else : ?>
                    <div class="story-item__overlay story-item__overlay--spruce"></div>
                <?php endif; ?>
                <div class="story-item__overlay story-item__overlay--gradient"></div>
                <div class="story-item__content">
                    <span class="story-item__label story-item__label--terracotta label-caps"><?php echo esc_html( $story['label'] ); ?></span>
                    <h3 class="story-item__title story-item__title--oatmeal headline-md"><?php echo esc_html( $story['title'] ); ?></h3>
                    <a class="story-item__link story-item__link--oatmeal" href="<?php echo esc_url( $story['link'] ); ?>">Read Story</a>
                </div>
            </div>
        <?php
            elseif ( $i === 1 ) :
                // Wide right top — text dominant with faint image
        ?>
            <div class="story-item story-item--wide">
                <?php if ( $has_img ) : ?>
                    <img class="story-item__bg--faint" alt="<?php echo esc_attr( $story['title'] ); ?>" src="<?php echo esc_url( $img_url ); ?>"/>
                <?php endif; ?>
                <div class="story-item__overlay story-item__overlay--oatmeal"></div>
                <div class="story-item__content--full">
                    <span class="story-item__label story-item__label--grey label-caps"><?php echo $story['label']; ?></span>
                    <h3 class="story-item__title story-item__title--spruce headline-lg"><?php echo esc_html( $story['title'] ); ?></h3>
                    <?php if ( ! empty( $story['excerpt'] ) ) : ?>
                        <p class="story-item__excerpt story-item__excerpt--variant body-lg"><?php echo esc_html( wp_trim_words( $story['excerpt'], 30, '...' ) ); ?></p>
                    <?php endif; ?>
                    <a class="story-item__link--external" href="<?php echo esc_url( $story['link'] ); ?>">
                        Explore Archive <span class="material-symbols-outlined">open_in_new</span>
                    </a>
                </div>
            </div>
        <?php
            elseif ( $i === 2 ) :
                // Bottom right left — dark card
        ?>
            <div class="story-item story-item--short story-item--dark">
                <span class="story-item__label story-item__label--faint label-caps"><?php echo esc_html( $story['label'] ); ?></span>
                <h3 class="story-item__title story-item__title--oatmeal headline-md"><?php echo esc_html( $story['title'] ); ?></h3>
                <?php if ( ! empty( $story['excerpt'] ) ) : ?>
                    <p class="story-item__excerpt story-item__excerpt--faint"><?php echo esc_html( wp_trim_words( $story['excerpt'], 10, '...' ) ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $story['link'] ) && $story['link'] !== '#' ) : ?>
                    <a href="<?php echo esc_url( $story['link'] ); ?>" class="story-item__link--faint">Read More</a>
                <?php endif; ?>
            </div>
        <?php
            elseif ( $i === 3 ) :
                // Bottom right right — accent card
        ?>
            <div class="story-item story-item--short story-item--accent">
                <span class="story-item__label story-item__label--faint label-caps"><?php echo esc_html( $story['label'] ); ?></span>
                <h3 class="story-item__title story-item__title--oatmeal headline-md"><?php echo esc_html( $story['title'] ); ?></h3>
                <?php if ( ! empty( $story['excerpt'] ) ) : ?>
                    <p class="story-item__excerpt story-item__excerpt--faint"><?php echo esc_html( wp_trim_words( $story['excerpt'], 10, '...' ) ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $story['link'] ) && $story['link'] !== '#' ) : ?>
                    <a href="<?php echo esc_url( $story['link'] ); ?>" class="story-item__link--faint">Read More</a>
                <?php endif; ?>
            </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>
</section>


</main>
<?php get_footer(); ?>
