<?php get_header() ?>

<?php $taxonomySport = get_queried_object(); ?>
<h1><?= $taxonomySport->name ?></h1>

<p><?= $taxonomySport->description ?></p>

<?php $sports = get_terms(['taxonomy' => 'sport']); ?>
<?php if (is_array($sports)): ?>
<ul class="nav nav-pills my-4">
    <?php foreach($sports as $sport): ?>
    <li class="nav-item">
        <a href="<?= get_term_link($sport) ?>" class="nav-link <?= is_tax('sport', $sport->term_id) ? 'active' : '' ?>"><?= $sport->name ?></a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif ?>

<?php if (have_posts()) : ?>
    <div class="row">

        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('parts/post.tpl', 'post'); ?>
        <?php endwhile ?>

    </div>

    <?php Functions\ft_pagination() ?>

    <?= paginate_links(); ?>


<?php else : ?>
    <h1>Pas d'articles</h1>
<?php endif; ?>

<?php get_footer() ?>