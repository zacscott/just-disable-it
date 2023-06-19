<?php

namespace JustDisableIt\Controller;

/**
 * Responsible for handling the settings page for the plugin.
 * 
 * @package JustDisableIt\Controller
 */
class SettingsController {

    public function __construct() {
        
        add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );

    }

    public function register_settings_page() {

        add_menu_page(
            'WPOrg',
            'WPOrg Options',
            'manage_options',
            'wporg',
            [ $this, 'render_settings_page' ]
        );

    }
    
    function render_settings_page() {

        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // add error/update messages

        if ( isset( $_POST['update'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'wporg_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields( 'wporg' );
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections( 'wporg' );
                // output save settings button
                submit_button( 'Save' );
                ?>
            </form>
        </div>
        <?php

    }

    public function register_settings() {

        // Register a new setting for "wporg" page.
        register_setting( 'wporg', 'wporg_options' );

        // Register a new section in the "wporg" page.
        add_settings_section(
            'wporg_section_developers',
            __( 'The Matrix has you.', 'wporg' ),
            [ $this, 'render_settings_section' ],
            'wporg'
        );

        // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
        add_settings_field(
            'wporg_field_pill', 
            __( 'Pill', 'wporg' ),
            [ $this, 'render_settings_field' ],
            'wporg',
            'wporg_section_developers'
        );
        
    }

    function render_settings_section( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
        <?php
    }

    function render_settings_field( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'wporg_options' );
        ?>
        <select
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
                name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'red pill', 'wporg' ); ?>
            </option>
             <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'blue pill', 'wporg' ); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
        </p>
        <p class="description">
            <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
        </p>
        <?php

    }

}
