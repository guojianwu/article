<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/30
 * Time: 8:59
 */
header("content-type:text/html;charset=utf8");

header("content-type:image/png");
function randChr($len=4){
    $randArr=[];
    for ($i=0;$i<$len;$i++){
        $type=mt_rand(0,2);
        switch ($type){
            case 0:
                array_push($randArr,chr(mt_rand(48,57)));
                break;
            case 1:
                array_push($randArr,chr(mt_rand(97,122)));
                break;
            case 2:
                array_push($randArr,chr(mt_rand(65,90)));
                break;
        }

    }
    return $randArr;
}
function verifica(){

    $img=imagecreatetruecolor(150,50);
    $bgColor=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    for ($i=0;$i<4;$i++){
        $linecolor=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imageline($img, mt_rand(0,150), mt_rand(0,50),mt_rand(0,150),mt_rand(0,50),$linecolor);
    }
    for ($i=0;$i<25;$i++){
        $dotcolor=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagesetpixel($img,mt_rand(0,150),mt_rand(0,50),$dotcolor);
    }

    $str_arr=randChr(4);

    $x_start=150/count($str_arr)-15;

    foreach ($str_arr as $key){
        $fontcolor= imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagettftext($img, 30, mt_rand(-15,15), $x_start, 50/2, $fontcolor, "Fonts/Gabriola.ttf", $key);
        $x_start +=30;
    }




    imagefill($img,0,0,$bgColor);


    $data=array('verifi'=>$img,'verifi_arr'=>$str_arr);

    return $data;
}
