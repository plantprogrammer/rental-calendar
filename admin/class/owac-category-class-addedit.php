<?php 
class OWAC_category{

	var $cat_id = "";
	var $cat_name_eng = "";
	var $cat_name_fre = "";
	var $cat_color = "";
	var $cat_ord_num = "";
	var $created_date = "";
	var $status = "";
	var $flag = "";

    public function insert($checkarray){

       	global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_category';
		$date = time();

		$query = $wpdb->insert(
			$table_prefix, 
				array(
					'cat_name_eng' => $checkarray['cat_name_eng'],
					'cat_name_fre' => $checkarray['cat_name_fre'],
					'cat_color' => '#'.$checkarray['cat_color'],
					'cat_ord_num' => $checkarray['cat_ord_num'],
					'created_date' => $date,
					'status' => '1',
					'flag' => '0'
				),  
				array('%s','%s','%s','%d','%d','%d','%d')
		);

	   	if(!empty($query)){
		   	$success = "Add Success";
		   	header('Location: admin.php?page=owaccategorylist&success=1');
		   	exit();	
	   	} else {
		   	function owac_error_notice() {
		?>
			<div class="error notice">
				<p><?php _e( 'You have not proper fill fielda!', 'availability-calendar' ); ?></p>
			</div>	
		<?php
			}
			add_action( 'admin_notices', 'owac_error_notice' );		
	   }
    }

	public function UPDATE($where , $updatevalues){

        global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_category';
		$date = time();
		
		$query = $wpdb->update(
			$table_prefix, 
				array(
					'cat_name_eng' => $updatevalues['cat_name_eng'],
					'cat_name_fre' => $updatevalues['cat_name_fre'],
					'cat_color' => '#'.$updatevalues['cat_color'],
					'cat_ord_num' => $updatevalues['cat_ord_num']
				), 
				array('cat_id' => $where), 
				array('%s','%s','%s','%d'),
				array('%d')
		);
		
		if(!empty($query)){
		   $success = "Update Success";
		   header('Location: admin.php?page=owaccategorylist&updatesuccess=1');
		   exit();
		} else {
		   header('Location: admin.php?page=owaccategorylist&updateerror=1');
		   exit();		
		}
    }
}
?>