<?php
/**
 * Short Description Goes Here
 *
 * @author Chrispian H. Burks <chrispian@gmail.com>
 * @since  2020-02-15
 */

Namespace CHB\DraftPostDisclaimer;

class Options {

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 */
	public function run() {

		// Do the things.
		add_action( 'admin_init', ['CHB\DraftPostDisclaimer\Options', 'settings_init'] );
		add_action( 'admin_menu', ['CHB\DraftPostDisclaimer\Options', 'options_page'] );

	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 * Setup our custom options / settings
	 */
	public function settings_init() {

		// Register our settings.
		register_setting('dpd', 'dpd_category');
		register_setting('dpd', 'dpd_disclaimer');

		// Add out section.
		add_settings_section('header', __('Settings', 'dpd'), ['CHB\DraftPostDisclaimer\Options', 'header'], 'dpd');

		// Add the settings filed.
		add_settings_field('category_html', __('Category', 'dpd'), ['CHB\DraftPostDisclaimer\Options', 'category_html'], 'dpd', 'header', [ 'label_for' => 'category_html', 'class' => 'dpd_row', 'dpd_custom_data' => 'custom', ]);
		add_settings_field('disclaimer_html', __('Disclaimer', 'dpd'), ['CHB\DraftPostDisclaimer\Options', 'disclaimer_html'], 'dpd', 'header', [ 'label_for' => 'category_html', 'class' => 'dpd_row', 'dpd_custom_data' => 'custom', ]);

	}

	public function header( $args ) {

		?>
		<p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Set your draft category and create a disclaimer.', 'dpd'); ?></p>
		<?php
	}


	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 * @param $args array
	 */
	public function category_html( $args ) {

		// get the value of the setting we've registered with register_setting()
		$category   = get_option('dpd_category');
		// output the field
		?>
		<input name="dpd_category" type="text" value="<?php esc_html_e($category, 'dpd'); ?>" /><br /><br />

		<?php
	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 *
	 * @param $args array
	 */
	public function disclaimer_html( $args ) {

		// get the value of the setting we've registered with register_setting()
		$disclaimer = get_option('dpd_disclaimer');
		// output the field
		?>
		<textarea name="dpd_disclaimer" cols="80" rows="10"><?php esc_html_e($disclaimer, 'dpd'); ?></textarea><br />

		<?php
	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 */
	public function options_page() {
		// add top level menu page
		add_menu_page( 'Draft Post Disclaimer', 'Draft Post Disclaimer Options', 'manage_options', 'dpd', ['CHB\DraftPostDisclaimer\Options', 'options_page_html'] );
	}

	/**
	 * @author Chrispian H. Burks <chrispian@gmail.com>
	 * @since  2020-02-15
	 */
	public function options_page_html() {

		// check user capabilities
		if ( ! current_user_can('manage_options') ) {
			return;
		}

		if ( isset($_GET['settings-updated']) ) {
			add_settings_error('dpd_messages', 'dpd_message', __('Settings Saved', 'dpd'), 'updated');
		}

		settings_errors('dpd_messages');

		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields('dpd');
				do_settings_sections('dpd');
				submit_button('Save Settings');
				?>
			</form>
		</div>
		<?php
	}
}
