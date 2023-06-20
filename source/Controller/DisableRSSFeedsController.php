<?php

namespace JustDisableIt\Controller;

class DisableRSSFeedsController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        // Disable rendering of the feeds.
        remove_all_actions( 'do_feed' );
        remove_all_actions( 'do_feed_rdf' );
        remove_all_actions( 'do_feed_rss' );
        remove_all_actions( 'do_feed_rss2' );
        remove_all_actions( 'do_feed_atom' );
        remove_all_actions( 'do_feed_rss2_comments' );
        remove_all_actions( 'do_feed_atom_comments' );

        // Remove links from <head>
        add_filter( 'feed_links_show_posts_feed', '__return_false', 999999999 );
        add_filter( 'feed_links_show_comments_feed', '__return_false', 999999999 );

    }

    protected function is_disabled() {

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_rss' );

    }

}