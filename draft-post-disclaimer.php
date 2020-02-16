<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Draft Post Disclaimer
 * Plugin URI:        http://chrispian.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chrispian H. Burks
 * Author URI:        http://chrispian.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       draft-post-dislcaimer
 * Domain Path:       /languages
 *
 * @link              http://chrispian.com
 * @since             1.0.0
 * @package           Draft_Post_Dislcaimer
 *
 *
 *  TODO:
 *	- Remove from Feed? (Make this an option)
 *  - Turn the remove from home page into an option
 *	- Fix depreciated static method call (what????)
 *  - Turn category select into a drop down
 *  - Add span/div to front page to display a "Draft" flag if front page display is enabled
 *
 */

Namespace CHB\DraftPostDisclaimer;

/**
 * Load up our dependencies. TODO: Switch to PSR-4
 */
require 'src/draft-post-disclaimer.php';
require 'src/admin/options.php';

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DRAFT_POST_DISCLAIMER_VERSION', '1.0.0' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_draft_post_disclaimer() {


	$options = new Options;
	$options->run();

	$plugin = new Draft_Post_Disclaimer();
	$plugin->run();

}
run_draft_post_disclaimer();
