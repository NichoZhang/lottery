<?php
ini_set('memory_limit','1024M');
$code_start = microtime(true);
$file = dirname(__FILE__).'/../data/data_new.php';

$file_data = file_get_contents($file);
$file_data_arr_all = explode("\n",$file_data);
foreach($file_data_arr_all as $every_balls){
	$temp = rtrim($every_balls);
	$file_data_arr[] = explode(" ",$temp);
}
$arr = array();
$arr_ball = array();
$diff_arr = array(
  0 => '01',
  1 => '02',
  2 => '03',
  3 => '04',
  4 => '05',
  5 => '06',
  6 => '07',
  7 => '08',
  8 => '09',
  9 => '10',
  10 => '11',
  11 => '12',
  12 => '13',
  13 => '14',
  14 => '15',
  15 => '16',
  16 => '17',
  17 => '18',
  18 => '19',
  19 => '20',
  20 => '21',
  21 => '22',
  22 => '23',
  23 => '24',
  24 => '25',
  25 => '26',
  26 => '27',
  27 => '28',
  28 => '29',
  29 => '30',
  30 => '31',
  31 => '32',
  32 => '33',
);
$count_i = array();
$i = 0;
$red_ball_arr = array();
$result = array();
//固定7个位置
for($i;$i<7;++$i){
	$a = 0;
	//将数据进行循环，找到对应的红球在不同位置的落点
	for($a;$a<33;++$a){
		$arr[$i][$a] = array();
		$j = 0;
		foreach($file_data_arr as $key => $value_v){			
			//分割每次数据，将每期数据分割为7个落点
			//例如，当第一个位置是01号球时，其他位置出现过的号球的集合
			if(($diff_arr[$a] == $value_v[$i])){
				array_push($arr[$i][$a],$value_v[0],$value_v[1],$value_v[2],$value_v[3],$value_v[4],$value_v[5]);
				//将合集中内容去重，保证最多只剩下33个红色的球的单一个体
				$arr[$i][$a] = array_unique($arr[$i][$a]);
			}
			/*
			//因为在最外层是循环六次，BUG
			$count_a[$i+1][$a+1] = count($arr[$i][$a]);
			//计算出剩余数字的出现的次数
			$temp_count = array_count_values($arr[$i][$a]);
			//将红球进行排序，以便于观看
			ksort($temp_count);
			//将排列好的数据，进行放置，准备输出
			$count_i[$i+1][$a+1] = $temp_count;
			//每个球在每个位置出现的次数
			//例如，2号球，在第一个位置出现过46次
			$count_i[$i+1][$a+1] = array_count_values($arr[$i][$a]);
			/*
			/*
			//将合集中内容去重，保证最多只剩下33个红色的球的单一个体
			$result = array_unique($arr[$i][$a]);
			//array_diff 在处理大数组的时候时间超长，采用另外一种方式
			//但效果反而更不明显，故打算将数据整理完成转移到外部统一处理
			$red_ball_arr[$i+1][$a+1] = array_diff($diff_arr,$result);
			*/
			$red_ball_arr[$i+1][$a+1] = array_diff($diff_arr,$arr[$i][$a]);
		}
	}
}

file_put_contents(dirname(__FILE__).'\\fourth.php','<?php 
$code_start = microtime(true);
$test = '.var_export($red_ball_arr,true).';
$test2 = array();
foreach($test as $key => $value){
	foreach($value as $kk => $vv){
		if(count($vv) !== 33 && !empty($vv)){
			$test2[$key][$kk] = $vv;
		}
	}
}
file_put_contents(dirname(__FILE__).\'\\sixth.php\',\'<?php 
$test = \'.var_export($test2,true).\';\');
$code_end = microtime(true);
print_r($code_end-$code_start);
');
/*
print_r($count_a);exit;

file_put_contents(dirname(__FILE__).'\\seventh.php','<?php
$code_start = microtime(true);
//获取各个位置的每一个球的出现次数
$get_balls_num_count = '.var_export($count_i,true).';
//获取各种位置各种球的出现次数
$get_balls_count = '.var_export($count_a,true).';
//在篮球中查看其中每次出现的频率，看哪个篮球出现的频率最高
$rate = array();
foreach($get_balls_count[7] as $blue_ball => $balls_count){
	if(!empty($balls_count)){
		$rate[$blue_ball] = ($balls_count/1528)*100;
	}
}
arsort($rate);
file_put_contents(dirname(__FILE__).\'/../data/blue_balls_rate.php\',var_export($rate,true));
$code_end = microtime(true);
print_r($code_end-$code_start);
');
*/


$code_end = microtime(true);
print_r($code_end-$code_start);
