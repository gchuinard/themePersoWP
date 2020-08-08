<?php

get_header() ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <h1>
            <?php the_title() ?>
        </h1>
        <p>
            <img src="<?php the_post_thumbnail_url() ?>" alt="" style="width: 100%; height: auto;">
        </p>
        <p>
            <?php the_content(); ?>
        </p>
    <?php endwhile; ?>
    </div>
<?php else : ?>
    <h1>Il n'y a pas d'article</h1>
<?php endif; ?>

<?php get_footer() ?>