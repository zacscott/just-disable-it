<?php

namespace JustDisableIt\Model;

/** 
 * Handles all interactions with the plugin settings in the database.
 * 
 * @package JustDisableIt\Library
 */
class SettingModel {

    /**
     * The singleton instance of the class.
     * 
     * @var SettingModel $instance
     */
    protected static $instance = null;

    /**
     * The plugin settings options, set by add_setting().  
     * @var array $settings
     */
    protected $settings = [];

    /**
     * The plugin settings sections, set by add_section().
     * 
     * @var array $sections
     */
    protected $sections = [];

    /**
     * Get the singleton instance of the class.
     * 
     * @return SettingModel
     */
    public static function get_instance() {

        if ( null === self::$instance ) {
            self::$instance = new SettingModel();
        }

        return self::$instance;

    }

    /**
     * Add a setting to the plugin settings options.
     * 
     * @param array $setting The setting to add.
     * 
     * @return void
     */
    public function add_setting( string $section, array $setting ) {

        if ( ! isset( $this->settings[$section] ) ) {
            $this->settings[$section] = [];
        }

        $this->settings[$section][] = $setting;

    }

    /**
     * Get all of the plugin settings options.
     * 
     * @return array
     */
    public function get_settings() {

        return $this->settings;

    }

    /**
     * Add a section to the plugin settings sections.
     * 
     * @param array $section The section to add.
     * 
     * @return void
     */
    public function add_section( string $section, array $defition ) {

        $this->sections[$section] = $defition;

    }

    /**
     * Get all of the plugin settings sections.
     * 
     * @return array
     */
    public function get_sections() {

        return $this->sections;

    }

    /**
     * Get the value of a setting.
     * 
     * @param string $setting The name of the setting.
     * @param string $default The default value to return if the setting/option
     *                        is not set.
     * 
     * @return mixed
     */
    public function get_value( $setting, $default = '' ) {

        $option_name = $this->get_option_name( $setting );

        return get_option( $option_name, $default );

    }

    /**
     * Update the value of a setting.
     * 
     * @param string $setting The name of the setting.
     * @param mixed  $value   The value to set.
     * 
     * @return bool
     */
    public function set_value( $setting, $value ) {

        $option_name = $this->get_option_name( $setting );

        return update_option( $option_name, $value );

    }

    /**
     * Get the name of the option in the database for the given setting.
     * 
     * @param string $option The name of the option.
     * 
     * @return string
     */
    public function get_option_name( $option ) {

        $option_name = 'just_disable_it_' . $option;

        return $option_name;

    }

    protected function __construct() { }

}
