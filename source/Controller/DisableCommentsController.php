<?php

namespace JustDisableIt\Controller;

class DisableCommentsController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );
        add_action( 'admin_init', [ $this, 'add_settings' ], -1 );

    }

    public function add_settings() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        $setting_model->add_setting(
            [
                'setting' => 'disable_comments',
                'type'    => 'checkbox',
                'label'   => __( 'Disable Comments', 'just-disable-it' ),
                'desc'    => __( 'Disable comments on the frontend and in the admin.', 'just-disable-it' ),
            ]
        );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Close comments on the front-end.
        add_filter( 'comments_open', '__return_false', 999999999, 2 );
        add_filter( 'pings_open', '__return_false', 999999999, 2 );

        // Remove comments feed link entirely.
        remove_all_actions( 'do_feed_rss2_comments' );
        remove_all_actions( 'do_feed_atom_comments' );
        add_filter( 'feed_links_show_comments_feed', '__return_false', 999999999 );

        // Hide existing comments.
        add_filter( 'comments_array', '__return_empty_array', 999999999, 2 );

        // Remove comments page in menu.
        add_action(
            'admin_menu',
            function() {

                remove_menu_page( 'edit-comments.php' );

            },
            999999999
        );
        
        // Remove comments links from admin bar.
        add_action(
            'add_admin_bar_menus',
            function() {
                
                if ( is_admin_bar_showing() ) {

                    remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
                }

            },
            999999999
        );

        add_action(
            'admin_init',
            function () {
            
                global $pagenow;

                // Redirect any user trying to access comments page.
                if ( $pagenow === 'edit-comments.php' ) {
                    wp_safe_redirect(admin_url());
                    exit;
                }
            
                // Remove comments metabox from dashboard.
                remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
            
                // Disable support for comments and trackbacks in post types.
                foreach ( get_post_types() as $post_type ) {
                    if ( post_type_supports($post_type, 'comments') ) {
                        remove_post_type_support( $post_type, 'comments' );
                        remove_post_type_support( $post_type, 'trackbacks' );
                    }
                }

            },
            999999999
        );

        // Remove the comments JS.
        wp_deregister_script( 'comment-reply' );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

        // Remove the comments template.
        add_filter( 'comments_template', function() {
            return '';
        }, 20 );

    }

    protected function is_disabled() {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( 'disable_comments' );

    }

}