<?php 
/**
 * Check link
 */
function owac_link( $url, $anchor_text, $args = '' ) {
	
	$defaults = array(
	
		'id' => '',
		
		'class' => '',
		
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	$args = array_intersect_key( $args, $defaults );
	
	$atts = owac_format_atts( $args );
	
	$link = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
	
		esc_url( $url ),
		
		esc_html( $anchor_text ),
		
		$atts ? ( ' ' . $atts ) : '' );

	return $link;
	
}

/**
 * Check owac format atts
 */
function owac_format_atts( $atts ) {
	$html = '';
	$prioritized_atts = array( 'type', 'name', 'value' );

	foreach ( $prioritized_atts as $att ) {
		if ( isset( $atts[$att] ) ) {
			$value = trim( $atts[$att] );
			$html .= sprintf( ' %s="%s"', $att, esc_attr( $value ) );
			unset( $atts[$att] );
		}
	}

	foreach ( $atts as $key => $value ) {
		$key = strtolower( trim( $key ) );

		if ( ! preg_match( '/^[a-z_:][a-z_:.0-9-]*$/', $key ) ) {
			continue;
		}

		$value = trim( $value );

		if ( '' !== $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
		}
	}

	$html = trim( $html );

	return $html;
}

/**
 * Availability List
 */
function OWAC_Availability_list(){
	
    $OWAC_list_Table = new OWAC_Availability_list_Table();
	
	$OWAC_list_Table->prepare_items();
	
	$OWAC_list_Table->process_bulk_action();
	
?>
<div class="wrap owac-main">
	
	    <form id="form" method="POST">
		
		<?php $apt_id = $_POST["apt_id"];?>
		
		<h1 class="wp-heading-inline"><?php echo "Apartment " . $apt_id?></h1>
		
		<a href="<?php echo esc_url('admin.php?page=availabilityadd&apt_id='. $apt_id); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'availability-calendar' ); ?></a>
		
		<hr class="wp-header-end">
		
		<ul class="subsubsub">
		
			<li class="all">
			
				<a href="<?php echo esc_url('admin.php?page=availabilitycalendar'); ?>"><?php esc_html_e( 'All', 'availability-calendar' ); ?>
				
					<span class="count">(<?php esc_html_e( $OWAC_list_Table->count_all(), 'availability-calendar' ); ?>)</span>
					
				</a> <?php esc_html_e( '|', 'availability-calendar' ); ?>
				
			</li>
			
			<li class="trash">
			
				<a href="<?php echo esc_url('admin.php?page=availabilitycalendar&Trash=Trash'); ?>"><?php esc_html_e( 'Trash', 'availability-calendar' ); ?> 
				
					<span class="count">(<?php esc_html_e( $OWAC_list_Table->count_trash(), 'availability-calendar' ); ?>)</span>
				
				</a>
				
			</li>
			
		</ul>
		
		<?php $OWAC_list_Table->display();?>
		
        </form>
	
	<div class="shortcode">
	
		<h4><?php esc_html_e( 'shortcode :', 'availability-calendar' ); ?> </h4>
		
		<p><?php esc_html_e( '[availabilitycalendar]', 'availability-calendar' ); ?></p>
		
	</div>
	
</div>
<?php }

/**
 * Availability List Trash
 */
function OWAC_Availability_list_trash(){

    echo $_POST['apt_id'];

    $OWAC_list_trash_Table=new OWAC_Availability_list_trash_Table();
	
	$OWAC_list_trash_Table->prepare_items();
	
	$OWAC_list_trash_Table->process_bulk_action();
?>

<div class="wrap owac-main">

	<form id="form" method="post">
	
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Availability Calendar Listing', 'availability-calendar' ); ?></h1>
		
		<a href="<?php echo esc_url('admin.php?page=availabilityadd'); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'availability-calendar' ); ?></a>
		
		<hr class="wp-header-end">
		
		<ul class="subsubsub">
		
			<li class="all">
			
				<a href="<?php echo esc_url('admin.php?page=availabilitycalendar'); ?>"><?php esc_html_e( 'All', 'availability-calendar' ); ?> 
					
					<span class="count">(<?php esc_html_e(  $OWAC_list_trash_Table->count_all(), 'availability-calendar' ); ?>)</span>
				
				</a> <?php esc_html_e( '|', 'availability-calendar' ); ?>
			
			</li>
			
			<li class="trash">
				<a href="<?php echo esc_url('admin.php?page=availabilitycalendar&Trash=Trash'); ?>"><?php esc_html_e( 'Trash', 'availability-calendar' ); ?> 
					
					<span class="count">(<?php esc_html_e(  $OWAC_list_trash_Table->count_trash(), 'availability-calendar' ); ?>)</span>
				
				</a>
			
			</li>
			
		</ul>
		
		<?php $OWAC_list_trash_Table->display();?>
		
	</form>
	
	<div class="shortcode">
	
		<h4><?php esc_html_e( 'shortcode :', 'availability-calendar' ); ?> </h4>
		
		<p><?php esc_html_e( '[availabilitycalendar]', 'availability-calendar' ); ?></p>
		
	</div>
	
</div>

<?php } 

/**
 * Category Listing
 */
function OWAC_Category_list(){
	
    $OWAC_Category_Table = new OWAC_Category_list_Table();
	
	$OWAC_Category_Table->prepare_items();
	
	$OWAC_Category_Table->process_bulk_action();
	
?>
<div class="wrap owac-main">

	<form id="form" method="post">
	
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Category Listing', 'availability-calendar' ); ?></h1>
		
		<a href="<?php echo esc_url('admin.php?page=owaccategory'); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'availability-calendar' ); ?></a>
		
		<hr class="wp-header-end">
		
		<ul class="subsubsub">
		
			<li class="all">
			
				<a href="<?php echo esc_url('admin.php?page=owaccategorylist'); ?>"><?php esc_html_e( 'All', 'availability-calendar' ); ?>
				
					<span class="count">(<?php esc_html_e( $OWAC_Category_Table->count_all(), 'availability-calendar' ); ?>)</span>
					
				</a> <?php esc_html_e( '|', 'availability-calendar' ); ?>
				
			</li>
			
			<li class="trash">
			
				<a href="<?php echo esc_url('admin.php?page=owaccategorylist&Trash=Trash'); ?>"><?php esc_html_e( 'Trash', 'availability-calendar' ); ?> 
				
					<span class="count">(<?php esc_html_e( $OWAC_Category_Table->count_trash(), 'availability-calendar' ); ?>)</span>
				
				</a>
				
			</li>
			
		</ul>
		
		<?php $OWAC_Category_Table->display();?>
		
	</form>
	
	<div class="shortcode">
	
		<h4><?php esc_html_e( 'shortcode :', 'availability-calendar' ); ?> </h4>
		
		<p><?php esc_html_e( '[availabilitycalendar]', 'availability-calendar' ); ?></p>
		
	</div>
	
</div>
<?php }

/**
 * Category Listing Trash
 */
function OWAC_Category_list_trash(){
	
    $OWAC_Category_trash_Table = new OWAC_Category_list_trash_Table();
	
	$OWAC_Category_trash_Table->prepare_items();
	
	$OWAC_Category_trash_Table->process_bulk_action();
	
?>
<div class="wrap owac-main">

	<form id="form" method="post">
	    
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Category Listing', 'availability-calendar' ); ?></h1>
		<a href="<?php echo esc_url('admin.php?page=owaccategory'); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'availability-calendar' ); ?></a>
		
		<hr class="wp-header-end">
		
		<ul class="subsubsub">
		
			<li class="all">
			
				<a href="<?php echo esc_url('admin.php?page=owaccategorylist'); ?>"><?php esc_html_e( 'All', 'availability-calendar' ); ?>
				
					<span class="count">(<?php esc_html_e( $OWAC_Category_trash_Table->count_all(), 'availability-calendar' ); ?>)</span>
					
				</a> <?php esc_html_e( '|', 'availability-calendar' ); ?>
				
			</li>
			
			<li class="trash">
			
				<a href="<?php echo esc_url('admin.php?page=owaccategorylist&Trash=Trash'); ?>"><?php esc_html_e( 'Trash', 'availability-calendar' ); ?> 
				
					<span class="count">(<?php esc_html_e( $OWAC_Category_trash_Table->count_trash(), 'availability-calendar' ); ?>)</span>
				
				</a>
				
			</li>
			
		</ul>
		
		<?php $OWAC_Category_trash_Table->display();?>
		
	</form>
	
	<div class="shortcode">
	
		<h4><?php esc_html_e( 'shortcode :', 'availability-calendar' ); ?> </h4>
		
		<p><?php esc_html_e( '[availabilitycalendar]', 'availability-calendar' ); ?></p>
		
	</div>
	
</div>

<?php }

//ADD 
if(isset($_POST['owac_add']) && !empty($_POST['owac_add'])){
	
	if(isset($_POST['add_availability_calendar']) && !empty($_POST['add_availability_calendar'])){
		
		$values = $_POST['add_availability_calendar'];
		
		if($values['from_date'] != '' && $values['to_date'] != '' && $values['cat_id'] != ''){
			
			$add = new OWAC_Availability();
			
		   	$add->insert($values);
			
		} else { 
		
			function owac_error_notice() {
				
		?>
		
			<div class="error notice">
			
				<p><?php _e( 'Please fill all fields', 'availability-calendar' ); ?></p>
				
			</div>
			
		<?php
		
			}
			
			add_action( 'admin_notices', 'owac_error_notice' );
			
		}
		
	}
	
}

//Update
if(isset($_POST['owac_update']) && !empty($_POST['owac_update'])){
	
	$id = intval($_POST['ev_id']);
	
	if(isset($_POST['add_availability_calendar']) && !empty($_POST['add_availability_calendar'])){
		
		$values = $_POST['add_availability_calendar'];

		if($values['from_date'] != '' && $values['to_date'] != '' && $values['cat_id'] != ''){
			
			$add = new OWAC_Availability();
			
			$add->UPDATE($id , $values);
			
		} else { 
		
			function owac_error_notice() {
				
		?>
		
			<div class="error notice">
			
				<p><?php _e( 'Please fill all fields', 'availability-calendar' ); ?></p>
				
			</div>
			
		<?php
		
			}
			
			add_action( 'admin_notices', 'owac_error_notice' );
			
		}
		
	}
	
}

//CategoryAdd
if(isset($_POST['owac_category_add']) && !empty($_POST['owac_category_add'])){
	
	if(isset($_POST['add_category']) && !empty($_POST['add_category'])){
		
		$values = $_POST['add_category'];
	
		global $wpdb;
		
		$category_count = $wpdb->get_var(
							$wpdb->prepare(
								"SELECT COUNT(*) FROM 
									`{$wpdb->prefix}OWAC_category` 
								WHERE `cat_name_eng` LIKE %s OR `cat_color` LIKE %s",
								$values['cat_name_eng'],
								$values['cat_color']
							)
						);

		if($category_count>0){ 
		
			function owac_error_notice() {
				
			?>
			
				<div class="error notice">
				
					<p><?php _e( 'Category Name Or color Already Exist', 'availability-calendar' ); ?></p>
					
				</div>
				
			<?php
			
				}
				
				add_action( 'admin_notices', 'owac_error_notice' );
				
		} else {
			
			if($values['cat_name_eng'] != ''){	
			
				$add = new OWAC_category();
				
				$add->insert($values);
				
			} else { 
			
				function owac_error_notice() {
					
			?>
				<div class="error notice">
				
					<p><?php _e( 'Please fill all fields', 'availability-calendar' ); ?></p>
					
				</div>
				
			<?php
			
				}
				
				add_action( 'admin_notices', 'owac_error_notice' );
				
			}
			
		} 
		
	}
	
}

//CategoryUpdate
if(isset($_POST['owac_category_update']) && !empty($_POST['owac_category_update'])){
	
	$id = intval($_POST['cat_id']);
	
	if(isset($_POST['add_category']) && !empty($_POST['add_category'])){
		
		$values = $_POST['add_category'];

		global $wpdb;
		
		$category_count = $wpdb->get_var(
								$wpdb->prepare(
									"SELECT COUNT(*) FROM 
										`{$wpdb->prefix}OWAC_category` 
									WHERE `cat_color` LIKE %s AND `cat_id` <> %d",
									$values['cat_color'],
									$id
								)
							);
		
		if($category_count>0){ 
		
			function owac_error_notice() {
				
			?>
			
				<div class="error notice">
				
					<p><?php _e( 'Color Already Exist', 'availability-calendar' ); ?></p>
					
				</div>
				
			<?php
			
				}
				
				add_action( 'admin_notices', 'owac_error_notice' );
				
		} else {
			
			if($values['cat_name_eng'] != ''){	
			
				$add = new OWAC_category();
				
				$add->UPDATE($id , $values);
				
			} else { 
			
				function owac_error_notice() {
					
			?>
			
				<div class="error notice">
				
					<p><?php _e( 'Please fill all fields', 'availability-calendar' ); ?></p>
					
				</div>
				
			<?php
			
				}
				
				add_action( 'admin_notices', 'owac_error_notice' );
				
			}
			
		}
		
	}
	
}