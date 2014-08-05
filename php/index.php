<?php
$file = dirname(__FILE__).'/../data/data.php';

$url = 'http://zx.caipiao.163.com/trend/ssq_basic.html?beginPeriod=2014002&endPeriod=2015060&historyPeriod=2014053&year=';
$contents = file_get_contents($url);
$regexRed = "/.*?<td class=\"chartBall\s*(.*?)\s*<\/td>.*?/";
$regexBlue = "/.*?<td class=\"chartBall02\">\s*(.*?)\s*<\/td>.*?/";
preg_match_all($regexRed,$contents,$str1);
preg_match_all($regexBlue,$contents,$str2);
$str = '';
foreach($str1[1] as $redball){
	$str .=substr($redball,-2).'  ';
}
file_put_contents($file,$str);
exit;

$contents = file_get_contents($file);
$nums = explode('  ',$contents);
$str = '';
$temp = array();
$i = '1';
foreach($nums as $key=> $ball){
	if($key!= 0 && $key%7 == 0){ 
		echo "<br>";
		$i++;
	}
	echo $ball.' ';
}
print_r($i);
$a = 0;
for($a;$a<$i-1;$a++){
	$temp[$a] = array($nums[$a*7],$nums[$a*7+1],$nums[$a*7+2],$nums[$a*7+3],$nums[$a*7+4],$nums[$a*7+5],$nums[$a*7+6]);
}
$t = array();
foreach($nums as $key=>$b){
	if(($key+1)%7 == 0) continue;
	if($b != '')
		$t[] = $b;
}
$k = array_count_values ($t);
ksort($k);
var_dump($k);
array_multisort($k,SORT_ASC,SORT_REGULAR);
var_dump($k);


function detect_encoding($str){
    $len = strlen($str);
    $encoding = "utf8";
    $is_utf8_chinese = false;
    for ($i = 0; $i < $len; $i++) { 
        if ( (ord($str[$i]) >> 7) > 0 ) { //非ascii字符
            if (ord($str[$i]) <= 191 ) {
                $encoding = "gbk0";
                break;
            } else if ( ord($str[$i]) <= 223 ) { //前两位为11
                if ( empty($str[$i+1]) or  ord($str[$i+1]) >> 6 != 2 ) { //紧跟后两位为10
                    $encoding = "gbk1";
                    break;
                } else {
                    $i += 1;
                }
            } else if ( ord($str[$i]) <= 239 ) { //前三位为111
                if ( empty($str[$i+1]) or  ord($str[$i+1]) >> 6 != 2 or empty($str[$i+2]) or  ord($str[$i+2]) >> 6 != 2) { //紧跟后两位为10
                    $encoding = "gbk2";
                    break;
                } else {
                    $i += 2;
                    $is_utf8_chinese = true;
                }
            } else if ( ord($str[$i]) <= 247 ) { //前四位为1111
                if ( empty($str[$i+1]) or  ord($str[$i+1]) >> 6 != 2 or empty($str[$i+2]) or  ord($str[$i+2]) >> 6 != 2 or empty($str[$i+3]) or  ord($str[$i+3]) >> 6 != 2) { //紧跟后两位为10
                    $encoding = "gbk3";
                    break;
                } else {
                    $i += 3;
                }
            } else if ( ord($str[$i]) <= 251 ) { //前五位为11111
                if ( empty($str[$i+1]) or  ord($str[$i+1]) >> 6 != 2 or empty($str[$i+2]) or  ord($str[$i+2]) >> 6 != 2 or empty($str[$i+3]) or  ord($str[$i+3]) >> 6 != 2 or empty($str[$i+4]) or  ord($str[$i+4]) >> 6 != 2) { //紧跟后两位为10
                    $encoding = "gbk4";
                    break;
                } else {
                    $i += 4;
                }
            } else if ( ord($str[$i]) <= 253 ) { //前六位为111111
                if ( empty($str[$i+1]) or  ord($str[$i+1]) >> 6 != 2 or empty($str[$i+2]) or  ord($str[$i+2]) >> 6 != 2 or empty($str[$i+3]) or  ord($str[$i+3]) >> 6 != 2 or empty($str[$i+4]) or  ord($str[$i+4]) >> 6 != 2 or empty($str[$i+5]) or  ord($str[$i+5]) >> 6 != 2 ) { //紧跟后两位为10
                    $encoding = "gbk5";
                    break;
                } else {
                    $i += 5;
                }
            } else {
                $encoding = "gbk6";
                break;
            }
        }
    }
 
    if ($is_utf8_chinese == false){
        $encoding = "gbk10";
    }
    if ($encoding == "utf8" && preg_match("/^[".chr(0xa1)."-".chr(0xff)."\x20-\x7f]+$/", $str) && !preg_match("/^[\x{4e00}-\x{9fa5}\x20-\x7f]+$/u", $str)) {
        $encoding = "gbk7";
    }
    //echo $encoding;
    if ($encoding == "utf8") {
        //echo "utf8";
        return ($str == "鏈條" || $str == "瑷媄")? $str: mb_convert_encoding($str, "gbk", "utf8");
    } else {
        //echo "gbk";
        return $str;
    }
}