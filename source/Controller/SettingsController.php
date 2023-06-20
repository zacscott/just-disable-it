<?php

namespace JustDisableIt\Controller;

/**
 * Responsible for handling the settings page for the plugin.
 * 
 * @package JustDisableIt\Controller
 */
class SettingsController {

    /**
     * The plugin settings options, set by set_settings_config().  
     * @var array $settings
     */
    protected $settings = [];

    public function __construct() {
        
        add_action( 'admin_init', [ $this, 'set_settings_config' ], -1 );
        add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings_section' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );

    }

    /**
     * Set the configuration used to generate the options presented on the settings page.
     * 
     * @return void
     */
    public function set_settings_config() {

        $this->settings = [
            [
                'setting' => 'disable_xmlrpc',
                'type'    => 'checkbox',
                'label'   => __( 'Disable XMLRPC', 'just-disable-it' ),
                'desc'    => __( 'Disable the XMLRPC API interface.', 'just-disable-it' ),
            ],
            [
                'setting' => 'disable_rest_api',
                'type'    => 'checkbox',
                'label'   => __( 'Disable REST API', 'just-disable-it' ),
                'desc'    => __( 'Disable the REST API interface for logged out users.', 'just-disable-it' ),
            ],
            [
                'setting' => 'disable_sitemaps',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Sitemaps', 'just-disable-it' ),
                'desc'    => __( 'Disable the default sitemap.xml generated by WordPress.', 'just-disable-it' ),
            ],
            [
                'setting' => 'disable_comments',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Comments', 'just-disable-it' ),
                'desc'    => __( 'Disable the comment system entirely.', 'just-disable-it' ),
            ],
            [
                'setting' => 'disable_search',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Search', 'just-disable-it' ),
                'desc'    => __( 'Disable any frontend search queries.', 'just-disable-it' ),
            ],
            [
                'setting' => 'disable_author_archives',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Author Archives', 'just-disable-it' ),
                'desc'    => __( 'Disable author archive pages.', 'just-disable-it' ),
            ],
        ];

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
    public function register_settings_section() {
        
        add_settings_section(
            'just_disable_it_section',
            '',
            [ $this, 'render_settings_section' ],
            'just_disable_it'
        );

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

        $model = new \JustDisableIt\Model\SettingModel();

        foreach ( $this->settings as $setting ) {

            $option_name = $model->get_option_name( $setting['setting'] );

            register_setting( 'just_disable_it', $option_name );

            add_settings_field(
                $option_name, 
                $setting['label'],
                [ $this, 'render_settings_field' ],
                'just_disable_it',
                'just_disable_it_section',
                $setting
            );

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
