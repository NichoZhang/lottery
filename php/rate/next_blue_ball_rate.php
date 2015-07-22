<?php
$get_contents_file_name = dirname(__FILE__).'/../../data/2003-2014.txt';
$output_flie_name = dirname(__FILE__).'/../../data/next_blue_ball_rate.php';

$source_data            =  file_get_contents($get_contents_file_name);
$source_data_arr        = explode("\n", $source_data);
$source_data_arr_filter = array_filter($source_data_arr);

$output_data = handle_data($source_data_arr_filter);

file_put_contents($output_flie_name, var_export($output_data,true));

function handle_data($source_arr)
{/*{{{*/
    $return = array();
    $blue_balls = array();
    foreach($source_arr as $key => $value){
        $fmt_value = explode("   ",$value);
        $balls = $fmt_value[1];
        $balls_arr = explode("|",$balls);
        $red_balls = $balls_arr[0];
        $blue_balls[] = $balls_arr[1];
    }
    $all_blueball_values = array_count_values($blue_balls);
    ksort($all_blueball_values);
    $return = (blue_balls_rate($all_blueball_values, $blue_balls));

    return $return; 
}/*}}}*/

function blue_balls_rate($data, $all_blueBalls)
{/*{{{*/
    $next_blueBall = array();
    $all_blueBalls_count = count($all_blueBalls);
    foreach($all_blueBalls as $key =>  $nosort_blue_ball){
        foreach($data as $blue_ball => $ball_counts){
            if($blue_ball == $nosort_blue_ball){
                if($key + 1 == $all_blueBalls_count) break;
                $next_blueBall[$blue_ball][] = $all_blueBalls[$key+1]; 
                $next_blueBall['all'][$blue_ball] = $ball_counts;
            }
        }
    }
    ksort($next_blueBall);
    foreach($next_blueBall as $key => $value){
        if($key != 'all')
        $next_blueBall[$key] = array_count_values($value);
    }
    $return = array();
    foreach($next_blueBall as $k => $v){
        foreach($v as $kk => $vv){
            if('all' != $k)
         $return[$k][$kk] = $vv/$next_blueBall['all'][$k];
        }
    }
    foreach($return as $blue_ball => $other_ball){
        arsort($other_ball);
        $return[$blue_ball] = $other_ball;
    }
    
    return $return;
}/*}}}*/
