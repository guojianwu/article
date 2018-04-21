<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/2
 * Time: 15:50
 */
//var_dump($db);
$link=mysqli_connect('localhost','root','');
if(!$link){
    return '数据库连接失败';
}
mysqli_query($link,'set names utf8');
mysqli_select_db($link,'article');
$sql="select * from user order by reg_time desc limit 2,2";
//$sql_count=' SELECT COUNT(*) as count FROM publish';
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_assoc($result);
var_dump($row);$row=mysqli_fetch_assoc($result);
var_dump($row);