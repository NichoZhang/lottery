<?php
$code_start = microtime(true);
$file = dirname(__FILE__).'/../data/2003-2015.csv';
$source_data = file_get_contents($file);
$source_data_arr = explode("\n", $source_data);
$source_data_arr_filter = array_filter($source_data_arr);
$put_out_data = '';
$blue_balls = array();
$rate = array();
foreach($source_data_arr_filter as $key => $value){
	preg_match_all('/\|(\d+)\"/', $value, $matches);
	$blue_balls[] = $matches[1][0];
}
$rate_count_values = array_count_values($blue_balls);
$count_blue_balls = count($blue_balls);
foreach($rate_count_values as $k => $v){
	$rate[$k] = ($v/$count_blue_balls)*100;
}
arsort($rate);
file_put_contents(dirname(__FILE__).'/../data/blue_balls_rate'.date("YmdHis").'.php',var_export($rate,true));
$code_end = microtime(true);
print_r($code_end-$code_start);
