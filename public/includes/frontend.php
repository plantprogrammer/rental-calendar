<?php
class OWAC_calendar_front {
	
    public function __construct()
    {
		global $wpdb;
		add_shortcode('availabilitycalendar', array($this, 'OWAC_calendar_front_shortcode'));
    }
	
	private function OWAC_check_date($pv_r,$k,$adj,$wk_day_num,$m,$apartment_short){	
		$return_value = "";
		global $wpdb;
		$contactus_table = $wpdb->prefix."OWAC_event";
		$total_pages_sql = $wpdb->get_results("SELECT * FROM $contactus_table WHERE 1 AND `flag`='0'" . " AND apt_id =" . $apartment_short);

		for($i=0;$i<count($total_pages_sql);$i++){
			$ec_category_table = $wpdb->prefix."OWAC_category";
			$ec_category_sql = $wpdb->get_results("SELECT * FROM $ec_category_table where cat_id = ". $total_pages_sql[$i]->cat_id. " AND `flag`='0'");
			$from_date = $total_pages_sql[$i]->from_date;
			$to_date = $total_pages_sql[$i]->to_date;
			$cat_color = $ec_category_sql[0]->cat_color;
			$cat_name_eng = $ec_category_sql[0]->cat_name_eng;
			$cat_name_fre = $ec_category_sql[0]->cat_name_fre;
			
			$sday="";
			
			if($from_date <= $pv_r && $to_date >= $pv_r) {
				$return_value = $adj."<td ".$sday."><span class='owaccatdec' style='background-color:".$cat_color."'>$k</span></td>";
				$cat_color_new = $cat_color;
			}	
		}
		return $return_value;
	}
	
    public function OWAC_calendar_front_shortcode($atts = array())
    {	
		$atts = shortcode_atts(array('apartment' => '','language' => ''), $atts);
	    $apartment_short = $atts['apartment'];
	    $language_short = $atts['language'];

	   /**
		* Get Event and Category value
		*/
		global $wpdb;
		$contactus_table = $wpdb->prefix."OWAC_event";
		$total_pages_sql = $wpdb->get_results("SELECT * FROM $contactus_table WHERE 1 AND `flag`='0'" . " AND apt_id =" . $apartment_short);
		$ec_category_table = $wpdb->prefix."OWAC_category";
		$ec_category_sql = $wpdb->get_results("SELECT * FROM $ec_category_table WHERE 1 AND `flag`='0' ORDER BY `cat_ord_num` ASC");
		$settings_options = get_option( 'OWAC_settings_option' );
		$display_calendar_month = preg_replace("/[^0-9\.]/", '', $settings_options['display_calendar_month']);
		
		/**
		* Set year
		*/
		$year=date('Y');  
		
		$start_year=date('Y');
		
		//$end_year=$start_year + 1;
		/**
		* Check Switch Case Set Display Calendar Year
		*/
		switch ($settings_options['display_calendar_month']) {
			
			case "1y":
				$end_year=$start_year + $display_calendar_month;
				$row = 12 * $display_calendar_month + 1;
				break;
				
			case "2y":
				$end_year=$start_year + $display_calendar_month;
				$row = 12 * $display_calendar_month + 1;
				break;
			
			case "3y":
				$end_year=$start_year + $display_calendar_month;
				$row = 12 * $display_calendar_month + 1;
				break;
			
			default:
				$end_year = $start_year + 1;
				$row=12;
				break;
		}
		
		/**
		* No Edit Below
		*/
		$row_no=0; 
		$total_month = "12";
		$data = "";
		$data .= "<div class='owac-calendar-container' style='background-color: #".$settings_options['background_color']." !important'>";
		/**
		* Add JavaScript
		*/
		if($settings_options['display_calendar_month'] == '1m'){
			$settings_options['desktop_column'] = 1;
		}elseif($settings_options['display_calendar_month'] == '2m'){
			$settings_options['desktop_column'] = 2;
		}
        
		$data .= "	
			<script type='text/javascript'>
				jQuery(document).on('ready', function() {
					jQuery('.owacregular').not('.owac-initialized').owacslider({
						dots: false,
						infinite: false,
						slidesToShow: ".$settings_options['desktop_column'].",
						slidesToScroll: ".$settings_options['slides_to_scroll'].",
						responsive: [{
							breakpoint: 800,
							settings: {
								slidesToShow: ".$settings_options['tablet_column'].",
								slidesToScroll: ".$settings_options['slides_to_scroll']."
							}
						},{
							breakpoint: 580,
							settings: {
								slidesToShow: ".$settings_options['mobile_column'].",
								slidesToScroll: ".$settings_options['slides_to_scroll']."
							}
						}]					
					})				  			  				 
					jQuery('.owac-slider').on('setPosition', function () {
						jbResizeSlider();
					});
				});
				function jbResizeSlider(){
					var owacSlider = jQuery('.owac-slider');
					owacSlider.find('.owac-slide').height('auto');
					var owacTrack = owacSlider.find('.owac-track');
					var owacTrackHeight = jQuery(owacTrack).height();
					owacSlider.find('.owac-slide').css('height', owacTrackHeight + 'px');
				}
				jQuery(window).on('resize', function(e) {
					jbResizeSlider(); 
				});
			</script>";	
		
		
		/**
		* Display Calendar
		*/
		$data .= "<div class='main regularslider owac'>"; 
		/**
		* Starting of for loop
		* Creating calendars for Set year and Month 
		* Creating calendars for each month by looping 12 times
		*/
		for($r=$start_year;$r<=$end_year;$r++){
			$year = $r;
			$month_cur = intval(date("m"));
			$month_cur_u = intval(date("m"));
		/**
		* Check If Condition set Current Month and End Month To Year Wise 
		*/
			if($r==$start_year || $start_year==$end_year){
				$month_cur =intval(date("m"));
				$endmonth_cur = 12;
			}elseif($r < $end_year){
				$month_cur = 1;
				$endmonth_cur = 12;
			}else{
				$month_cur = 1;
				$endmonth_cur = $month_cur_u;
			}
			
		/**
		* Check Switch Case Set Display Calendar Month
		*/	
			switch ($settings_options['display_calendar_month']) {
			
				case "1m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+1 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "2m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+2 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
				
				case "3m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+3 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "4m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+4 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
				
				case "5m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+5 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "6m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+6 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "7m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+7 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "8m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+8 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "9m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+9 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "10m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+10 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
				
				case "11m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+11 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
					
				case "12m":
					$endmonth_cur = $month_cur_u + $display_calendar_month - 1;
					$check_cur_y = date('d-m-Y', strtotime('+12 months'));
					$end_year = date('Y',strtotime($check_cur_y));
					break;
			}
			
			if($r==$start_year || $start_year==$end_year){
				if($endmonth_cur >= 12){
					$endmonth_cur = 12;
				}
			}elseif($r < $end_year){
				if($endmonth_cur > 12){
					$endmonth_cur = $endmonth_cur - 12;
				}
			}else{
				if($endmonth_cur >= 12){
					$endmonth_cur = $endmonth_cur - 12;
				}
			}
	
		/**
		* Starting of for loop
		* And Creating Month and Day
		*/
			for($m=$month_cur;$m<=$endmonth_cur;$m++){
				$month = date("m");  // Month 
				$month_cur =intval(date("m")); // Month set
				$dateObject = DateTime::createFromFormat('!m', $m);
				$mName=strftime("%B", mktime(0,0,0,$m+1,0,0));
				$monthName =mb_convert_encoding($mName, 'UTF-8','Windows-1252');
				
				if ($language_short == "FR")
				{
    				$monthName = str_replace(
                    array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
                    array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"),
                    $monthName
                    );
				}
				
				$month = $dateObject->format('m');
				$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		/**
		 * This will calculate the week day of the first day of the month
		 * (0 for Sunday, 6 for Saturday)
		 */
				$wk_day_num = date('w',mktime(0,0,0,$month,1,$year));
		        $price_row_no = 1;  //deal with this later
		
		        $wk_day_num++;  //incremented because visually Sunday is not at first weekday in calendar position
		        if ($wk_day_num == 7)   //if it's Saturday, wrap it around 
		        {
		            $wk_day_num = 0;   
		        }
		//calculate the number of days before beginning 
		        $monthPrior =date("m");  // Month 
		        $dateObjectPrior = DateTime::createFromFormat('!m', $m-1);
		        $monthPrior = $dateObjectPrior->format('m');
		        $no_of_days_prior = cal_days_in_month(CAL_GREGORIAN, $monthPrior, $year);//calculate number of days in prior month
		        $wk_day_prior = date('w',mktime(0,0,0,$monthPrior,$no_of_days_prior,$year));
		//calculate the number of days after        
		        $monthAfter =date("m");  // Month 
		        $dateObjectAfter = DateTime::createFromFormat('!m', $m+1);
		        $monthAfter = $dateObjectAfter->format('m');
		        $no_of_days_after = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $year);//calculate number of days in prior month
		//insert days from the previous month
		        $adj = "";
                $diff = $wk_day_num - 1;
		        for ($i=0;$i<$wk_day_num;$i++)
			    {
			        $cur_day_val = $no_of_days_prior - $diff;
			        $pv="'$monthPrior'".","."'$cur_day_val'".","."'$year'";
					$pv_r="$cur_day_val"."-"."$monthPrior"."-"."$year";
					$pv_r=strtotime($pv_r);
					$sday="class='disable extradays'";
			        
			        $month_pre = $m - 1;
			        $empty = "";
					$set_event = $this->OWAC_check_date($pv_r,$cur_day_val,$empty,$wk_day_num,$month_pre,$apartment_short);
					if(!empty($set_event)){
						$adj .= $set_event;
					}else{
						$adj .= "<td ".$sday."><span>$cur_day_val</span></td>";
					}
			        $diff--;
			    }
			    /**
			     * 
			    function checkDateEnsure($day_val,$month)
			    {
			        $pv="'$month'".","."'$day_val'".","."'$year'";
					$pv_r="$day_val"."-"."$monthPrior"."-"."$year";
					$pv_r=strtotime($pv_r);
					$sday="class='disable'";
			
					$set_event = $this->OWAC_check_date($pv_r,$day_val,$adj,$wk_day_num,$m,$category_short);
					if(!empty($set_event)){
						$data .= $set_event;
					}else{
						$data .= $adj."<td ".$sday."><span>$day_val</span></td>";
					}
			    }
                */
				$blank_at_end=42-$wk_day_num-$no_of_days; // Days left after the last day of the month
				if($blank_at_end >= 5){$blank_at_end = $blank_at_end - 5 ;}
		/**
		* Starting of top line showing year and month to select
		*/	
				if(($row_no % $row)== 0){
					$data .= "<div class='owacregular slider calendar'>";
				}			
		/**
		* Set Month Name and Year
		*/
				$data .= "<table class='main owac owac_google_events' style='background-color: #".$settings_options['calendar_background_color']." !important;'><tr class='month_title'><td colspan=8 align=center><h3 style='background-color: #".$settings_options['month_background_color']." !important;; color: #".$settings_options['month_title_font_color']." !important;;'> $monthName $year</h3></td></tr>";
		/**
		* Showing name of the days of the week
		*/		
				if ($language_short == "EN")
				{
					$data .= "<tr class='day_title'><th><span>S</span></th><th><span>S</span></th><th><span>M</span></th><th><span>T</span></th><th><span>W</span></th><th><span>T</span></th><th><span>F</span></th><th><span class='price'>Price</span></th></tr><tr class='day_row'>";
				}
				else if ($language_short =="FR")
				{
					$data .= "<tr class='day_title'><th><span>S</span></th><th><span>S</span></th><th><span>L</span></th><th><span>M</span></th><th><span>M</span></th><th><span>J</span></th><th><span>V</span></th><th><span class='price'>Tarifs</span></th></tr><tr class='day_row'>";
				}
		/**
		* Starting of the Days
		*/	    
				for($i=1;$i<=$no_of_days;$i++){
					$pv="'$month'".","."'$i'".","."'$year'";
					$pv_r="$i"."-"."$month"."-"."$year";
					$pv_r=strtotime($pv_r);
					$sday="class='disable'";
		/**
		* Call to Function
		*/				
					$set_event = $this->OWAC_check_date($pv_r,$i,$adj,$wk_day_num,$m,$apartment_short);
					if(!empty($set_event)){
						$data .= $set_event;
					}else{
						$data .= $adj."<td ".$sday."><span>$i</span></td>";
					}
					$adj='';
					$wk_day_num ++;
					
					$input_field_id = $apartment_short . "-" . $month . "-" . $price_row_no;
					
					if($wk_day_num==7)
					{
					    $data .= $adj."<td ".$sday."><span class='price'>€" . get_option($input_field_id) . "</span></td>"; 
						$data .= "</tr><tr class='day_row'>"; // start a new row
					    $wk_day_num=0;
						$price_row_no++;
					}
				}
				$beg_month_val = 1;
				if ($wk_day_num != 0)
				{
    				while ($wk_day_num < 7)
    				{    				    
        				    $pv="'$monthAfter'".","."'$beg_month_val'".","."'$year'";
        					$pv_r="$beg_month_val"."-"."$monthAfter"."-"."$year";
        					$pv_r=strtotime($pv_r);
        					$sday="class='disable extradays'";
        			        
        			        $month_aft = $m + 1;
        			        $empty = "";
        					$set_event = $this->OWAC_check_date($pv_r,$beg_month_val,$empty,$wk_day_num,$month_aft,$apartment_short);
        					if(!empty($set_event)){
        						$data .= $set_event;
        					}else{
        						$data .= "<td ".$sday."><span>$beg_month_val</span></td>";
        					}
        				$wk_day_num ++;
    				    $beg_month_val++;
    				}
    				$data .= "<td ".$sday."><span class='price'>€" . get_option($input_field_id) . "</span></td>"; 
    			}
				
				$data .= "</tr></table></td>";
				$row_no=$row_no+1;
			} // end of for loop for 12 months
		}
			$data .= "</div>";
		$data .= "</div>";
		
		/**
		* Set Header And Category Display
		*/	
		$data .= "<div class='header'>";
				if($settings_options['header_display'] == 'yes'){
					$data .= "<h1 class='title'>".$year."</h1>
							<p>".$settings_options['header_add_text']."</p>
					";
				}
				if($settings_options['category_display'] == 'yes'){	
					$data .= "<div class='event-calendar'>
								<ul>";
								for($i=0;$i<count($ec_category_sql);$i++){
									$cat_color = $ec_category_sql[$i]->cat_color;
									$cat_name = "";
									if ($language_short == "EN")
									{
									    $cat_name = $ec_category_sql[$i]->cat_name_eng;
									}
									else if ($language_short == "FR")
									{
									    $cat_name = $ec_category_sql[$i]->cat_name_fre;
									}
									$data .= "<li>";
										$data .= "<span class='cat_color' style='background-color:".$cat_color." !important'></span>";
										$data .= "<span class='event-name'>".$cat_name."</span>";
									$data .= "</li>";
								}	
							}
			 	
					$data .= "</ul>
							</div>";
			
	$data .= "</div>";
    
	$data .= "</div>";
		
		return $data;
    }

}
$OWAC_calendar_front = new OWAC_calendar_front();
