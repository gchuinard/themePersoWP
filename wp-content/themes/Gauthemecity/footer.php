</div>
<footer>
    <?php

use MyWidgets\YoutubeWidget;

wp_nav_menu(
        [
            'theme_location' => 'footer',
            'container' => false,
            'menu_class' => 'navbar-nav mr-auto'
        ]
    );
    the_widget(YoutubeWidget::class, ['title' => 'Widget dans le footer', 'youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&list=RDdQw4w9WgXcQ&start_radio=1'])
    ?>
</footer>
<div>
    <?= get_option('agence_horaire'); ?>
</div>
<?php wp_footer() ?>
</body>

</html>