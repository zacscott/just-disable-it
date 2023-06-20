<?php
/**
 * Plugin Name: Just Disable It
 * Version:     1.0
 * Author:      Zac Scott
 * Author URI:  https://zacscott.net
 * Description: Disable WordPress features for a faster, cleaner, more secure experience.
 * Text Domain: just-disable-it
 */

require dirname( __FILE__ ) . '/vendor/autoload.php';

define( 'JUST_DISABLE_IT_PLUGIN_ABSPATH', dirname( __FILE__ ) );
define( 'JUST_DISABLE_IT_PLUGIN_ABSURL', plugin_dir_url( __FILE__ )  );

// Boot each of the plugin logic controllers.
new \JustDisableIt\Controller\SettingsController();
new \JustDisableIt\Controller\DisableXMLRPCController();
new \JustDisableIt\Controller\DisableRESTController();
new \JustDisableIt\Controller\DisableSitemapsController();
new \JustDisableIt\Controller\DisableRSSFeedsController();
new \JustDisableIt\Controller\DisableCommentsController();
new \JustDisableIt\Controller\DisableSearchController();
new \JustDisableIt\Controller\DisableAuthorArchivesController();
new \JustDisableIt\Controller\Disable404GuessingController();
new \JustDisableIt\Controller\DisableEmojiScriptsController();
new \JustDisableIt\Controller\DisableSrcSetController();
new \JustDisableIt\Controller\DisableWPBrandingController();
