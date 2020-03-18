<?php 

for($m=$month_cur;$m<=$endmonth_cur;$m++){
				$month =date("m");  // Month 
				$month_cur =intval(date("m")); // Month set
				$dateObject = DateTime::createFromFormat('!m', $m);
				//$monthName = utf8_encode(strftime("%B", mktime(0,0,0,$m+1,0,0)));
				$mName=strftime("%B", mktime(0,0,0,$m+1,0,0));
				$encoding = mb_detect_encoding($mName, "auto" );
				$monthName =mb_convert_encoding($mName, 'UTF-8','Windows-1252');
		
				$month = $dateObject->format('m');
				$d= 2; // To Finds today's date
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
					$set_event = $this->OWAC_check_date($pv_r,$cur_day_val,$empty,$wk_day_num,$month_pre,$category_short,$apartment_short);
					if(!empty($set_event)){
						$adj .= $set_event;
					}else{
						$adj .= "<td ".$sday."><span>$cur_day_val</span></td>";
					}
			        $diff--;
			    }
			    
			    //calculate the number of days after        
		        $monthAfter =date("m");  // Month 
		        $dateObjectAfter = DateTime::createFromFormat('!m', $m+1);
		        $monthAfter = $dateObjectAfter->format('m');
		        $no_of_days_after = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $year);//calculate number of days in prior month
			    
			    $beg_month_val = 1;
				while ($wk_day_num <= 7 & $wk_day_num != 0)
				{
				    
				    if ($wk_day_num < 7)
				    {
    				    $pv="'$monthAfter'".","."'$beg_month_val'".","."'$year'";
    					$pv_r="$beg_month_val"."-"."$monthAfter"."-"."$year";
    					$pv_r=strtotime($pv_r);
    					$sday="class='disable extradays'";
    			        
    			        $month_aft = $m + 1;
    			        $empty = "";
    					$set_event = $this->OWAC_check_date($pv_r,$beg_month_val,$empty,$wk_day_num,$month_aft,$category_short,$apartment_short);
    					if(!empty($set_event)){
    						$data .= $set_event;
    					}else{
    						$data .= "<td ".$sday."><span>$beg_month_val</span></td>";
    					}
				    }
				    if($wk_day_num==7)
				    {
				        $amt = get_field($month . '_' . 'week_'.$price_row_no, 'option');
					    $data .= $adj."<td ".$sday."><span class='price'>€$amt</span></td>"; 
				    }
				    $wk_day_num ++;
				    $beg_month_val++;
				}
}
?>
