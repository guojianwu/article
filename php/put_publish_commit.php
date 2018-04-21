<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/2
 * Time: 13:51
 */

$pub_id=isset($_GET['pub_id'])?$_GET['pub_id']:'';
$currentPage=isset($_GET['currentpage'])?$_GET['currentpage']:1;
$pageSize=isset($_GET['pagesize'])?$_GET['pagesize']:10;


if($currentPage && $pageSize){
    $current=$pageSize*($currentPage-1);
}

if(empty($pub_id)){
    $data=array('err'=>-1,'msg'=>'缺少参数');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
include_once ('connect_mysql.php');
$link=conn('article');
//$sql="select * from pub_commit WHERE commit_pub_id='$pub_id' ORDER BY commit_time DESC ";


$sql_count=" SELECT COUNT(*) as count FROM pub_commit WHERE commit_pub_id='$pub_id'";
$pub_count=mysqli_query($link,$sql_count);
$count_arr=mysqli_fetch_assoc($pub_count);
$count=$count_arr['count'];


$sql="select commit_id,commit_pub_id,commit_name,commit_content,commit_time,pic as commit_pic from pub_commit as p left join user as u on p.commit_name =u.username where p.commit_pub_id='$pub_id' order by p.commit_time desc limit $current,$pageSize";
$result=mysqli_query($link,$sql);
if(!$result){
    $data=array('err'=>0,'msg'=>'获取评论数据失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$tmp=array();
while ($row=mysqli_fetch_assoc($result)){
    array_push($tmp,$row);
}
$data=array('count'=>$count,'commit_data'=>$tmp);
echo json_encode($data,JSON_UNESCAPED_UNICODE);