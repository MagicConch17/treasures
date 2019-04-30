<?php
$str = "模板002";
preg_match_all("/\d+/",$str,$num);
$num = $num[0][count($num[0])-1];
$new_num = sprintf("%0".(strlen($num))."d",$num+1);
$str = str_replace($num,$new_num,$str);
echo $str;