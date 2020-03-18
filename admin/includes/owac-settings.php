<?php
class OWAC_Settings {
	private $settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'settings_page_init' ) );
	}

	public function settings_add_plugin_page() {
		add_submenu_page( 'availabilitycalendar', 'settings', 'Settings', 'manage_options', 'settings', array( $this, 'settings_create_admin_page' ));
	}

	public function settings_create_admin_page() {
		$this->settings_options = get_option( 'OWAC_settings_option' );	
?>
		<div class="wrap owac">
			<p></p>
			<?php settings_errors(); ?>
        
			<form method="post" action="options.php">
				<?php
					settings_fields( 'settings_option_group' );
					do_settings_sections( 'settings-admin' );
					submit_button();
				?>
			</form>
			<div class="shortcode">
				<h4><?php esc_html_e( 'shortcode :', 'availability-calendar' ); ?> </h4><p><?php esc_html_e( '[availabilitycalendar]', 'availability-calendar' ); ?></p>
			</div>
		</div>
	<?php }

	public function settings_page_init() {
		register_setting(
			'settings_option_group', // option_group
			'OWAC_settings_option', // option_name
			array( $this, 'settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'settings_setting_section', // id
			'Settings', // title
			array( $this, 'settings_section_info' ), // callback
			'settings-admin' // page
		);

		add_settings_field(
			'language_display', // id
			'Language', // title
			array( $this, 'language_display_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'header_display', // id
			'Header Display', // title
			array( $this, 'header_display_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);

		add_settings_field(
			'header_add_text', // id
			'Header Add text', // title
			array( $this, 'header_add_text_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);

		add_settings_field(
			'category_display', // id
			'Category Display', // title
			array( $this, 'category_display_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'display_calendar_month', // id
			'Number Of Months To Display', // title
			array( $this, 'display_calendar_month_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'desktop_column', // id
			'Desktop', // title
			array( $this, 'desktop_column_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'tablet_column', // id
			'Tablet', // title
			array( $this, 'tablet_column_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'mobile_column', // id
			'Mobile', // title
			array( $this, 'mobile_column_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'slides_to_scroll', // id
			'Slides To Scroll', // title
			array( $this, 'slides_to_scroll_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'background_color', // id
			'Background Color', // title
			array( $this, 'background_color_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'calendar_background_color', // id
			'Calendar Background Color', // title
			array( $this, 'calendar_background_color_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'month_title_font_color', // id
			'Month Title Font Color', // title
			array( $this, 'month_title_font_color_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
		add_settings_field(
			'month_background_color', // id
			'Month Background Color', // title
			array( $this, 'month_background_color_callback' ), // callback
			'settings-admin', // page
			'settings_setting_section' // section
		);
		
	}

	public function settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['language_display'] ) ) {
			$sanitary_values['language_display'] = sanitize_text_field( $input['language_display']);
		}
		
		if ( isset( $input['header_display'] ) ) {
			$sanitary_values['header_display'] = sanitize_text_field( $input['header_display']);
		}

		if ( isset( $input['header_add_text'] ) ) {
			$sanitary_values['header_add_text'] = esc_textarea( $input['header_add_text'] );
		}

		if ( isset( $input['category_display'] ) ) {
			$sanitary_values['category_display'] = sanitize_text_field( $input['category_display']);
		}
		
		if ( isset( $input['display_calendar_month'] ) ) {
			$sanitary_values['display_calendar_month'] = sanitize_text_field( $input['display_calendar_month']);
		}
		
		if ( isset( $input['desktop_column'] ) ) {
			$sanitary_values['desktop_column'] = sanitize_text_field( $input['desktop_column']);
		}
		
		if ( isset( $input['tablet_column'] ) ) {
			$sanitary_values['tablet_column'] = sanitize_text_field( $input['tablet_column']);
		}
		
		if ( isset( $input['mobile_column'] ) ) {
			$sanitary_values['mobile_column'] = sanitize_text_field( $input['mobile_column']);
		}
		
		if ( isset( $input['slides_to_scroll'] ) ) {
			$sanitary_values['slides_to_scroll'] = sanitize_text_field( $input['slides_to_scroll']);
		}
		
		if ( isset( $input['background_color'] ) ) {
			$sanitary_values['background_color'] = sanitize_text_field($input['background_color']);
		}
		
		if ( isset( $input['calendar_background_color'] ) ) {
			$sanitary_values['calendar_background_color'] = sanitize_text_field($input['calendar_background_color']);
		}
		
		if ( isset( $input['month_title_font_color'] ) ) {
			$sanitary_values['month_title_font_color'] = sanitize_text_field($input['month_title_font_color']);
		}
		
		if ( isset( $input['month_background_color'] ) ) {
			$sanitary_values['month_background_color'] = sanitize_text_field($input['month_background_color']);
		}
		
		return $sanitary_values;
	}

	public function settings_section_info() {
		
	}
	
	public function language_display_callback() {
		$language = owac_language();
	?> 
		<select name="OWAC_settings_option[language_display]" id="language_display">
			<?php foreach ( $language as $key => $value ) { ?>
				<?php $selected = (isset( $this->settings_options['language_display'] ) && $this->settings_options['language_display'] === $key) ? 'selected' : '' ; ?>
				<option value="<?php esc_html_e($key, 'availability-calendar' ); ?>" <?php esc_html_e( $selected, 'availability-calendar' ); ?>><?php esc_html_e( $value['name'] , 'availability-calendar' ); ?> </option>
			<?php } ?>
		</select> <?php
	}

	public function header_display_callback() {
		?> <fieldset><?php $checked = ( isset( $this->settings_options['header_display'] ) && $this->settings_options['header_display'] === 'yes' ) ? 'checked' : '' ; ?>
		<label for="header_display"><input type="radio" name="OWAC_settings_option[header_display]" id="header_display" value="yes" <?php esc_html_e( $checked, 'availability-calendar' ); ?>> <?php esc_html_e( 'Yes', 'availability-calendar' ); ?></label><br>
		<?php $checked = ( isset( $this->settings_options['header_display'] ) && $this->settings_options['header_display'] === 'no' ) ? 'checked' : '' ; ?>
		<label for="header_display"><input type="radio" name="OWAC_settings_option[header_display]" id="header_display" value="no" <?php esc_html_e( $checked, 'availability-calendar' ); ?>> <?php esc_html_e( 'No', 'availability-calendar' ); ?></label></fieldset> <?php
	}

	public function header_add_text_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="OWAC_settings_option[header_add_text]" id="header_add_text_1" placeholder="Add text here...">%s</textarea>',
			isset( $this->settings_options['header_add_text'] ) ? esc_attr( $this->settings_options['header_add_text']) : ''
		);
	}

	public function category_display_callback() {
		?> <fieldset><?php $checked = ( isset( $this->settings_options['category_display'] ) && $this->settings_options['category_display'] === 'yes' ) ? 'checked' : '' ; ?>
		<label for="category_display"><input type="radio" name="OWAC_settings_option[category_display]" id="category_display" value="yes" <?php esc_html_e( $checked, 'availability-calendar' ); ?>> <?php esc_html_e( 'Yes', 'availability-calendar' ); ?></label><br>
		<?php $checked = ( isset( $this->settings_options['category_display'] ) && $this->settings_options['category_display'] === 'no' ) ? 'checked' : '' ; ?>
		<label for="category_display"><input type="radio" name="OWAC_settings_option[category_display]" id="category_display" value="no" <?php esc_html_e( $checked, 'availability-calendar' ); ?>> <?php esc_html_e( 'No', 'availability-calendar' ); ?></label></fieldset> <?php
	}
	
	public function display_calendar_month_callback() {
		?> <select name="OWAC_settings_option[display_calendar_month]" id="display_calendar_month">
			<?php for($i=1; $i <= 12; $i++){ ?>
				<?php $selected = (isset( $this->settings_options['display_calendar_month'] ) && $this->settings_options['display_calendar_month'] === ''.$i.'m') ? 'selected' : '' ; ?>
				<option value="<?php esc_html_e( $i.'m', 'availability-calendar' ); ?>" <?php esc_html_e( $selected, 'availability-calendar' ); ?>><?php esc_html_e( $i.' month(s)', 'availability-calendar' ); ?> </option>
			<?php } ?>
			<?php for($j=1; $j <= 3; $j++){ ?>
				<?php $selected = (isset( $this->settings_options['display_calendar_month'] ) && $this->settings_options['display_calendar_month'] === ''.$j.'y') ? 'selected' : '' ; ?>
				<option value="<?php esc_html_e( $j.'y', 'availability-calendar' ); ?>" <?php esc_html_e( $selected, 'availability-calendar' ); ?>><?php esc_html_e( $j.' year(s)', 'availability-calendar' ); ?> </option>
			<?php } ?>
		</select> <?php
	}
	
	public function desktop_column_callback() {
		?> <select name="OWAC_settings_option[desktop_column]" id="desktop_column">
			<?php $selected = (isset( $this->settings_options['desktop_column'] ) && $this->settings_options['desktop_column'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '1', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['desktop_column'] ) && $this->settings_options['desktop_column'] === '2') ? 'selected' : '' ; ?>
			<option value="2" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '2', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['desktop_column'] ) && $this->settings_options['desktop_column'] === '3') ? 'selected' : '' ; ?>
			<option value="3" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '3', 'availability-calendar' ); ?></option>
		</select> <?php
	}
	
	public function tablet_column_callback() {
		?> <select name="OWAC_settings_option[tablet_column]" id="tablet_column">
			<?php $selected = (isset( $this->settings_options['tablet_column'] ) && $this->settings_options['tablet_column'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '1', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['tablet_column'] ) && $this->settings_options['tablet_column'] === '2') ? 'selected' : '' ; ?>
			<option value="2" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '2', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['tablet_column'] ) && $this->settings_options['tablet_column'] === '3') ? 'selected' : '' ; ?>
			<option value="3" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '3', 'availability-calendar' ); ?></option>
		</select> <?php
	}
	
	public function mobile_column_callback() {
		?> <select name="OWAC_settings_option[mobile_column]" id="mobile_column">
			<?php $selected = (isset( $this->settings_options['mobile_column'] ) && $this->settings_options['mobile_column'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '1', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['mobile_column'] ) && $this->settings_options['mobile_column'] === '2') ? 'selected' : '' ; ?>
			<option value="2" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '2', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['mobile_column'] ) && $this->settings_options['mobile_column'] === '3') ? 'selected' : '' ; ?>
			<option value="3" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '3', 'availability-calendar' ); ?></option>
		</select> <?php
	}
	
	public function slides_to_scroll_callback() {
		?> <select name="OWAC_settings_option[slides_to_scroll]" id="slides_to_scroll">
			<?php $selected = (isset( $this->settings_options['slides_to_scroll'] ) && $this->settings_options['slides_to_scroll'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '1', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['slides_to_scroll'] ) && $this->settings_options['slides_to_scroll'] === '2') ? 'selected' : '' ; ?>
			<option value="2" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '2', 'availability-calendar' ); ?></option>
			<?php $selected = (isset( $this->settings_options['slides_to_scroll'] ) && $this->settings_options['slides_to_scroll'] === '3') ? 'selected' : '' ; ?>
			<option value="3" <?php  esc_html_e( $selected, 'availability-calendar' ); ?>><?php  esc_html_e( '3', 'availability-calendar' ); ?></option>
		</select> <?php
	}
	
	public function background_color_callback() {
		printf(
			'<input class="regular-text jscolor" type="text" name="OWAC_settings_option[background_color]" id="background_color" value="%s">',
			isset( $this->settings_options['background_color'] ) ? esc_attr( $this->settings_options['background_color']) : ''
		);
	}
	
	public function calendar_background_color_callback() {
		printf(
			'<input class="regular-text jscolor" type="text" name="OWAC_settings_option[calendar_background_color]" id="calendar_background_color" value="%s">',
			isset( $this->settings_options['calendar_background_color'] ) ? esc_attr( $this->settings_options['calendar_background_color']) : ''
		);
	}
	
	public function month_title_font_color_callback() {
		printf(
			'<input class="regular-text jscolor" type="text" name="OWAC_settings_option[month_title_font_color]" id="month_title_font_color" value="%s">',
			isset( $this->settings_options['month_title_font_color'] ) ? esc_attr( $this->settings_options['month_title_font_color']) : ''
		);
	}
	
	public function month_background_color_callback() {
		printf(
			'<input class="regular-text jscolor" type="text" name="OWAC_settings_option[month_background_color]" id="month_background_color" value="%s">',
			isset( $this->settings_options['month_background_color'] ) ? esc_attr( $this->settings_options['month_background_color']) : ''
		);
	}
	
	
}
if ( is_admin() )
	$settings = new OWAC_Settings();