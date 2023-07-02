<?php

namespace JustDisableIt\Controller;

class DisableAuthorArchivesController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            [
                'setting' => 'disable_author_archives',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Author Archives', 'just-disable-it' ),
                'desc'    => __( 'Disable the author archives.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        add_action(
            'template_redirect',
            function() {

                if ( isset( $_GET['author'] ) || is_author() ) {

                    global $wp_query;

                    $wp_query->set_404();
                    status_header( 404 );
                    nocache_headers();

                }

            },
            1
        );

        // Remove author links.

        add_filter(
            'user_row_actions',
            function( $actions ) {
                
                if ( isset( $actions['view'] ) ) {
                    unset( $actions['view'] );
                }

                return $actions;

            },
            999999999,
            2
        );

        add_filter(
            'author_link',
            function() {
                return '#';
            },
            999999999
        );

        add_filter( 'the_author_posts_link', '__return_empty_string', 999999999 );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_author_archives' );

    }

}