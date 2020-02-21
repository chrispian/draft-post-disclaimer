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
		add_filter( 'pre_get_posts', [ $this, 'exclude_draft_category' ] );
		add_filter( 'the_content', [ $this, 'draft_notice' ] );
		add_filter( 'the_excerpt', [ $this, 'draft_notice_excerpt' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_styles' ] );
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
		$exclude_from_queries = get_option('dpd_exclude_from_queries');

		if ( ! $exclude_from_queries['exclude_from_queries_html'] ) {
			return $query;
		}

		if ( $query->is_home || $query->is_archive ) {
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
	public function draft_notice( $content ) {

		if ( ! Disclaimer::maybe_display_notice() ) {
			return $content;
		}

		$disclaimer = wp_kses_post(get_option('dpd_disclaimer'));

		$html = "
		<div class=\"alert alert-warning\" role=\"alert\"> 
			$disclaimer
		</div>
		";

		return "$content " . $html;

	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-16
	 *
	 * @param $excerpt
	 *
	 * @return string
	 */
	public function draft_notice_excerpt( ) {

		$excerpt = get_the_excerpt();

		if ( ! Disclaimer::maybe_display_notice() ) {
			return $excerpt;
		}

		$disclaimer = wp_kses_post(get_option('dpd_disclaimer'));

		$html = "
		<div class=\"alert alert-warning\" role=\"alert\"> 
			$disclaimer
		</div>
		";

		return $excerpt . $html;

	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 */
	public function add_styles() {
		$plugin_url = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'draft-post-disclaimer', $plugin_url . '../assets/style.css' );
	}


	/**
	 * @author Chrispian H. Burks <chrispian.burks@webvdevstudios.com>
	 * @since  2020-02-16
	 * @return mixed
	 */
	public function maybe_display_notice() {

		$status                = true;
		$disclaimer            = get_option( 'dpd_disclaimer' );
		$disclaimer_on_queries = get_option( 'dpd_disclaimer_on_queries' );
		$disclaimer_on_single  = get_option( 'dpd_disclaimer_on_single' );

		global $post;

		if ( ! in_category('draft', $post) ) {
			$status = false;
		}

		if ( ! $disclaimer ) {
			$status = false;
		}

		if ( ! $disclaimer_on_queries['disclaimer_on_queries_html'] && ! is_single() ) {
			$status = false;
		}

		if ( ! $disclaimer_on_single['disclaimer_on_single_html'] ) {
			$status = false;
		}


		return $status;

	}

}
