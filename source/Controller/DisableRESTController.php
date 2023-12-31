<?php

namespace JustDisableIt\Controller;

class DisableRESTController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            'general',
            [
                'setting' => 'disable_rest_api',
                'type'    => 'checkbox',
                'label'   => __( 'Disable REST API', 'just-disable-it' ),
                'desc'    => __( 'Disable the REST API interface.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Leave REST API enabled for logged in users.
        if ( is_user_logged_in() ) {
            return;
        }

        // Remove REST API info in <head> and headers.
        remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'template_redirect', 'rest_output_link_header', 11 );

        // Disable REST API endpoints.
        add_filter( 'json_enabled', '__return_false' );
        add_filter( 'json_jsonp_enabled', '__return_false' );
        add_filter( 'rest_enabled', '__return_false' );
        add_filter( 'rest_jsonp_enabled', '__return_false' );

        // Disable REST via authentication error.
        add_filter(
            'rest_authentication_errors', function() {

                return new \WP_Error(
                    'disabled', 
                    '', 
                    [
                        'status' => rest_authorization_required_code(),
                    ]
                );

            }
        );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_rest_api' );

    }

}