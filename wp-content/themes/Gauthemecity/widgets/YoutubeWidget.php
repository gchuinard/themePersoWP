<?php

namespace   MyWidgets;

use WP_Widget;

class   YoutubeWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('youtube_widget', 'Youtube Widget');
    }

    //La fonction "widget" est obligatoire pour éviter les conflits avec la class "WP_Widget". Ne pas changer le nom.
    public function widget($args, $instance)
    {
        echo ($args['before_widget']);
        if (isset($instance['title'])) {
            $title = apply_filters('widget_title', $instance['title']);
            echo ($args['before_title'] . $title . $args['after_title']);
        }
        $youtube = YoutubeWidget::ft_youtube_id($instance);
        echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $youtube . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo ($args['after_widget']);
    }

    public function ft_youtube_id($instance)
    {
        $url_youtube = $instance['youtube'] ?? '';
        $str = '';
        if (strncmp($url_youtube, 'https://www.youtube.com/watch?v=', 32) === 0) 
        {
            $tab_url_youtube = str_split($url_youtube, 32);
            $tab_url_youtube = str_split($tab_url_youtube[1], 11);
            $str = $tab_url_youtube[0];
        }
        elseif (strncmp($url_youtube, 'www.youtube.com/watch?v=', 24) === 0) 
        {
            $tab_url_youtube = str_split($url_youtube, 24);
            $tab_url_youtube = str_split($tab_url_youtube[1], 11);
            $str = $tab_url_youtube[0];
        }
        elseif (strncmp($url_youtube, 'youtube.com/watch?v=', 20) === 0) 
        {
            $tab_url_youtube = str_split($url_youtube, 20);
            $tab_url_youtube = str_split($tab_url_youtube[1], 11);
            $str = $tab_url_youtube[0];
        }
        elseif (strncmp($url_youtube, 'https://youtu.be/', 17) === 0) 
        {
            $tab_url_youtube = str_split($url_youtube, 17);
            $tab_url_youtube = str_split($tab_url_youtube[1], 11);
            $str = $tab_url_youtube[0];
        }
        elseif (strncmp($url_youtube, 'youtu.be/', 9) === 0) 
        {
            $tab_url_youtube = str_split($url_youtube, 9);
            $str = $tab_url_youtube[1] . $tab_url_youtube[2][0] . $tab_url_youtube[2][1];
        }
        else
        {
            $str = $url_youtube;
        }
        return ($str);
}

    //La fonction "form" est obligatoire pour que le widget soit prit en compte par Wordpress. Ne pas changer le nom.
    public function form($instance)
    {
        //Si 'title' n'est pas définit alors on le définit comme une chaine de caractere vide.
        $title = $instance['title'] ?? '';
        $youtube = $instance['youtube'] ?? '';
?>
        <p>
            <label for="<?= $this->get_field_id('title') ?>">Titre</label>
            <input class="widefat" type="text" name="<?= $this->get_field_name('title') ?>" value="<?= esc_attr($title) ?>" id="<?= $this->get_field_id('title') ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('youtube') ?>">Url youtube</label>
            <input class="widefat" type="text" name="<?= $this->get_field_name('youtube') ?>" value="<?= esc_attr($youtube) ?>" id="<?= $this->get_field_id('youtube') ?>">
        </p>
<?php
    }

    public function ft_update($new_instance, $old_instance)
    {
        return ($new_instance);
    }
}
