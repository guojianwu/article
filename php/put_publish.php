<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 15:22
 */

include_once ('connect_mysql.php');
$link=conn('article');

$pub_id=isset($_GET['pub_id'])?$_GET['pub_id']:'';
$pub_name=isset($_GET['pub_name'])?$_GET['pub_name']:'';
$pub_type=isset($_GET['pub_type'])?$_GET['pub_type']:'';
$token=isset($_GET['token'])?$_GET['token']:'';
$currentPage=isset($_GET['currentpage'])?$_GET['currentpage']:1;
$pageSize=isset($_GET['pagesize'])?$_GET['pagesize']:10;


if($currentPage && $pageSize){
    $current=$pageSize*($currentPage-1);
}

if(!empty($pub_id)){
    $sql="select p.pub_id,p.pub_name,p.pub_title,p.pub_type,p.pub_content,p.pub_privacy,p.pub_time,u.user_id,u.username,u.pic from publish as p LEFT JOIN user as u on p.pub_name=u.username WHERE p.pub_id='$pub_id'order by p.pub_time desc limit $current,$pageSize";
    $sql_count=" SELECT COUNT(*) as count FROM publish WHERE pub_id='$pub_id'";
}else if(!empty($pub_name)){
    $sql_token="select user_id,username,pic from user WHERE username='$pub_name'";
    $result=mysqli_query($link,$sql_token);
    $row=mysqli_num_rows($result);
    $user_md5=md5($pub_name.'gjw');
    if($row!=0 && $user_md5==$token){
        $sql="select * from publish WHERE pub_name='$pub_name' order by pub_time desc limit $current,$pageSize";
        $sql_count=" SELECT COUNT(*) as count FROM publish WHERE pub_name='$pub_name'";
    }else{
        $sql="select p.pub_id,p.pub_name,p.pub_title,p.pub_type,p.pub_content,p.pub_privacy,p.pub_time,u.user_id,u.username,u.pic from publish as p LEFT JOIN user as u on p.pub_name=u.username WHERE p.pub_name='$pub_name' AND p.pub_privacy = 1 order by p.pub_time desc limit $current,$pageSize";
        $sql_count=" SELECT COUNT(*) as count FROM publish WHERE pub_name='$pub_name' AND pub_privacy = 1";
    }

}else if(!empty($pub_type)){
//    $sql="select * from publish as p WHERE pub_type='$pub_type'AND pub_privacy = 1 order by pub_time desc limit $current,$pageSize";
    $sql="select p.pub_id,p.pub_name,p.pub_title,p.pub_type,p.pub_content,p.pub_privacy,p.pub_time,u.user_id,u.username,u.pic from publish as p LEFT JOIN user as u on p.pub_name=u.username WHERE p.pub_type='$pub_type'AND p.pub_privacy = 1 order by p.pub_time desc limit $current,$pageSize";
    $sql_count=" SELECT COUNT(*) as count FROM publish WHERE pub_type='$pub_type' AND pub_privacy = 1";
}else{
    $sql="select p.pub_id,p.pub_name,p.pub_title,p.pub_type,p.pub_content,p.pub_privacy,p.pub_time,u.user_id,u.username,u.pic from publish as p LEFT JOIN user as u on p.pub_name=u.username WHERE p.pub_privacy = 1 order by p.pub_time desc limit $current,$pageSize";
    $sql_count=' SELECT COUNT(*) as count FROM publish WHERE pub_privacy = 1';
}


$pub_count=mysqli_query($link,$sql_count);
$count_arr=mysqli_fetch_assoc($pub_count);
$count=$count_arr['count'];

$result=mysqli_query($link,$sql);


//$pub_content1=html_entity_decode($pub_content);
//$pub_num=mysqli_num_rows($result);
$tmp=array();
while ($rows=mysqli_fetch_assoc($result)){
    $rows['pub_content']=html_entity_decode($rows['pub_content']);
    array_push($tmp,$rows);
}
$data=array('count'=>$count,'publish'=>$tmp);
echo json_encode($data,JSON_UNESCAPED_UNICODE);

