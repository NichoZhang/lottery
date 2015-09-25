<?php
//自动追加数据
$file = __DIR__. '/../../data/2003-2014.sort.txt';

$get_last_period  = getLastPeriod($file);
$period_arr       = getNowPeriod($get_last_period);
$begin_period_arr = each($period_arr);
$end_period_arr   = array_slice($period_arr, -1, count($period_arr), true);
$each_end_period  = each($end_period_arr);

$begin_period = $begin_period_arr['key'];
$end_period   = $each_end_period['key'];

if (($end_period - $begin_period) <= 0) {
    return;
}

$url = 'http://trend.caipiao.163.com/ssq/?beginPeriod='
    . $begin_period
    . '&endPeriod='
    . $end_period;

$contents = file_get_contents($url);
$pattern = '#class="ball_[^"].*?".*?\s>(\d{2})<\/td>#';

preg_match_all($pattern, $contents, $ball_str);

$chunk_periods = array_chunk($ball_str[1], 7);

$per_period_str = '';
foreach ($chunk_periods as $per_period_arr) {
    $red_balls = array_slice($per_period_arr, 0, 6);

    $per_period_str .= $begin_period . '    ';
    $per_period_str .= implode(',', $red_balls);
    $per_period_str .= '|' . $per_period_arr[6] . "    ";
    $per_period_str .= $period_arr[$begin_period]."\n";

    $begin_period++;
}

file_put_contents($file, $per_period_str, FILE_APPEND);
//将原来的文件进行倒序
//nl 2003-2014.txt | sort -nr | cut -f2 > 2003-2014.sort.txt
//现在是当前年份的第几天 除 7 得到到目前多少周，
//每周 3 期，所以乘 3，得到最近的期数
function getNowPeriod($last_period_day_arr)
{/*{{{*/
    $last_period_day = $last_period_day_arr[2];
    $last_period     = $last_period_day_arr[0];
    $open_day = array("2","4","7");

    $last_date_z = date("z", strtotime($last_period_day));
    $date_z = date("z");
    $days = $date_z - $last_date_z;

    //新年的第一天是周几
//    $new_year_weekday = date("N",strtotime(date("Y")."-01-01"));
    //最后一次更新是周几
    $last_period_weekday = date("N", strtotime($last_period_day));

    //不可以连续更新
    if(in_array($last_period_weekday, $open_day) && $days == 1){
        return 0;
    }

    $cycles_num = floor(($date_z - $last_date_z)/7);

    //过多的时间进行分割
    $miss_cycle = 0;
    switch ($days % 7){/*{{{*/
    case 1:
        if($last_period_weekday == 2){
            $miss_cycle = 1;
        }
        break;
    case 2:
        if($last_period_weekday == 2){
            $miss_cycle = 0;
        }
        break;
    case 3:
        if($last_period_weekday == 4){
            $miss_cycle = 0;
        }else{
            $miss_cycle = 1;
        }
        break;
    case 4:
        $miss_cycle = 1;
        break;
    case 5:
        if($last_period_weekday == 7){
            $miss_cycle = 2;
        }else{
            $miss_cycle = 1;
        }
        break;
    case 6:
        $miss_cycle = 2;
        break;
    default:
        $miss_cycle = 0;
        break;
    }/*}}}*/

    $now_period = 0;
    switch ($last_period_weekday) {/*{{{*/
    case 2:
        $tmp_num     = 1;
        $tmp_days    = 2;
        break;
    case 4:
        $tmp_num     = 3;
        $tmp_days    = 3;
        break;
    case 7:
        $tmp_num     = 2;
        $tmp_days    = 2;
        break;
    }/*}}}*/

    $product    = 0;
    $now_period = array();

    for ($i = 0; $i < ($cycles_num * 3 + $miss_cycle); $i ++) {
        if ($i == $tmp_num) {
            $tmp_num = $i + 3;
            $product++;
        }
        $days_num                 = (2 * $i) + $tmp_days + $product;
        $periods_num              = $last_period + $i + 1;
        $now_period[$periods_num] = date("Y-m-d",strtotime("$last_period_day +$days_num day"));
    }

    return $now_period;
}/*}}}*/

//从已经得到的数据中获取最后一次的期数
function getLastPeriod($file)
{/*{{{*/
    $fp = fopen($file, 'r');
    while ($buf = fgets($fp)) {
        $res = $buf;
    }
    fclose($fp);
    $last_period_arr = explode("    ", $res);
    return $last_period_arr;
}/*}}}*/

function getPeriodDate($period_num)
{/*{{{*/
    $period_date = '';
    $date_w = date("N");
    switch ($date_w) {
    case '7':
        case '1':
            $period_date = date("Y-m-d", strtotime("-$period_num Sunday"));
            break;
        case '2':
            case '3':
                $period_date = date("Y-m-d", strtotime("-$period_num Tuesday"));
                break;
            case '4':
                case '5':
                    case '6':
                        $period_date = date("Y-m-d", strtotime("-$period_num Thursday"));
                        break;
    }
    return $period_date;
}/*}}}*/
