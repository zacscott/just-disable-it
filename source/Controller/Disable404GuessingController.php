<?php

namespace JustDisableIt\Controller;

class Disable404GuessingController {

    public function __construct() {
     
        add_action( 'init', [ $this, 'maybe_disable' ] );

    }

    public function maybe_disable() {

        if ( ! $this->is_disabled() ) {
            return;
        }

        add_filter( 'do_redirect_guess_404_permalink', '__return_false' );

    }

    protected function is_disabled() {

        $setting_model = new \JustDisableIt\Model\SettingModel();

        return $setting_model->get_value( 'disable_404_guessing' );

    }

}