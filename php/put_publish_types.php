<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 14:05
 */

include_once ('connect_mysql.php');

$link=conn('article');
$sql="select * from publish_types";


$result=mysqli_query($link,$sql);
//var_dump($link);
$data=array();
while ($rows=mysqli_fetch_assoc($result)){
    array_push($data,$rows);
}

echo json_encode($data,JSON_UNESCAPED_UNICODE);

mysqli_close($link);





