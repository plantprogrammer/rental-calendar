<?php 

$month_cur = intval(date("m")); // Month set

for($m=$month_cur;$m<=$endmonth_cur;$m++){
				$month =date("m");  // Month 
				$dateObject = DateTime::createFromFormat('!m', $m);
		
				$month = $dateObject->format('m');
				$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				
		//calculate the number of days before beginning of month
		        $monthPrior =date("m");  // Month 
		        $dateObjectPrior = DateTime::createFromFormat('!m', $m-1);
		        $monthPrior = $dateObjectPrior->format('m');
		        $no_of_days_prior = cal_days_in_month(CAL_GREGORIAN, $monthPrior, $year);//calculate number of days in prior month
		        $wk_day_prior = date('w',mktime(0,0,0,$monthPrior,$no_of_days_prior,$year));
		//insert days from the previous month
		        $adj = "";
		        
                $diff = $wk_day_num - 1;
                
                $no_days_prior_month = 0;    
                
                $first_day_range = $no_of_days_prior - $diff;    //get the first date involved with the range
                
		        for ($i=0;$i<$wk_day_num;$i++)
			    {
			        $cur_day_val = $no_of_days_prior - $diff;
			        
			        $no_days_prior_month++;
			        
			        $month_pre = $m - 1;
			        
					$set_event = $this->OWAC_check_date($pv_r,$cur_day_val,$empty,$wk_day_num,$month_pre,$category_short,$apartment_short);
					if(!empty($set_event)){
						$adj .= $set_event;
					}else{
						$adj .= "<td ".$sday."><span>$cur_day_val</span></td>";
					}
			        $diff--;
			    }
			    
			    $no_days_in_week = 7;
			    $no_days_left = $no_days_in_week - $no_days_prior_month;
			    
			    $day_of_month;
			    
			    for ($day_of_month = 1; $day_of_month <= $no_days_left; $day_of_month++)
			    {
			           
			    }
			    
			    $last_day_range = $day_of_month;
			    
			    echo $monthPrior . $first_day_range . $month . $last_day_range;    //get the month value for each
			    
			     //if the last week
			    
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
    			        
    			        $month_aft = $m + 1;
    			        $empty = "";
    					$set_event = $this->OWAC_check_date($pv_r,$beg_month_val,$empty,$wk_day_num,$month_aft,$category_short,$apartment_short);
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
