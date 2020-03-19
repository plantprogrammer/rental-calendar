$month_cur = intval(date("m")); // Month set
$endmonth_cur = 12;
$m = $month_cur;
//for($m=$month_cur;$m<=$endmonth_cur;$m++){
        //get current month info 
				$month = date("m");  
				$year = date('Y');
				$dateObject = DateTime::createFromFormat('!m', $m);
		        
				$month = $dateObject->format('m');
				$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		//calculate the number of days before beginning of month
		        $dateObjectPrior = DateTime::createFromFormat('!m', $m-1);
		        $monthPrior = $dateObjectPrior->format('m');
		        $no_of_days_prior = cal_days_in_month(CAL_GREGORIAN, $monthPrior, $year);//calculate number of days in prior month
		
		//insert days from the previous month
		        
				$wk_day_num = date('w',mktime(0,0,0,$month,1,$year));        //This will calculate the week day of the first day of the month
				                                                             //(0 for Sunday, 6 for Saturday)
                $wk_day_num++;  //incremented because visually Sunday is not at first weekday in calendar position
		        if ($wk_day_num == 7)   //if it's Saturday, wrap it around 
		        {
		            $wk_day_num = 0;   
		        }
                
                $diff = $wk_day_num - 1;    //subtracted to get the initial date of the prior month 
                
                $no_days_prior_month = 0;    
                
                $first_day_range = $no_of_days_prior - $diff;    //get the first date involved with the range
                
		        for ($i=0;$i<$wk_day_num;$i++)
			    {
			        $cur_day_val = $no_of_days_prior - $diff;
			        
			        $no_days_prior_month++;

			        $diff--;
			    }
        //calculate how many remaining days for this month
        
			    $no_days_in_week = 7;
			    $no_days_left = $no_days_in_week - $no_days_prior_month;
			    
			    $last_day_range = $no_days_left;
				
			    echo date("m/d",mktime(0, 0, 0, $monthPrior, $first_day_range, $year)) . "-" . date("m/d",mktime(0, 0, 0, $month, $last_day_range, $year)) . "\n";    //get the month value for each
                
                while ($last_day_range <= $no_of_days)
                {
                    $first_day_range = $last_day_range + 1;
			        $last_day_range = $last_day_range + 7;
			        
			        echo date("m/d",mktime(0, 0, 0, $month, $first_day_range, $year)) . "-" . date("m/d",mktime(0, 0, 0, $month, $last_day_range, $year)) . "\n";    //get the month value for each
                }
			    $wk_day_num = date('w',mktime(0,0,0,$month,1,$year));
			    			
					$data .= "</ul>
							</div>";
				}
		$data .= "</div>";
		
		$data .= "</div>";
		
		
		return $data;
    }
