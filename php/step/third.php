<?php
ini_set('memory_limit','1024M');
$code_start = microtime(true);
$file = dirname(__FILE__).'/../data/data_new.php';

$file_data = file_get_contents($file);
$file_data_arr_all = explode("\n",$file_data);
$file_data_arr_all_filter = array_filter($file_data_arr_all);
foreach($file_data_arr_all_filter as $every_balls){
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
$site_data = array();
//固定7个位置
for($i;$i<7;++$i){
	$a = 0;
	//将数据进行循环，找到对应的红球在不同位置的落点
	for($a;$a<33;++$a){
		$arr[$i][$a] = array();
		$site_data[$i][$a] = array();
		foreach($file_data_arr as $key => $value_v){			
			//分割每次数据，将每期数据分割为7个落点
			//例如，当第一个位置是01号球时，其他位置出现过的号球的集合
			if(($diff_arr[$a] == $value_v[$i])){
				array_push($arr[$i][$a],$value_v[0],$value_v[1],$value_v[2],$value_v[3],$value_v[4],$value_v[5]);
				//将合集中内容去重，保证最多只剩下33个红色的球的单一个体
				$arr[$i][$a] = array_unique($arr[$i][$a]);
				//新数据整理，将一号球位置是1的数据整理出来，类推
				$site_data[$i][$a][$key] = $value_v;
			}
			/*
			//array_diff 在处理大数组的时候时间超长，采用另外一种方式
			//但效果反而更不明显，故打算将数据整理完成转移到外部统一处理
			$red_ball_arr[$i+1][$a+1] = array_diff($diff_arr,$result);
			*/
			$red_ball_arr[$i+1][$a+1] = array_diff($diff_arr,$arr[$i][$a]);
		}
	}
}
//拆分文件
file_put_contents(dirname(__FILE__).'\\seventh'.date("Ymd").'.php','<?php
$data = '.var_export($site_data,true).';
$data_temp = array();

foreach($data as $key =>$value){
	foreach($value as $kk => $vv){
		$flag = 0;
		foreach($vv as $kkk => $vvv){
			$data_temp[$key+1][$kk+1][$kkk] = $kkk - $flag -1;
			$flag = $kkk;
		}
		if(isset($data_temp[$key+1][$kk+1])){
			arsort($data_temp[$key+1][$kk+1]);
		}
	}
}
unset($key,$value,$kk,$vv,$kkk,$vvv);
//找到最长间隔时间的期数和对应位置的号球
file_put_contents(dirname(__FILE__).\'\nineth\'.date("Ymd").\'.php\',\'<?php
$data = \'.var_export($data_temp,true).\';\');');

//算出现红篮球的概率文件
file_put_contents(dirname(__FILE__).'\eighth'.date("Ymd").'.php','<?php
$code_start = microtime(true);
$site_data = '.var_export($site_data,true).';
$keys_arr = array();
foreach($site_data as $key => $value){
	foreach($value as $kk => $vv){
		//获取该位置，该号码，出现的期数
		//在不同位置的不同号球出现的概率
		if(count(array_keys($vv))/1529*100 != 0){
			$keys_arr[$key+1][$kk+1] = count(array_keys($vv))/1529*100;
		}
	}
}
unset($key,$value,$kk,$vv);
$keys_arr_sort = array();
foreach($keys_arr as $key => $value){
	arsort($value);
	$keys_arr_sort[$key] = $value;
}
file_put_contents(dirname(__FILE__)."\\\..\\\data\\\red_balls_site_rate".date(\'Ymd\').".php",var_export($keys_arr_sort,true));
$code_end = microtime(true);
echo "\n";
print_r($code_end-$code_start);
/*
---------- php ----------
每个球在不同位置出现的过情况
array (
  1 => 22,//1号位置出现过22个球
  2 => 26,//2号位置出现过26个球
  3 => 27,//2号位置出现过27个球
  4 => 27,//4号位置出现过27个球
  5 => 26,//5号位置出现过26个球
  6 => 21,//6号位置出现过21个球
  7 => 16,//7号位置出现过26个球
);
2014年8月8日 11:27:34
到目前为止出现频率最高的号码组为
01 07 14 17 26 33 11
到目前为止出现过但出现的频率最低的号码组合为
19 28 29 5 9 11 4
*/
');

//第一个想法，将不同位置的不同球出现的所有数据展示文件
file_put_contents(dirname(__FILE__).'\\fourth'.date("Ymd").'.php','<?php 
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
file_put_contents(dirname(__FILE__).\'\\sixth\'.date("Ymd").\'.php\',\'<?php 
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
