<?php

namespace JustDisableIt\Controller;

class DisableSearchController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Leave search enabled for wp-admin.
        if ( is_admin() ) {
            return;
        }

        // 404 any frontend search requests.
        add_action(
            'parse_query',
            function( $query ) {

                if ( $query->is_search && $query->is_main_query() ) {

                    unset( $_GET['s'] );
                    unset( $_POST['s'] );
                    unset( $_REQUEST['s'] );
                    unset( $query->query['s'] );
                    $query->set( 's', '' );

                    $query->is_search = false;

                    $query->set_404();
                    status_header( 404 );
                    nocache_headers();

                }

            },
            999999999
        );

        // Disable the theme search form.
        add_filter( 'get_search_form', '__return_empty_string', 999999999 );

    }

    protected function is_disabled() {

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_search' );

    }

}