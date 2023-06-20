<?php

namespace JustDisableIt\Controller;

class DisableWPBrandingController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Rmeove login page logo.
        add_action(
            'login_head', 
            function() {
                ?>
                <style type ="text/css">.login h1 a { visibility: hidden !important; }</style>
                <?php
            }
        );

        // Remove admin bar logo.
        add_action(
            'admin_bar_menu',
            function( $wp_admin_bar ) {
                $wp_admin_bar->remove_node( 'wp-logo' );
            },
            999999999
        );

        // Remove generator by from <head>
        remove_action( 'wp_head', 'wp_generator' );

    }

    protected function is_disabled() {

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_wp_branding' );

    }

}