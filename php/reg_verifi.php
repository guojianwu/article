<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/30
 * Time: 10:59
 */

include_once ('verifica.php');
$verifi=verifica();



imagepng($verifi['verifi']);
$verifi=implode('',$verifi['verifi_arr']);
$verifi_lower=strtolower($verifi);
$verifi_str=md5($verifi_lower.'gjw');
setcookie('reg_verifi',$verifi_str);
imagedestroy($verifi['verifi']);