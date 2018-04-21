<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/30
 * Time: 15:53
 */

$exit=isset($_POST['exit'])?$_POST['exit']:'';

if(!empty($exit)){
    setcookie('username','',time()-10,'/');
    setcookie('token','',time()-10,'/');
    $data=array('err'=>1,'msg'=>'退出成功');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}