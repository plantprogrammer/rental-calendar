<?php
class AddPrices {
	private $add_price_options;
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_prices_add_plugin_page' ) );
		
		include_once( plugin_dir_path( __FILE__ ) . '../../vendor/advanced-custom-fields/acf.php' );
		
		add_filter( 'acf/settings/path', array( $this, 'update_acf_settings_path' ) );
        add_filter( 'acf/settings/dir', array( $this, 'update_acf_settings_dir' ) );
        
        $this->setup_options_jan();
        $this->setup_options_feb();
        $this->setup_options_mar();
        
        add_action( 'admin_init', array( $this, 'add_acf_variables' ) );
	}
	
	public function add_acf_variables() {
        acf_form_head();
    }   
	
	 function update_acf_settings_path( $path ) 
	{
        $path = plugin_dir_path( __FILE__ ) . '../../vendor/advanced-custom-fields/';
        return $path;
    }

    function update_acf_settings_dir( $dir ) 
    {
        $dir = plugin_dir_url( __FILE__ ) . '../../vendor/advanced-custom-fields/';
        return $dir;
    }
	
	public function add_prices_add_plugin_page() {
	    add_submenu_page( 'availabilitycalendar', 'owacprices', 'Prices', 'manage_options', 'owacprices', array( $this, 'prices_create_admin_page' ));
	}
	public function prices_create_admin_page()
	{
        do_action('acf/input/admin_head'); // Add ACF admin head hooks
        do_action('acf/input/admin_enqueue_scripts'); // Add ACF scripts
        
        $options_jan = array(
        'id' => 'acf-form',
        'post_id' => 'options',
        'new_post' => false,
        'field_groups' => array( 'group_5e6aae43514af' ),
        'return' => admin_url('admin.php?page=owacprices'),
        'submit_value' => 'Update',
        );
         $options_feb = array(
        'id' => 'acf-form',
        'post_id' => 'options',
        'new_post' => false,
        'field_groups' => array( 'group_5e6d6bc850029' ),
        'return' => admin_url('admin.php?page=owacprices'),
        'submit_value' => 'Update',
        );
         $options_mar = array(
        'id' => 'acf-form',
        'post_id' => 'options',
        'new_post' => false,
        'field_groups' => array( 'group_5e6d7679956b1' ),
        'return' => admin_url('admin.php?page=owacprices'),
        'submit_value' => 'Update',
        );
        
        echo "<h1>Prices</h1>";
        echo "<h2>January</h2>";
        acf_form( $options_jan );
        echo "<h2>February</h2>";
        acf_form( $options_feb );
        echo "<h2>March</h2>";
        acf_form( $options_mar );
	}
	public function setup_options_jan() 
	{
	   if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
	'key' => 'group_5e6aae43514af',
	'title' => 'January',
	'fields' => array(
		array(
			'key' => 'field_5e6aae62e6aec',
			'label' => 'Week 1',
			'name' => '01_week_1',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6aaedee6aed',
			'label' => 'Week 2',
			'name' => '01_week_2',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6aaf17e6aee',
			'label' => 'Week 3',
			'name' => '01_week_3',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6aaf21e6aef',
			'label' => 'Week 4',
			'name' => '01_week_4',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6c3b9c4dbc7',
			'label' => 'Week 5',
			'name' => '01_week_5',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d69e8e28d3',
			'label' => 'Week 6',
			'name' => '01_week_6',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
	}
	public function setup_options_feb()
	{

acf_add_local_field_group(array(
	'key' => 'group_5e6d6bc850029',
	'title' => 'February',
	'fields' => array(
		array(
			'key' => 'field_5e6d6bd53b462',
			'label' => 'Week 1',
			'name' => '02_week_1',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d6bf13b463',
			'label' => 'Week 2',
			'name' => '02_week_1',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d6c0a3b464',
			'label' => 'Week 3',
			'name' => '02_week_3',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d6c1d3b465',
			'label' => 'Week 4',
			'name' => '02_week_4',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d6c3e3b466',
			'label' => 'Week 5',
			'name' => '02_week_5',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d6c603b467',
			'label' => 'Week 6',
			'name' => '02_week_6',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
	}
	public function setup_options_mar()
	{
	    if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5e6d7679956b1',
	'title' => 'March',
	'fields' => array(
		array(
			'key' => 'field_5e6d768800296',
			'label' => 'Week 1',
			'name' => '03_week_1',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d769a00297',
			'label' => 'Week 2',
			'name' => '03_week_2',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d76a800298',
			'label' => 'Week 3',
			'name' => '03_week_3',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d76af00299',
			'label' => 'Week 4',
			'name' => '03_week_4',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d76b60029a',
			'label' => 'Week 5',
			'name' => '03_week_5',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e6d76bd0029b',
			'label' => 'Week 6',
			'name' => '03_week_6',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
	}
}

if ( is_admin() )
	$add_prices = new AddPrices();