<?php
class AddAvailabilityCalendar {
	private $add_availability_calendar;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_availability_calendar_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'add_availability_calendar_page_init' ) );
	}

	public function add_availability_calendar_plugin_page() {
		add_submenu_page( 'Hidden', 'owacapt1', 'Availability Add', 'manage_options', 'availabilityadd', array( $this, 'add_availability_calendar_create_admin_page' ));
		
        add_submenu_page( 'Hidden', 'Apartment 1 Addition', 'Availability Add', 'manage_options', 'owacapt1add', array( $this, 'add_availability_calendar_create_admin_page' ));
		add_submenu_page( 'Hidden', 'Apartment 2 Addition', 'Availability Add', 'manage_options', 'owacapt2add', array( $this, 'add_availability_calendar_create_admin_page' ));
		add_submenu_page( 'Hidden', 'Apartment 3 Addition', 'Availability Add', 'manage_options', 'owacapt3add', array( $this, 'add_availability_calendar_create_admin_page' ));
		add_submenu_page( 'Hidden', 'Apartment 4 Addition', 'Availability Add', 'manage_options', 'owacapt4add', array( $this, 'add_availability_calendar_create_admin_page' ));
	}

	public function add_availability_calendar_create_admin_page() {
		$submitbtn = "owac_add";
		if(isset($_GET['edit']) && !empty($_GET['edit'])){ 
			$id = intval($_GET['edit']);
			global $wpdb;
			$table_name = $wpdb->prefix . 'OWAC_event';
			$owac_item = $wpdb->get_results(
								$wpdb->prepare(
									"SELECT * from 
										`{$wpdb->prefix}OWAC_event` 
									WHERE ev_id=%d",
									$id
								)
							);
			$this->add_availability_calendar = $owac_item[0];
			
			$submitbtn = "owac_update";
		}
		
		$apt_id = $_GET['page'][7];
		$page = "owacapt" . $apt_id;
?>

		<div class="wrap owac">
			<p></p>
			<?php settings_errors(); ?>
			<form action="" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">				
				<?php
				    echo "<h3>Add to Apartment ". $apt_id . "</h3>";
					settings_fields( 'add_availability_calendar' );
					do_settings_sections( 'add-availability-calendar-admin' );
					//submit_button();
				?>
				<p class="submit">
					<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ ?>
						<input type="hidden" name="ev_id" id="ev_id" value="<?php esc_html_e( $this->add_availability_calendar->ev_id, 'availability-calendar' ); ?>">
					<?php } ?>
					<input type="submit" name="<?php esc_html_e( $submitbtn, 'availability-calendar' ); ?>" class="button button-primary" value="Submit">
					<a href="<?php echo esc_url('admin.php?page=' . $page); ?>"><input action="action" type="button" name="cancel" class="button button-primary" value="Cancel"></a>
				</p>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				addEventListener('DOMContentLoaded', function () {
					var now = new Date((new Date()).valueOf()-1000*60*60*24);
					pickmeup('input.from_date', {
						position : 'right',
						mode : 'single',
						separator : ',',
						hide_on_select : true,
						default_date : false,
						render : function (date) {
							return {};
						}
					});
					pickmeup('input.to_date', {
						position : 'right',
						mode : 'single',
						separator : ',',
						hide_on_select : true,
						default_date : false,
						render : function (date) {
							return {};
						}
					});
				});
			});
		</script>
	<?php }

	public function add_availability_calendar_page_init() {
		register_setting(
			'add_availability_calendar', // option_group
			'add_availability_calendar', // option_name
			array( $this, 'add_availability_calendar_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'add_availability_calendar_setting_section', // id
			null, // title
			array( $this, 'add_availability_calendar_section_info' ), // callback
			'add-availability-calendar-admin' // page
		);

		add_settings_field(
			'from_date', // id
			'From Date', // title
			array( $this, 'from_date_callback' ), // callback
			'add-availability-calendar-admin', // page
			'add_availability_calendar_setting_section' // section
		);

		add_settings_field(
			'to_date', // id
			'To Date', // title
			array( $this, 'to_date_callback' ), // callback
			'add-availability-calendar-admin', // page
			'add_availability_calendar_setting_section' // section
		);

		add_settings_field(
			'cat_id', // id
			'Category Name', // title
			array( $this, 'cat_id_callback' ), // callback
			'add-availability-calendar-admin', // page
			'add_availability_calendar_setting_section' // section
		);
	}

	public function add_availability_calendar_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['from_date'] ) ) {
			$sanitary_values['from_date'] = sanitize_text_field( $input['from_date'] );
		}

		if ( isset( $input['to_date'] ) ) {
			$sanitary_values['to_date'] = sanitize_text_field( $input['to_date'] );
		}

		if ( isset( $input['cat_id'] ) ) {
			$sanitary_values['cat_id'] = intval($input['cat_id']);
		}

		return $sanitary_values;
	}

	public function add_availability_calendar_section_info() {
		
	}

	public function from_date_callback() {
		printf(
			'<input class="regular-text from_date owacdate" type="text" name="add_availability_calendar[from_date]" id="from_date" value="%s" autocomplete="off" required readonly>',
			isset( $this->add_availability_calendar->from_date ) ? esc_attr( date('m-d-Y', $this->add_availability_calendar->from_date)) : ''
		);
	}

	public function to_date_callback() {
		printf(
			'<input class="regular-text to_date owacdate" type="text" name="add_availability_calendar[to_date]" id="to_date" value="%s" autocomplete="off" required readonly>',
			isset( $this->add_availability_calendar->to_date ) ? esc_attr( date('m-d-Y', $this->add_availability_calendar->to_date)) : ''
		);
	}

	public function cat_id_callback() {
		?> <select name="add_availability_calendar[cat_id]" id="cat_id" required="required">
			<option value=""><?php esc_html_e( 'Select One Category', 'availability-calendar' ); ?></option>
			<?php 	
					global $wpdb;
					$table_prefix = $wpdb->prefix . 'OWAC_category';
					$total_pages_sql = $wpdb->get_results("SELECT cat_id,cat_name_eng FROM $table_prefix WHERE 1 AND `flag`='0'");
					foreach($total_pages_sql as $row){ 
			?>
				<?php $selected = (isset( $this->add_availability_calendar->cat_id ) && $this->add_availability_calendar->cat_id === $row->cat_id) ? 'selected' : '' ; ?>
				<option value="<?php esc_html_e( $row->cat_id, 'availability-calendar' ); ?>" <?php esc_html_e( $selected, 'availability-calendar' ); ?>><?php esc_html_e( $row->cat_name_eng, 'availability-calendar' ); ?></option>
			<?php } ?>
		</select> <?php
	}

}
if ( is_admin() )
	$add_availability_calendar = new AddAvailabilityCalendar();
