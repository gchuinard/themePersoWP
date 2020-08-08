<?php get_header() ?>

<?php $sports = get_terms(['taxonomy' => 'sport']); ?>
<ul class="nav nav-pills my-4">
    <?php foreach($sports as $sport): ?>
    <li class="nav-item">
        <a href="<?= get_term_link($sport) ?>" class="nav-link <?= is_tax('sport', $sport->term_id) ? 'active' : '' ?>"><?= $sport->name ?></a>
    </li>
    <?php endforeach; ?>
</ul>

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