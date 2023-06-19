<?php
/**
 * Plugin Name: Just Disable It
 * Version:     1.0
 * Author:      Zac Scott
 * Author URI:  https://zacscott.net
 * Description: Disable WordPress features for a faster, more secure experience.
 * Text Domain: just-disable-it
 */

require dirname( __FILE__ ) . '/vendor/autoload.php';

define( 'JUST_DISABLE_IT_PLUGIN_ABSPATH', dirname( __FILE__ ) );
define( 'JUST_DISABLE_IT_PLUGIN_ABSURL', plugin_dir_url( __FILE__ )  );

// Boot each of the plugin logic controllers.
new \JustDisableIt\Controller\SettingsController();
