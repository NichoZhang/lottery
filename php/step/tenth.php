<?php
include __DIR__.'/../../data/2003-2014.arr.php';

$file_put_path = __DIR__.'/../../data/all_red_balls_count.arr.php';

foreach($all_balls_arr as $period => $balls){
    foreach($balls as $locate => $ball_num){
        if($locate == 6){
            continue;
        }
        $ball_num_arr[] = $ball_num;
    }
}

$values_count = array_count_values($ball_num_arr);
arsort($values_count);

file_put_contents($file_put_path,'<?php
$all_red_balls_count = '.var_export($values_count, true).';
');
