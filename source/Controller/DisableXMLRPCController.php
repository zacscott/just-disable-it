<?php

namespace JustDisableIt\Controller;

class DisableXMLRPCController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

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

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_xmlrpc' );

    }

}