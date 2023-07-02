<?php

namespace JustDisableIt\Controller;

class DisableWPBrandingController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            'general',
            [
                'setting' => 'disable_wp_branding',
                'type'    => 'checkbox',
                'label'   => __( 'Disable WP Branding', 'just-disable-it' ),
                'desc'    => __( 'Disable WordPress branding on the login page, admin bar, and <head>.', 'just-disable-it' ),
            ]
        );

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

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_wp_branding' );

    }

}