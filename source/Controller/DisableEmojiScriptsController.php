<?php

namespace JustDisableIt\Controller;

class DisableEmojiScriptsController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    }

    protected function is_disabled() {

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_emoji_scripts' );

    }

}