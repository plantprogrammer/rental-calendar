<?php 
class OWAC_Availability{

	var $ev_id = "";
	var $v_name = "";
	var $ev_des = "";
	var $from_date = "";
	var $to_date = "";
	var $cat_id = "";
	var $flag = "";
    var $apt_id = "";
    public function insert($checkarray){

       	global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_event';
		$date = time();
		$from_date = strtotime($checkarray['from_date']);
		$to_date = strtotime($checkarray['to_date']);
		$apt_id = $_GET['apt_id'];
		
		$query = $wpdb->insert(
			$table_prefix, 
				array(
				    'apt_id' => $apt_id,
					'from_date' => $from_date,
					'to_date' => $to_date,
					'cat_id' => $checkarray['cat_id'],
					'created_date' => $date,
					'status' => '1',
					'flag' => '0'
				),  
                array('%d','%d','%d','%d','%d','%d','%d')
		);

	   	if(!empty($query)){
		   	$success = "Add Success";
		   	header('Location: admin.php?page=owacapt' . $_GET['apt_id']);
		   	exit();	
	   	} else {
		   	function owac_error_notice() {
		?>
			<div class="error notice">
				<p><?php _e( 'You have not properly filled fields!', 'availability-calendar' ); ?></p>
			</div>	
		<?php
			}
			add_action( 'admin_notices', 'owac_error_notice' );		
	   }
		
    }

	public function UPDATE($where , $updatevalues){
		
        global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_event';
		$date = time();
		$from_date = strtotime($updatevalues['from_date']);
		$to_date = strtotime($updatevalues['to_date']);
		$apt_id = $_GET['page'];
		$query = $wpdb->update(
			$table_prefix, 
				array(
					'from_date' => $from_date,
					'to_date' => $to_date,
					'cat_id' => $updatevalues['cat_id']
				), 
				array('ev_id' => $where), 
				array('%d','%d','%d'),
				array('%d')
		);

		if(!empty($query)){
		   $success = "Update Success";
		   header('Location: admin.php?page=owacapt' . $apt_id[7] . '&updatesuccess=1');
		   exit();
		} else {
		   header('Location: admin.php?page=owacapt' . $apt_id[7] . '&updateerror=1');
		   exit();		
		}
    }
}
?>