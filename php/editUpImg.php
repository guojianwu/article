<?php

header('content-type:text/html;charset=utf8');
$allowedExts = array('gif','jpeg','jpg','png');
$temp=explode('.',$_FILES['imgFile']['name']);
$extension = end($temp);
$file_type=$_FILES['imgFile']['type'];

if ((($file_type=='image/gif')
    ||($file_type=='image/jpeg')
    ||($file_type=='image/jpg')
    ||($file_type=='image/png')
    &&in_array($extension, $allowedExts)))
{
    if(($_FILES['imgFile']['size']<512000)){
        if($_FILES['imgFile']['error']>0){
            $date=array('error'=>1,'message'=>'上传失败');
            echo json_encode($date,JSON_UNESCAPED_UNICODE);
        }else{
            $filename=time().mt_rand(0,10000000).'.'.$extension;
            move_uploaded_file($_FILES['imgFile']['tmp_name'], '../editUpImg/'.$filename);
            //echo 'upload/'. $_FILES['localUrl']['name'];
            $date=array('error'=>0,'url'=>'../editUpImg/'. $filename);
            echo json_encode($date,JSON_UNESCAPED_UNICODE);

        }
    }else{
        $date=array('error'=>1,'message'=>'文件过大');
        echo json_encode($date,JSON_UNESCAPED_UNICODE);
    }


}else{
    $date=array('error'=>1,'message'=>'非法的文件格式');
    echo json_encode($date,JSON_UNESCAPED_UNICODE);
}


