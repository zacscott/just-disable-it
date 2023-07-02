<?php

namespace JustDisableIt\Controller;

/**
 * Responsible for handling the settings page for the plugin.
 * 
 * @package JustDisableIt\Controller
 */
class SettingsController {

    public function __construct() {
        
        add_action( 'admin_init', [ $this, 'define_sections' ] );
        add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings_sections' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );

    }

    /**
     * Register the defined sections which settings can be bundled into.
     * 
     * @return void
     */
    public function define_sections() {

        $model = \JustDisableIt\Model\SettingModel::get_instance();

        $model->add_section(
            'general',
            [
                'title' => __( 'General', 'just-disable-it' ),
                'desc'  => __( 'General settings for the plugin.', 'just-disable-it' ),
            ]
        );

        $model->add_section(
            'admin_menus',
            [
                'title' => __( 'Admin Menus', 'just-disable-it' ),
                'desc'  => __( 'Disable admin menus.', 'just-disable-it' ),
            ]
        );

    }

    /**
     * Register the settings page in wp-admin.
     * 
     * @return void
     */
    public function register_settings_page() {

        add_submenu_page(
            'options-general.php',
            __( 'Just Disable It', 'just-disable-it' ),
            __( 'Just Disable It', 'just-disable-it' ),
            'manage_options',
            'just_disable_it',
            [ $this, 'render_settings_page' ]
        );

    }
    
    /**
     * Render the settings page.
     * 
     * @return void
     */
    public function render_settings_page() {

        // Ensure current user has access.
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Show a notice when settings are saved.
        if ( isset( $_POST['update'] ) ) {

            add_settings_error(
                'just_disable_it_messages',
                'just_disable_it_message',
                __( 'Settings Saved', 'just-disable-it' ),
                'updated'
            );

        }

        // Render the settings page.

        $template_path = sprintf(
            '%s/templates/settings/page.php',
            JUST_DISABLE_IT_PLUGIN_ABSPATH
        );

        include $template_path;

    }

    /**
     * Register the settings section within the setting page.
     * 
     * @return void
     */
    public function register_settings_sections() {
        
        $model = \JustDisableIt\Model\SettingModel::get_instance();

        $sections = $model->get_sections();
        foreach ( $sections as $section => $definition ) {

            add_settings_section(
                $section,
                $definition['title'],
                [ $this, 'render_settings_section' ],
                'just_disable_it',
                [
                    'before_section' => '<br><hr>',
                    'after_section'  => '<br>',
                ]
            );

        }

    }

    /**
     * Render the settings section within the setting page.
     * 
     * @return void
     */
    public function render_settings_section( $args ) {

        $template_path = sprintf(
            '%s/templates/settings/section.php',
            JUST_DISABLE_IT_PLUGIN_ABSPATH
        );

        include $template_path;

    }

    /**
     * Register each of the settings/options within the settings section.
     * 
     * @return void
     */
    public function register_settings() {

        $model = \JustDisableIt\Model\SettingModel::get_instance();

        $all_settings = $model->get_settings();
        foreach ( $all_settings as $section => $section_settings ) {

            foreach ( $section_settings as $setting ) {

                $option_name = $model->get_option_name( $setting['setting'] );

                register_setting( 'just_disable_it', $option_name );

                add_settings_field(
                    $option_name, 
                    $setting['label'],
                    [ $this, 'render_settings_field' ],
                    'just_disable_it',
                    $section,
                    $setting
                );

            }

        }
        
    }

    /**
     * Render the given setting/option within the settings section.
     * 
     * @return void
     */
    public function render_settings_field( $args ) {
        
        $template_path = sprintf(
            '%s/templates/settings/field/%s.php',
            JUST_DISABLE_IT_PLUGIN_ABSPATH,
            $args['type']
        );

        include $template_path;

    }

}
