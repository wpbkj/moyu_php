<?php
/**
*摸鱼办提醒（PHP版）
*该文件为农历支持
*/
class Lunar{
var $MIN_YEAR=1891;
var $MAX_YEAR=2100;
var $lunarInfo=array(
array(0,2,9,21936),array(6,1,30,9656),array(0,2,17,9584),array(0,2,6,21168),
array(5,1,26,43344),array(0,2,13,59728),array(0,2,2,27296),array(3,1,22,44368),
array(0,2,10,43856),array(8,1,30,19304),array(0,2,19,19168),array(0,2,8,42352),
array(5,1,29,21096),array(0,2,16,53856),array(0,2,4,55632),array(4,1,25,27304),
array(0,2,13,22176),array(0,2,2,39632),array(2,1,22,19176),array(0,2,10,19168),
array(6,1,30,42200),array(0,2,18,42192),array(0,2,6,53840),array(5,1,26,54568),
array(0,2,14,46400),array(0,2,3,54944),array(2,1,23,38608),array(0,2,11,38320),
array(7,2,1,18872),array(0,2,20,18800),array(0,2,8,42160),array(5,1,28,45656),
array(0,2,16,27216),array(0,2,5,27968),array(4,1,24,44456),array(0,2,13,11104),
array(0,2,2,38256),array(2,1,23,18808),array(0,2,10,18800),array(6,1,30,25776),
array(0,2,17,54432),array(0,2,6,59984),array(5,1,26,27976),array(0,2,14,23248),
array(0,2,4,11104),array(3,1,24,37744),array(0,2,11,37600),array(7,1,31,51560),
array(0,2,19,51536),array(0,2,8,54432),array(6,1,27,55888),array(0,2,15,46416),
array(0,2,5,22176),array(4,1,25,43736),array(0,2,13,9680),array(0,2,2,37584),
array(2,1,22,51544),array(0,2,10,43344),array(7,1,29,46248),array(0,2,17,27808),
array(0,2,6,46416),array(5,1,27,21928),array(0,2,14,19872),array(0,2,3,42416),
array(3,1,24,21176),array(0,2,12,21168),array(8,1,31,43344),array(0,2,18,59728),
array(0,2,8,27296),array(6,1,28,44368),array(0,2,15,43856),array(0,2,5,19296),
array(4,1,25,42352),array(0,2,13,42352),array(0,2,2,21088),array(3,1,21,59696),
array(0,2,9,55632),array(7,1,30,23208),array(0,2,17,22176),array(0,2,6,38608),
array(5,1,27,19176),array(0,2,15,19152),array(0,2,3,42192),array(4,1,23,53864),
array(0,2,11,53840),array(8,1,31,54568),array(0,2,18,46400),array(0,2,7,46752),
array(6,1,28,38608),array(0,2,16,38320),array(0,2,5,18864),array(4,1,25,42168),
array(0,2,13,42160),array(10,2,2,45656),array(0,2,20,27216),array(0,2,9,27968),
array(6,1,29,44448),array(0,2,17,43872),array(0,2,6,38256),array(5,1,27,18808),
array(0,2,15,18800),array(0,2,4,25776),array(3,1,23,27216),array(0,2,10,59984),
array(8,1,31,27432),array(0,2,19,23232),array(0,2,7,43872),array(5,1,28,37736),
array(0,2,16,37600),array(0,2,5,51552),array(4,1,24,54440),array(0,2,12,54432),
array(0,2,1,55888),array(2,1,22,23208),array(0,2,9,22176),array(7,1,29,43736),
array(0,2,18,9680),array(0,2,7,37584),array(5,1,26,51544),array(0,2,14,43344),
array(0,2,3,46240),array(4,1,23,46416),array(0,2,10,44368),array(9,1,31,21928),
array(0,2,19,19360),array(0,2,8,42416),array(6,1,28,21176),array(0,2,16,21168),
array(0,2,5,43312),array(4,1,25,29864),array(0,2,12,27296),array(0,2,1,44368),
array(2,1,22,19880),array(0,2,10,19296),array(6,1,29,42352),array(0,2,17,42208),
array(0,2,6,53856),array(5,1,26,59696),array(0,2,13,54576),array(0,2,3,23200),
array(3,1,23,27472),array(0,2,11,38608),array(11,1,31,19176),array(0,2,19,19152),
array(0,2,8,42192),array(6,1,28,53848),array(0,2,15,53840),array(0,2,4,54560),
array(5,1,24,55968),array(0,2,12,46496),array(0,2,1,22224),array(2,1,22,19160),
array(0,2,10,18864),array(7,1,30,42168),array(0,2,17,42160),array(0,2,6,43600),
array(5,1,26,46376),array(0,2,14,27936),array(0,2,2,44448),array(3,1,23,21936),
array(0,2,11,37744),array(8,2,1,18808),array(0,2,19,18800),array(0,2,8,25776),
array(6,1,28,27216),array(0,2,15,59984),array(0,2,4,27424),array(4,1,24,43872),
array(0,2,12,43744),array(0,2,2,37600),array(3,1,21,51568),array(0,2,9,51552),
array(7,1,29,54440),array(0,2,17,54432),array(0,2,5,55888),array(5,1,26,23208),
array(0,2,14,22176),array(0,2,3,42704),array(4,1,23,21224),array(0,2,11,21200),
array(8,1,31,43352),array(0,2,19,43344),array(0,2,7,46240),array(6,1,27,46416),
array(0,2,15,44368),array(0,2,5,21920),array(4,1,24,42448),array(0,2,12,42416),
array(0,2,2,21168),array(3,1,22,43320),array(0,2,9,26928),array(7,1,29,29336),
array(0,2,17,27296),array(0,2,6,44368),array(5,1,26,19880),array(0,2,14,19296),
array(0,2,3,42352),array(4,1,24,21104),array(0,2,10,53856),array(8,1,30,59696),
array(0,2,18,54560),array(0,2,7,55968),array(6,1,27,27472),array(0,2,15,22224),
array(0,2,5,19168),array(4,1,25,42216),array(0,2,12,42192),array(0,2,1,53584),
array(2,1,21,55592),array(0,2,9,54560)
);

/** 
* 将阴历转换为阳历 
* @param year 阴历-年 
* @param month 阴历-月，闰月处理：例如如果当年闰五月，那么第二个五月就传六月，相当于阴历有13个月，只是有的时候第13个月的天数为0 
* @param date 阴历-日 
*/ 
function convertLunarToSolar($year,$month,$date){ 
    $yearData=$this->lunarInfo[$year-$this->MIN_YEAR];
    $between=$this->getDaysBetweenLunar($year,$month,$date);
    $res=mktime(0,0,0,$yearData[1],$yearData[2],$year);
    $res=date('Y-m-d',$res+$between*24*60*60);
    $day=explode('-',$res);
    $year=$day[0];
    $month=$day[1];
    $day=$day[2];
    return array($year,$month,$day);
}

/** 
* 获取阴历每月的天数的数组 
* @param year 
*/ 
function getLunarMonths($year){ 
    $yearData=$this->lunarInfo[$year-$this->MIN_YEAR];
    $leapMonth=$yearData[0];
    $bit=decbin($yearData[3]);
    for ($i=0;$i<strlen($bit);$i ++){
        $bitArray[$i]=substr($bit,$i,1);
    }
    for($k=0,$klen=16-count($bitArray);$k<$klen;$k++){ 
        array_unshift($bitArray,'0');
    }
    $bitArray=array_slice($bitArray,0,($leapMonth==0?12:13));
    for($i=0;$i<count($bitArray);$i++){ 
        $bitArray[$i]=$bitArray[$i] + 29;
    }
    return $bitArray;
}

/** 
* 计算阴历日期与正月初一相隔的天数 
* @param year
* @param month 
* @param date 
*/ 
function getDaysBetweenLunar($year,$month,$date){ 
    $yearMonth=$this->getLunarMonths($year);
    $res=0;
    for($i=1;$i<$month;$i++){ 
        $res+=$yearMonth[$i-1];
    }
    $res+=$date-1;
    return $res;
}
}
?>