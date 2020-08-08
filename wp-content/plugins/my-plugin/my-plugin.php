<?php
/** 
 * Plugin Name: My plugin
*/

//Empeche l'affichage du code quand on rentre le chemin du fichier.
defined('ABSPATH') or die ('Error 404');

//La fonction se lance a l'activation du plugin.
register_activation_hook(__FILE__, function ()
{
    
});

//la fonction se lance a la désactivation du plugin.
register_deactivation_hook(__FILE__, function ()
{

});

add_action('init', function ()
{
    register_post_type('bien', [
        'label'             => 'Bien',
        'public'            => true,
        //Permet de choisir la position dans l'interface Wordpress
        'menu_position'     => 3,
        //Permet d'attribuer un icone dans le menu
        'menu_icon'         => 'dashicons-building',
        'supports'          => ['title', 'editor', 'thumbnail'],
        'show_in_rest'      => true,
        'has_archive'       => true,
    ]);
});