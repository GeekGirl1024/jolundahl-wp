<?php get_header(); ?>
<main class="post-layout">
    <?php while ( have_posts() ) : the_post(); ?>
    <article class="single-article">
        <header class="single-article__header">
            <div class="single-article__date">
                <span class="material-symbols-outlined">calendar_today</span>
                <span class="label-caps"><?php echo esc_html( strtoupper( get_the_date( 'F j, Y' ) ) ); ?></span>
            </div>
            <h1 class="single-article__title headline-lg"><?php the_title(); ?></h1>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-article__thumbnail">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            <?php endif; ?>
        </header>
        <div class="single-article__content body-lg">
            <?php the_content(); ?>
        </div>
        <footer class="single-article__footer">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>" class="btn-text-link">
                <span class="material-symbols-outlined">arrow_back</span> Back to Updates
            </a>
        </footer>
    </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
