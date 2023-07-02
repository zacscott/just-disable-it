<?php

namespace JustDisableIt\Controller;

class Disable404GuessingController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            [
                'setting' => 'disable_404_guessing',
                'type'    => 'checkbox',
                'label'   => __( 'Disable 404 Guessing', 'just-disable-it' ),
                'desc'    => __( 'Disable the 404 guessing feature of WordPress.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        add_filter( 'do_redirect_guess_404_permalink', '__return_false' );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_404_guessing' );

    }

}