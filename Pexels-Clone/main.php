
<?php
require_once 'session.php';
$url =  "{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$result = str_replace("/img/","",$escaped_url);

if($result == "me" || $result == "me/" || $result == "@")
    include 'profile.php';
else if($result == "edit-profile")
    include 'edit-profile.php';
else if($result == "change-password")
    include 'change-password.php';
else if($result == "delete-account")
    include 'delete-account.php';

else if(strpos($result,"collections/") === 0){
    $j = str_replace("collections/","",$result);
    $j = substr($j,strrpos($j, "-")+1);
    $_SESSION['collection'] = $j;
    $file = "c2.php";
    include ($file);
    die();
}

else if(strpos($result,"edit-collection/") === 0){
    $j = str_replace("edit-collection/","",$result);
    $_SESSION['collection'] = $j;
    $file = "edit-c.php";
    include ($file);
    die();
}

else if($result[0] == "@" || (strpos($result,"me") > 0 || strpos($result,"collections") > 0 ) ){
    if(strpos($result,"/collections") > 0){
        $k =  substr($result,0,strpos($result,"/collections"));
        if($k != "me")
        $_SESSION['prof'] = str_replace("@","",$k);
        $file = "pc.php";
        include ($file);
        die();
    }


    $_SESSION['prof'] = str_replace("@","",$result);
    $file = "profile.php";
    include ($file);
    unset($_SESSION['prof']);
}
else if(strpos("photo/",$result) == 0){
    $result = str_replace("photo","",$result);
    $file = "photo.php";
    $_SESSION['phot'] = substr($result,strrpos($result, "-")+1 );
    include ($file);
    unset($_SESSION['phot']);
}

else
    die("error");
?>

