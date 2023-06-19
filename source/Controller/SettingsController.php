<?php

namespace JustDisableIt\Controller;

/**
 * Responsible for handling the settings page for the plugin.
 * 
 * @package JustDisableIt\Controller
 */
class SettingsController {

    const SETTINGS = [

    ];

    public function __construct() {
        
        add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings_section' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );

    }

    public function register_settings_page() {

        add_submenu_page(
            'options-general.php',
            'Just Disable It',
            'Just Disable It',
            'manage_options',
            'just_disable_it',
            [ $this, 'render_settings_page' ]
        );

    }
    
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

        // Render the settings template.
        settings_errors( 'just_disable_it_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'just_disable_it' );
                do_settings_sections( 'just_disable_it' );
                submit_button( 'Save' );
                ?>
            </form>
        </div>
        <?php

    }

    public function register_settings_section() {
        
        add_settings_section(
            'just_disable_it_section',
            '',
            [ $this, 'render_settings_section' ],
            'just_disable_it'
        );

    }

    public function register_settings() {

        register_setting( 'just_disable_it', 'just_disable_it_option' );

        add_settings_field(
            'just_disable_it_option', 
            __( 'Pill', 'just-disable-it' ),
            [ $this, 'render_settings_field' ],
            'just_disable_it',
            'just_disable_it_section',
            [
                'option_name' => 'just_disable_it_option',
            ]
        );
        
    }

    public function render_settings_section( $args ) {
        ?>
        <p>
            <?php esc_html_e( 'Some description goes here.', 'just-disable-it' ); ?>
        </p>
        <?php
    }

    public function render_settings_field( $args ) {

        $option_value = get_option( $args['option_name'] );
        $checked      = ! empty( $option_value );

        ?>

        <p>
            <input 
                id="<?php echo esc_attr( $args['option_name'] ); ?>"
                name="<?php echo esc_attr( $args['option_name'] ); ?>"
                type="checkbox"
                <?php echo esc_attr( $checked ); ?>>
        </p>

        <p class="description">
            <?php esc_html_e( 'Some description goes here.', 'just_disable_it' ); ?>
        </p>

        <?php

    }

}
