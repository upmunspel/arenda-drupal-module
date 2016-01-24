<?php 
	/*$reservObj = Object();
	$reservObj->status = 1;
	$reservObj->start_date = "2015-05-05";
	$reservObj->end_date = "2015-05-15";
	$reservObj->hash = md5($reservObj->start_date.$reservObj->end_date);*/
	//array("reservObject"=>Object(), "reserv_month"=>$reserv_month ,"reserv_year"=>$reserv_year) 
$cur_year = date("Y");
$mons = array(1 => "Янв", 2 => "Фев", 3 => "Мар", 4 => "Апр", 5 => "Май", 6 => "Июн", 7 => "Июл", 8 => "Авг", 9 => "Сен", 10 => "Окт", 11 => "Ноя", 12 => "Дек");

?>
<?php foreach($reserv_year as $year): ?>
		<div class = "year year-<?php print $year; print  ($year == $cur_year) ? " current-year":"";?>">
			<div class="year-value">
			<?php print $year; ?>
			</div>
			<div class="day-nums">
			    <div class="month-name">Мес</div>
				<?php for($i=1; $i<=31; $i++){ echo "<div class='day-num'>$i</div>"; } ?>
			</div>	
			<?php foreach($reserv_month  as $month): $num = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
					<div class="days month month-<?php print $month; ?>" >
					 <div class="month-name"><?php echo $mons[$month]; ?></div>
					<?php 
						for( $i=1; $i<=$num; $i++){
							
							$cur = date("Y-m-d", mktime(0, 0, 0, $month, $i, $year));
							$time = mktime(0, 0, 0, $month, $i, $year);
							$params  = " data-nid='$nid' ";
							$class = "";
							$title = "";
							foreach($reservObject as $itv){
								
								$begin =$itv->start_date;
								$end = $itv->end_date;
								
								
								
								if (($begin <= $time) && ($time <= $end)) {
									if ($itv->delay < time() && $itv->status == 1){
										if (substr_count($class, "overdue") == 0) { $class .= " overdue "; }
									}
									$params .= " data-hash = '{$itv->hash}'";
									if (substr_count($class, "reserved") == 0) { $class .= " reserved "; }
									if (substr_count($class ,"status-".$itv->status) == 0) {$class .= " status-".$itv->status;}
									if ($time == $begin) {
										if (substr_count($class, "start") == 0) {	
											$class .=" start "; 
											$title .=" Время заезда - ".$itv->start_time; 	
										}
									}
									if ($time == $end) {
										if (substr_count($class, "end") == 0) { 
											$class .=" end "; 
											$title .=" Время выезда - ".$itv->end_time; 
										}
									}
									
								} 
							}
							if (empty($class)) $class = " not-reserved ";
							echo "<div class='day $class' data-daynum ='$i' data-month='$month' data-date = '$cur' $params  title ='$title' ></div>";
						}
					?>
					</div>
			<?php endforeach; ?>
		</div>	
<?php endforeach; ?>	
