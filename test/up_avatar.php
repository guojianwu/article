<?php


header('content-type:text/html;charset=utf8');
// var_dump($_FILES);
//exit;


$allowedExts = array('gif','jpeg','jpg','png');
$username=isset($_COOKIE['username'])?$_COOKIE['username']:'';
$avatarInfo=isset($_FILES['file'])?$_FILES['file']:[];

if(empty($username)){
    $data=array('err'=>-4,'msg'=>'上传失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

if(count($avatarInfo)==0){
    $data=array('err'=>0,'msg'=>'请上传头像');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$temp=explode('.',$avatarInfo['name']);

$extension = end($temp);
$file_type=$avatarInfo['type'];

if ((($file_type=='image/gif')
    ||($file_type=='image/jpeg')
    ||($file_type=='image/jpg')
    ||($file_type=='image/png')
    &&in_array($extension, $allowedExts)))
{
    if(($avatarInfo['size']<=2048000)){
        if($avatarInfo['error']>0){
            $data=array('err'=>-3,'msg'=>'文件错误');
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            exit;
        }else{
            $filename=md5($username).'.'.$extension;
            $move=move_uploaded_file($avatarInfo['tmp_name'], '../avatar/'.$filename);
            //echo 'upload/'. $_FILES['localUrl']['name'];
//            echo $avatarInfo['tmp_name'];
//            exit;
            include_once ('connect_mysql.php');
            $link=conn('article');
            $sql ="update user set pic='$filename' WHERE  username='$username'";
            $result=mysqli_query($link,$sql);
            if(!$result){
                $data=array('err'=>-5,'msg'=>'上传失败');
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            $date=array('error'=>0,'url'=>'../avatar/'.$filename);
            echo json_encode($date);
            exit;
        }
    }else{
        $data=array('err'=>-2,'msg'=>'文件过大');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;
    }


}else{
    $data=array('err'=>-1,'msg'=>'文件格式不支持');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}


