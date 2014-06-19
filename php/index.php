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
