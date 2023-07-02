<?php

namespace JustDisableIt\Controller;

class DisableAdminMenusController {

    public function __construct() {
     
        add_action( 'admin_menu', [ $this, 'add_settings' ] );
        add_action( 'admin_menu', [ $this, 'maybe_disable' ] );

    }

    public function add_settings() {

        global $menu;

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        foreach ( $menu as $menu_data ) {

            $menu_page = $menu_data[2] ?? null;

            if ( $menu_page ) {

                $setting_model->add_setting(
                    [
                        'setting' => $this->get_menu_setting_name( $menu_page ),
                        'type'    => 'checkbox',
                        'label'   => sprintf( __( 'Disable %s', 'just-disable-it' ), $menu_page ),
                        'desc'    => sprintf( __( 'Disable the %s menu item.', 'just-disable-it' ), $menu_page ),
                    ]
                );

            }

        }

    }

    public function maybe_disable() {

        global $menu;

        foreach ( $menu as $menu_data ) {

            $menu_page = $menu_data[2] ?? null;

            if ( $menu_page && $this->is_disabled( $menu_page ) ) {
                remove_menu_page( $menu_page );
            }

        }

    }

    protected function is_disabled( string $menu ) {

        $setting_model = \JustDisableIt\Model\SettingModel::get_instance();

        return $setting_model->get_value( $this->get_menu_setting_name( $menu ) );

    }

    protected function get_menu_setting_name( string $menu ) {

        $menu_hash = md5( $menu );

        $menu_setting_name = sprintf( 'disable_admin_menu_%s', $menu_hash );

        return $menu_setting_name;

    }

}
