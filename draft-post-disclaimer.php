<?php
/**
 * Plugin Name:       Draft Post Disclaimer
 * Plugin URI:        https://github.com/chrispian/draft-post-disclaimer
 * Description:       This plugin adds a disclaimer on posts in a "draft" category.
 * Version:           1.0.0
 * Requires at least: 4.7
 * Requires PHP:      5.4
 * Author:            Chrispian H. Burks
 * Author URI:        http://chrispian.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       draft-post-disclaimer
 * Domain Path:       /languages
 *
 * @link              http://chrispian.com
 * @since             1.0.0
 * @package           Draft_Post_Dislcaimer
 *
 *
 */

Namespace CHB\DraftPostDisclaimer;

/**
 * Load up our dependencies.
 */
require 'src/Disclaimer.php';
require 'src/admin/Options.php';

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'DRAFT_POST_DISCLAIMER_VERSION', '1.0.5' );

/**
 * Fire things up.
 *
 * @since    1.0.0
 */
function run_draft_post_disclaimer() {

	$options = new Options( 'plugin_action_links_' . plugin_basename( __FILE__ ) );
	$options->run();

	$plugin = new Disclaimer();
	$plugin->run();

}
run_draft_post_disclaimer();
