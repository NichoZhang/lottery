<?php
$file_get_path = __DIR__.'/../../data/2003-2014.sort.txt';
$file_put_path = __DIR__.'/../../data/2003-2014.arr.php';

$contents = file_get_contents($file_get_path);

$contents_arr = explode("\n", $contents);

$per_period_arr = array();
foreach($contents_arr as $per_period_str){
    if($per_period_str != ""){
        $per_period_arr[] = explode("    ", $per_period_str);
    }
}

$balls_arr  = array();
$all_balls  = array();
foreach($per_period_arr as $key => $per_period){
    $balls_arr[]  = explode("|", $per_period[1]); 
    $all_balls[]  = explode(",", $balls_arr[$key][0]);
    array_push($all_balls[$key], $balls_arr[$key][1]);
}
file_put_contents($file_put_path, '<?php
$all_balls_arr = '.var_export($all_balls, true).';
');
