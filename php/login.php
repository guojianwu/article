<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/30
 * Time: 14:32
 */
$username=isset($_POST['username'])?$_POST['username']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$verification=isset($_POST['verification'])?$_POST['verification']:'';
$remember=isset($_POST['remember'])?$_POST['remember']:'';
$data=array('err'=>0,'msg'=>'');

if(empty($username) || empty($password)  || empty($verification)){
    $data=array('err'=>0,'msg'=>'信息不完整');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}



$login_cookie=$_COOKIE['login_verifi'];
$verifi_lower=strtolower($verification);
$verifi_lower_md5=md5($verifi_lower.'gjw');
if($login_cookie!=$verifi_lower_md5){
    $data=array('err'=>-1,'msg'=>'验证码错误');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}


include_once ('connect_mysql.php');
$link=conn('article');

$sql="select * from user where username='$username'";
$result=mysqli_query($link,$sql);
if(!$result){
    $data=array('err'=>-2,'msg'=>'登陆失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit; 
}

$result_num=mysqli_num_rows($result);

if($result_num==0){
    $data=array('err'=>-3,'msg'=>'用户名还没注册');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
$userInfo=mysqli_fetch_assoc($result);

$password_md5=md5($password.'gjw');
if($password_md5!=$userInfo['password']){
    $data=array('err'=>-4,'msg'=>'密码或用户名错误');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}


$data=array('err'=>1,'user_id'=>$userInfo['user_id'],'msg'=>'登陆成功');

if($remember==1){
    $usernae_md5=md5($userInfo['username'].'gjw');
    setcookie('username',$userInfo['username'],time()+7*24*60*60,'/');
    setcookie('token',$usernae_md5,time()+7*24*60*60,'/');
}else{
    $usernae_md5=md5($userInfo['username'].'gjw');
    setcookie('username',$userInfo['username'],0,'/');
    setcookie('token',$usernae_md5,0,'/');
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($link);























