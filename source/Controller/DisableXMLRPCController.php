<?php

namespace JustDisableIt\Controller;

class DisableXMLRPCController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            'general',
            [
                'setting' => 'disable_xmlrpc',
                'type'    => 'checkbox',
                'label'   => __( 'Disable XMLRPC', 'just-disable-it' ),
                'desc'    => __( 'Disable the XMLRPC API interface.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Disable xmlrpc.php

        add_filter( 'xmlrpc_enabled', '__return_false' );

        add_filter(
            'xmlrpc_methods', 
            function () {
                return [];
            },
            999999999
        );

        // Remove link from <head>
        remove_action( 'wp_head', 'rsd_link' );

        // Remove pingback header from HTTP response.
        add_filter(
            'wp_headers', function ( $headers ) {
                unset( $headers['X-Pingback'] );
                return $headers;
            },
            999999999
        );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_xmlrpc' );

    }

}