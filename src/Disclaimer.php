<?php

/**
 * The file that defines the core plugin class
 *
 * @link       http://chrispian.com
 * @since      1.0.0
 *
 * @package    Draft_Post_Dislcaimer
 * @subpackage Draft_Post_Dislcaimer/includes
 */

Namespace CHB\DraftPostDisclaimer;

class Disclaimer {

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 */
	public function run() {
		// Do the things.
		add_filter( 'pre_get_posts', ['CHB\DraftPostDisclaimer\Draft_Post_Disclaimer', 'exclude_draft_category'] );
		add_filter('the_content', [ 'CHB\DraftPostDisclaimer\Draft_Post_Disclaimer', 'draft_notice' ]);
		add_action('wp_enqueue_scripts', [ 'CHB\DraftPostDisclaimer\Draft_Post_Disclaimer', 'add_styles' ]);
	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function exclude_draft_category( $query ) {
		$category = strtolower(esc_html(get_option('dpd_category')));
		if ( $query->is_home ) {
			$query->set( 'tax_query', [
				[
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $category,
					'operator' => 'NOT IN',
				],
			] );
		}
	return $query;
	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 * @param $content
	 *
	 * @return string
	 */
	function draft_notice( $content ) {
		$disclaimer = wp_kses_post(get_option('dpd_disclaimer'));
		global $post;
		if ( ! in_category( 'draft', $post ) || !$disclaimer ) {
			// Make no changes.
			return $content;
		}

		$html = "
		<div class=\"alert alert-warning\" role=\"alert\"> 
			$disclaimer
		</div>
		";

		return $content . $html;

	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 */
	public function add_styles() {
		$plugin_url = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'draft-post-disclaimer', $plugin_url . '../assets/style.css' );
	}


}
