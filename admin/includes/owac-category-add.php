<?php
class AddCategory {
	private $add_category_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_category_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'add_category_page_init' ) );
	}

	public function add_category_add_plugin_page() {
		add_submenu_page( 'Hidden', 'owaccategory', 'Category Add', 'manage_options', 'owaccategory', array( $this, 'add_category_create_admin_page' ));
	}

	public function add_category_create_admin_page() {
		$submitbtn = "owac_category_add";
		if(isset($_GET['edit']) && !empty($_GET['edit'])){ 
			$id = intval($_GET['edit']);
			global $wpdb;
			$owac_category_item = $wpdb->get_results(
								$wpdb->prepare(
									"SELECT * from 
										`{$wpdb->prefix}OWAC_category` 
									WHERE cat_id=%d",
									$id
								)
							);
			$this->add_category_options = $owac_category_item[0];
			$submitbtn = "owac_category_update";
		}		
?>

		<div class="wrap owac">
			<p></p>
			<?php settings_errors(); ?>

			<form action="" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
				<?php
					settings_fields( 'add_category' );
					do_settings_sections( 'add-category-admin' );
					//submit_button();
				?>
				<p class="submit">
					<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ ?>
						<input type="hidden" name="cat_id" id="cat_id" value="<?php esc_html_e( $this->add_category_options->cat_id, 'availability-calendar' ); ?>">
					<?php } ?>
					<input type="submit" name="<?php esc_html_e( $submitbtn, 'availability-calendar' ); ?>" class="button button-primary" value="Submit">
					<a href="<?php echo esc_url('admin.php?page=owaccategorylist'); ?>"><input action="action" type="button" name="cancel" class="button button-primary" value="cancel"></a>
				</p>
			</form>
		</div>
	<?php }

	public function add_category_page_init() {
		register_setting(
			'add_category', // option_group
			'add_category', // option_name
			array( $this, 'add_category_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'add_category_setting_section', // id
			'Add Category', // title
			array( $this, 'add_category_section_info' ), // callback
			'add-category-admin' // page
		);

		add_settings_field(
			'cat_name', // id
			'Category Name', // title
			array( $this, 'cat_name_callback' ), // callback
			'add-category-admin', // page
			'add_category_setting_section' // section
		);

		add_settings_field(
			'cat_color', // id
			'Category Color', // title
			array( $this, 'cat_color_callback' ), // callback
			'add-category-admin', // page
			'add_category_setting_section' // section
		);

		add_settings_field(
			'cat_ord_num', // id
			'Category Ordering Numbers', // title
			array( $this, 'cat_ord_num_callback' ), // callback
			'add-category-admin', // page
			'add_category_setting_section' // section
		);
	}

	public function add_category_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['cat_name_eng'] ) ) {
			$sanitary_values['cat_name_eng'] = sanitize_text_field( $input['cat_name_eng'] );
		}
		
		if ( isset( $input['cat_name_fre'] ) ) {
			$sanitary_values['cat_name_eng'] = sanitize_text_field( $input['cat_name_eng'] );
		}

		if ( isset( $input['cat_color'] ) ) {
			$sanitary_values['cat_color'] = sanitize_hex_color( $input['cat_color'] );
		}

		if ( isset( $input['cat_ord_num'] ) ) {
			$sanitary_values['cat_ord_num'] = intval( $input['cat_ord_num'] );
		}

		return $sanitary_values;
	}

	public function add_category_section_info() {
		
	}

	//modified
	public function cat_name_callback() {
		printf(
			'<label for="add_category[cat_name_eng]">English</label><input class="regular-text" type="text" name="add_category[cat_name_eng]" id="cat_name_eng" value="%s" required>',
			isset( $this->add_category_options->cat_name_eng) ? esc_attr( $this->add_category_options->cat_name_eng) : ''
		);
		printf(
			'<br /><br /><label for="add_category[cat_name_fre]">French<input class="regular-text" type="text" name="add_category[cat_name_fre]" id="cat_name_fre" value="%s" required>',
			isset( $this->add_category_options->cat_name_fre) ? esc_attr( $this->add_category_options->cat_name_fre) : ''
		);
	}

	public function cat_color_callback() {
		printf(
			'<input class="regular-text jscolor" type="text" name="add_category[cat_color]" id="cat_color" value="%s" required>',
			isset( $this->add_category_options->cat_color ) ? esc_attr( $this->add_category_options->cat_color) : ''
		);
	}

	public function cat_ord_num_callback() {
		printf(
			'<input class="regular-text" type="text" name="add_category[cat_ord_num]" id="cat_ord_num" value="%s">',
			isset( $this->add_category_options->cat_ord_num ) ? esc_attr( $this->add_category_options->cat_ord_num) : ''
		);
	}

}
if ( is_admin() )
	$add_category = new AddCategory();