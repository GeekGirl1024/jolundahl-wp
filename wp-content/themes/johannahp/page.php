<?php get_header(); ?>
<main class="post-layout">
    <?php while ( have_posts() ) : the_post(); ?>
    <article class="page-article">
        <h1 class="page-article__title headline-lg"><?php the_title(); ?></h1>
        <div class="page-article__content body-lg">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
