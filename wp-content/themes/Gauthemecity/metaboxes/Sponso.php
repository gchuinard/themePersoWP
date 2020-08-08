<?php

namespace Metaboxes;

class   SponsoMetaBox
{
    const   META_KEY = 'key_sponso';
    const   NONCE = 'key_sponso_nonce';

    public static function  ft_register()
    {
        add_action(
            'add_meta_boxes',
            [self::class, 'ft_add'],
            10,
            2
        );
        add_action(
            'save_post',
            [self::class, 'ft_save']
        );
    }

    //Ajout d'un bouton dans l'interface article pour signaler facilement si l'article est un article sponsorisé
    public static function  ft_add($postType, $post)
    {
        if ($postType === 'post' && current_user_can('publish_posts', $post)) 
        {
            add_meta_box(self::META_KEY, 'Sponsoring', [self::class, 'ft_render'], 'post', 'side');
        }
    }

    public static function ft_render($post)
    {
        $value = get_post_meta($post->ID, self::META_KEY, true);
        wp_nonce_field(self::NONCE, self::NONCE);
        ?>
        <input type="hidden" value="0" name="<?= self::META_KEY ?>">
        <input type="checkbox" value="1" name="<?= self::META_KEY ?>" <?php checked($value, '1'); ?>>
        <label for="sponsoArticle">Cet article est-il sponsorisé ?</label>
        <?php
    }

    public static function  ft_save($post)
    {
        //On vérifie que la clé existe bien et que l'utilisateur a les droits pour modifier l'article
        if (
            array_key_exists(self::META_KEY, $_POST) &&
            current_user_can('publish_posts', $post) &&
            wp_verify_nonce($_POST[self::NONCE], self::NONCE)
        ) {
            if ($_POST[self::META_KEY] === '0') {
                delete_post_meta($post, self::META_KEY);
            } else {
                update_post_meta($post, self::META_KEY, 1);
            }
        }
    }
}
