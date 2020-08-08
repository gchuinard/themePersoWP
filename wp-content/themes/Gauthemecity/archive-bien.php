<?php get_header() ?>

<h1>Voir tous nos biens</h1>

<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('parts/post.tpl'); ?>
        <?php endwhile; ?>
    </div>
    <!-- Mise en place de la pagination pour les articles -->
    <?php Functions\ft_pagination(); ?>

    <?php else : ?>
    <h1>Il n'y a pas d'article</h1>
<?php endif; ?>

<?php get_footer() ?>