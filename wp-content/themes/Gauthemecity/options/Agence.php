<?php
namespace AgenceMenu;

class   AgenceMenuPage
{
    const   GROUP = 'agence_options';

    public static function  ft_register()
    {
            add_action('admin_menu', [self::class, 'ft_add_menu']);
            add_action('admin_init', [self::class, 'ft_register_setting']);
            add_action('admin_enqueue_scripts', [self::class, 'ft_register_scripts']);
    }
    
    public static function  ft_register_scripts($suffix)
    {
        if ($suffix === 'settings_page_agence_options')
        {
            wp_register_style(
                'flatpickr', 
                'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', 
                [], 
                false
            );
            wp_register_script(
                'flatpickr', 
                'https://cdn.jsdelivr.net/npm/flatpickr', 
                [], 
                false, 
                true
            );
            wp_register_script(
                'ft_admin', 
                get_template_directory_uri() . '/assets/admin.js', 
                ['flatpickr'], 
                false, 
                true);
            wp_enqueue_script(
                'ft_admin'
            );
            wp_enqueue_style(
                'flatpickr'
            );
        }
    }

    public static function  ft_register_setting()
    {
        register_setting(self::GROUP, 'agence_horaire');
        register_setting(self::GROUP, 'agence_date');
    
        add_settings_section(
            'agence_options_section',
            'Parametres',
            function()
            {
                echo "Vous pouvez gérer ici les parametres liés a l'agence immobiliere.";
            },
            self::GROUP
        );
        add_settings_field(
            'agence_options_horaire',
            'Horaires d\'ouvertures',
            function()
            {
                ?>
                <textarea name="agence_horaire" cols="30" rows="10"><?= esc_html(get_option('agence_horaire')); ?></textarea>
                <?php
            },
            self::GROUP,
            'agence_options_section'
        );
        add_settings_field(
            'agence_options_date',
            'Date d\'ouvertures',
            function()
            {
                ?>
                <input type="text" name="agence_date" value="<?= esc_attr(get_option('agence_date')); ?>" class="ft_date_picker">
                <?php
            },
            self::GROUP,
            'agence_options_section'
        );
    }

    public static function ft_add_menu()
    {
        add_options_page('Gestion de l\'agence', 'Agence', 'manage_options', self::GROUP,  [self::class, 'ft_render']);
    }

    public static function  ft_render()
    {
        ?>
        <h1>Gestion de l'agence</h1>
        <form action="options.php" method="post">
            <?php   settings_fields(self::GROUP);
                    do_settings_sections(self::GROUP);
                    submit_button(); ?>
        </form>
        <?php
    }
}