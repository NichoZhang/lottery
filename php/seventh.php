<?php
$code_start = microtime(true);
//在篮球中查看其中每次出现的频率，看哪个篮球出现的频率最高
$rate = array();
foreach($get_balls_count[7] as $blue_ball => $balls_count){
	if(!empty($balls_count)){
		$rate[$blue_ball] = ($balls_count/1529)*100;
	}
}
arsort($rate);
file_put_contents(dirname(__FILE__).'/../data/blue_balls_rate1.php',var_export($rate,true));
$code_end = microtime(true);
print_r($code_end-$code_start);
