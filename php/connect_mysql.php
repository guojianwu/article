<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 11:04
 */

function conn($db){
    if(!isset($db)){
        return '请传入数据库';
    }
    //var_dump($db);
    $link=mysqli_connect('localhost','root','');
    if(!$link){
        return '数据库连接失败';
    }
    mysqli_query($link,'set names utf8');
    mysqli_select_db($link,$db);
    return $link;
}


//function select($link,$sql){
//    $result=mysqli_query($link,$sql);
//    return $result;
//}



