<?php

namespace JustDisableIt\Controller;

class DisableSrcSetController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            'general',
            [
                'setting' => 'disable_srcset',
                'type'    => 'checkbox',
                'label'   => __( 'Disable srcset', 'just-disable-it' ),
                'desc'    => __( 'Disable the srcset attribute on images.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        add_filter( 'wp_calculate_image_srcset', '__return_false' );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_srcset' );

    }

}