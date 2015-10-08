<?php
include __DIR__.'/../../data/2003-2014.arr.php';

$eg = "$argv[1] $argv[2] $argv[3] $argv[4] $argv[5] $argv[6] $argv[7] ";
print_r(handle_data($all_balls_arr, $eg));

function handle_data($all_balls_arr, $eg, $flag = true)
{
	$result = '';
	//初始化一等奖数量
	$first_prize = 0;
	$first_prize_str = "";
	//初始化二等奖数量
	$second_prize = 0;
	$second_prize_str = "";
	//初始化三等奖数量
	$third_prize = 0;
	$third_prize_str = "";
	//初始化四等奖数量
	$fourth_prize = 0;
	$fourth_prize_str = "";
	//初始化五等奖数量
	$fifth_prize = 0;
	$fifth_prize_str = "";
	//初始化六等奖数量
	$sixth_prize = 0;
	$sixth_prize_str = "";

    foreach($all_balls_arr as $each_period){
        $each_source_data = implode($each_period, ',');
        $each_red_balls = array_slice($each_period, 0, 6);
        $each_blue_ball = array_slice($each_period, -1);
		//分割欲求数字
		$eg_arr = explode(" ", $eg);
		//初始化欲求数字在已知数据前六个中的出现次数
		$n = 0;
		//初始化欲求数字中第七个数字出现的次数
		$m = 0;
		//循环开始
		for($i = 0; $i < 7; ++$i){
			//判断前六位中是否出现，并记录到出现次数中
			if($i < 6){
				if(in_array($eg_arr[$i], $each_red_balls)){
					$n++;
				}
			}else{
				if($each_blue_ball[0] == $eg_arr[$i]){
					$m++;
				}
			}
		}
		//一等奖 6+1
		if($n == 6 && $m == 1){
			$first_prize++;
			$first_prize_str .= $each_source_data;
		}
		//二等奖 6+0
		if($n == 6 && $m == 0){
			$second_prize++;
			$second_prize_str .= $each_source_data;
		}
		//三等奖 5+1
		if($n == 5 && $m == 1){
			$third_prize++;
			$third_prize_str .= $each_source_data;
		}
		//四等奖 5+0/4+1
		if($n == 5 && $m == 0 || $n == 4 && $m == 1){
			$fourth_prize++;
			$fourth_prize_str .= $each_source_data;
		}
		//五等奖 4+0/3+1
		if($n == 4 && $m == 0 || $n == 3 && $m == 1){
			$fifth_prize++;
			$fifth_prize_str .= $each_source_data;
		}
		//六等奖 2+1/1+1/0+1
		if($n == 2 && $m == 1 || $n == 1 && $m == 1 || $n == 0 && $m == 1){
			$sixth_prize++;
			$sixth_prize_str .= $each_source_data;
		}
    }
	if($flag){
		$result = '一等奖 '.$first_prize.' 次；二等奖 '.$second_prize.' 次；三等奖 '.$third_prize.' 次；四等奖 '.$fourth_prize.' 次；五等奖 '.$fifth_prize.' 次;六等奖 '.$sixth_prize.' 次。';
	}else{
		$result = '一等奖 '.$first_prize.' 次；
期数为
'.$first_prize_str.';
二等奖 '.$second_prize.' 次；
期数为
'.$second_prize_str.';
三等奖 '.$third_prize.' 次；
期数为
'.$third_prize_str.';
四等奖 '.$fourth_prize.' 次；
期数为
'.$fourth_prize_str.';
五等奖 '.$fifth_prize.' 次;
期数为
'.$fifth_prize_str.';
六等奖 '.$sixth_prize.' 次;
期数为
'.$sixth_prize_str.'。';
	}
	return $result;
}
