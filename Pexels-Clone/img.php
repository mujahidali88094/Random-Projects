<?php 
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

header('Content-Type: image/jpeg');

if(isset($_GET['Original'])){
    readfile("ui/useruploads/".$_GET['pname']);
    die();
}

if(!isset($_GET['w']) || !isset($_GET['h']) ){
   // list($_GET['w'],$_GET['h']) = getimagesize("ui/useruploads/".$_GET['pname']);
    
  $filename =  "ui/useruploads/".$_GET['pname']; 
//.substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
//header('Content-Type: image/jpeg');
readfile($filename);  
die();
}

$img = resize_image("ui/useruploads/".$_GET['pname'], $_GET['w'], $_GET['h']);
if(!file_exists("ui/useruploads/".$_GET['w'].$_GET['h'].$_GET['pname']))
imagejpeg($img,"ui/useruploads/".$_GET['w'].$_GET['h'].$_GET['pname']);
readfile("ui/useruploads/".$_GET['w'].$_GET['h'].$_GET['pname']);











/*

*/
?> 