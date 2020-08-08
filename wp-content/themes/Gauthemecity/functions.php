<?php

namespace   Functions;

require_once __DIR__ . "/metaboxes/Sponso.php";
require_once __DIR__ . "/options/Agence.php";
require_once __DIR__ . "/widgets/YoutubeWidget.php";
require_once __DIR__ . "/options/Apparence.php";

use AgenceMenu\AgenceMenuPage;
use Metaboxes\SponsoMetaBox;
use MyWidgets\YoutubeWidget;

//Support des réglages via l'interface wordpress
function    ft_support_title()
{
    //Support du titre
    add_theme_support('title-tag');
    //Support des images d'articles
    add_theme_support('post-thumbnails');
    //Support des menus
    add_theme_support('menus');
    //Choix de l'emplacement des menus
    register_nav_menu('header', 'En tete du menu');
    register_nav_menu('footer', 'Pied de page');
    //Ajout d'un nouveau format d'image
    add_image_size('card-header', 350, 215, true);
}

//Import de bootstrap css et js
function    ft_register_assets()
{
    wp_register_style(
        'bootstrap',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        []
    );
    wp_register_script(
        'bootstrap',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        ['popper', 'jquery'],
        false,
        true
    );
    wp_register_script(
        'popper',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        [],
        false,
        true
    );
    wp_register_script(
        'jquery',
        'https://code.jquery.com/jquery-3.2.1.slim.min.js',
        [],
        false,
        true
    );
    wp_enqueue_style(
        'bootstrap'
    );
    wp_enqueue_script(
        'bootstrap'
    );
}

//Gestion du titre
function    ft_document_title_parts($title)
{
    return ($title);
}

//Gestion du séparateur titre / slogan
function    ft_title_separator()
{
    return ('|');
}

//Ajout de classes aux éléments du menu
function    ft_menu_class($classes)
{
    $classes[] = 'nav-items';
    return ($classes);
}

//Ajout de classes aux liens du menu
function    ft_menu_link_attributes($attrs)
{
    $attrs['class'] = 'nav-link';
    return ($attrs);
}

function    ft_pagination()
{
    $pages = paginate_links(['type' => 'array']);

    if ($pages != null) {
        echo '<nav aria-label="Pagination" class="my-4">';
        echo '<ul class="pagination">';
        foreach ($pages as $page) {
            //Si la pagination est la pagination actuelle, on ajoute a la class 'active', pour avoir class="page-item active"
            $class = 'page-item';
            if (strpos($page, 'current') === true) {
                $class .= ' active';
            }
            echo '<li class="' . $class . '">';
            //On remplace la class par défaut de wordpress 'page-numbers' par celle de bootstrap 'page-link'
            echo str_replace('page-numbers', 'page-link', $page);
            echo '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}

//Ajout d'un nouveau type de catégorie/étiquette, exemple 'sport'.
//Le tableau 'labels' sert a personnaliser l'interface wordpress, exemple : a la place de 'ajouter une étiquette' on aura 'ajouter un sport'
function    ft_init()
{
    register_taxonomy('sport', 'post', [
        'labels' => [
            'name'              => 'Sport',
            'singular_name'     => 'Sport',
            'plural_name'       => 'Sports',
            'search_items'      => 'Rechercher des sports',
            'all_items'         => 'Tous les sports',
            'edit_item'         => 'Editer le sport',
            'update_item'       => 'Mettre à jour le sport',
            'add_new_item'      => 'Ajouter un nouveau sport',
            'new_item_name'     => 'Ajouter un nouveau sport',
            'menu_name'         => 'Sport',
        ],
        //Rend accessible dans l'interface wordpress des articles 'sport'. Cela permet d'attribuer cette nouvelle étiquette plus facilement
        'show_in_rest'      => true,
        //Permet d'avoir une liste de checkbox pour sélectionner l'étiquette souhaitée et non un input texte
        'hierarchical'      => true,
        //Ajoute la colonne 'Sport' dans le tableau 'Tous les articles' de Wordpress
        'show_admin_column' => true,
    ]);
}

add_action(
    'init',
    'Functions\ft_init'
);
add_action(
    'after_setup_theme',
    'Functions\ft_support_title'
);

add_action(
    'wp_enqueue_scripts',
    'Functions\ft_register_assets'
);

add_filter(
    'document_title_separator',
    'Functions\ft_title_separator'
);

add_filter(
    'nav_menu_css_class',
    'Functions\ft_menu_class'
);

add_filter(
    'nav_menu_link_attributes',
    'Functions\ft_menu_link_attributes'
);



SponsoMetaBox::ft_register();
AgenceMenuPage::ft_register();


add_filter(
    'manage_bien_posts_columns', 
    function($columns)
    {
        return ([
            'cb'        => $columns['cb'],
            'thumbnail' => 'Miniature',
            'title'     => $columns['title'],
            'date'      => $columns['date']
        ]);
    }
);

add_filter(
    'manage_bien_posts_custom_column',
    function ($column, $postId)
    {
        if ($column === 'thumbnail')
        {
            the_post_thumbnail('thumbnail', $postId);
        }
    },
    10,
    2
);

add_action(
    'admin_enqueue_scripts',
    function ()
    {
        wp_enqueue_style('admin_style', get_template_directory_uri() . '/assets/admin.css');
    }
);

add_filter(
    'manage_post_posts_columns',
    function ($columns)
    {
        $new_columns = [];
        foreach ($columns as $k=> $v)
        {
            if ($k === 'date')
            {
                $new_columns['sponso'] = 'Article sponsorisé ?';
            }
            $new_columns[$k] = $v;
        }
        return ($new_columns);
    }
);

add_filter(
    'manage_post_posts_custom_column',
    function ($column, $postId)
    {
        if ($column === 'sponso')
        {
            if (empty(get_post_meta($postId, SponsoMetaBox::META_KEY, true)))
            {
                $class = 'no';
            }
            else
            {
                $class = 'yes';
            }
            ?>
            <div class="bullet bullet-<?= $class ?>"></div>
            <?php
        }
    },
    10,
    2
);

function    ft_pre_get_posts($query)
{
    if (is_admin() || !is_home() || !$query->is_main_query())
    {
        return (0);
    }
    if (get_query_var('sponso') === '1')
    {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key'       =>  SponsoMetaBox::META_KEY,
            'compare'   =>  'EXISTS'
        ];
        $query->set('meta_query', $meta_query);
    }
}

function    ft_query_vars($params)
{
    $params[] = 'sponso';
    return ($params);
}

function    ft_register_widget()
{
    register_widget(YoutubeWidget::class);
    register_sidebar([
        'id'            =>  'homepage',
        'name'          =>  'Sidebar accueil',
        'before_widget' =>  '<div class="p-4 %2$s" id="%1$s">',
        'after_widget'  =>  '</div>',
        'before_title'  =>  '<h4 class="font-italic">',
        'after_title'   =>  '</h4>'
    ]);
}

add_action(
    'pre_get_posts',
    'Functions\ft_pre_get_posts'
);

add_filter(
    'query_vars',
    'Functions\ft_query_vars'
);

add_action(
    'widgets_init',
    'Functions\ft_register_widget'
);

