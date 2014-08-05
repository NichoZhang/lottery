<?php
$code_start = microtime(true);
$file = dirname(__FILE__).'/../data/data.php';
$file_new = dirname(__FILE__).'/../data/data_new.php';
$file_data = file_get_contents($file);
$file_temp_arr = explode('  ',$file_data);
$file_arr = array_filter($file_temp_arr);
$h = '';
foreach($file_arr as $key => $value){
	if($key % 7 == 0 && $key != 0){
		$h .= "\n";
	}
    $h .= $value.' ';
}
//print_r($h);
file_put_contents($file_new,$h,FILE_APPEND);
$code_end = microtime(true);
print_r($code_end-$code_start);