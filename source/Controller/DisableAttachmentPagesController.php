<?php

namespace JustDisableIt\Controller;

class DisableAttachmentPagesController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            'general',
            [
                'setting' => 'disable_attachment_pages',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Attachment Pages', 'just-disable-it' ),
                'desc'    => __( 'Disable attachment pages.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        add_action( 'template_redirect', function() {

            global $post;
    
            if ( ! is_attachment() ) {
                return;
            }
    
            $redirect_to = get_home_url();
            if ( $post->post_parent ) {
                $redirect_to = get_permalink( $post->post_parent );
            }

            wp_redirect( $redirect_to, 301 );
            exit;
    
        } );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_attachment_pages' );

    }

}