<?php
include 'session.php';
$user = "";
if(isset($_SESSION['sessUser']))
    if(!isset($_GET['user']) ||  $_GET['user'] == $_SESSION['sessUser'])
        $user = $_SESSION['sessUser'];
if(isset($_GET['user']))
    $user = $_GET['user'];
$k = $_GET['id'];
if(strrpos($k,"-") > 0)
    $k = substr($k,strrpos($k,"-")+1);
$firstName;
$lastName;
$location;
$profilePic;
$id;$views = 0;
$name;

$w;$c;$f;
$h;
$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

$usersql = "Select * From uploads Where imgid='{$k}' limit 1;";

$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


$usernoOfRows = mysqli_num_rows($userresult);


if($usernoOfRows>0){
    while($row = mysqli_fetch_assoc($userresult)) {
        $id = $row['userID'];
        $name = $row['name'];
        $w = $row['width'];
        $h = $row['height'];

    }



    if(isset($_SESSION['sessUser'])){
        if($_SESSION['sessUser'] != $id){
            $q = "INSERT into views(imgid,userid) values ({$k},{$_SESSION{'sessUser'}})";
            $r = $conn->query($q);

        }
    }

    $q = "SELECT count(*) c from views where imgid = {$k};";

    $r = $conn->query($q);

    if(mysqli_num_rows($r) > 0)
        while($rr = mysqli_fetch_assoc($r))
            $views  = $rr['c'];





    $us = "Select * From user Where userId='{$id}' limit 1;";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");


    $uR = mysqli_num_rows($ur);


    if($uR>0)
        while($row = mysqli_fetch_assoc($ur)) {
            $firstName = $row['firstName'];
            $lastName  = $row['lastName'];
            $location  = $row['location'];
            $profilePic = $row['profilePic'];

        }

    $us = "Select * From follows Where followed={$id};";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");
    $uR = mysqli_num_rows($ur);


    $f = $uR;

    $us = "Select * From likes Where imgid = {$k};";

    $ur = mysqli_query($conn,$us) or die($conn->error);
    $uR = mysqli_num_rows($ur);


    $ll = $uR;

    $us = "Select * From downloads Where imgid = {$k};";

    $ur = mysqli_query($conn,$us) or die($conn->error);
    $uR = mysqli_num_rows($ur);


    $dd = $uR;


    if(isset($_SESSION['sessUser'])){
        $us = "Select * From follows Where follower={$_SESSION['sessUser']} AND followed={$id};";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0) $c = "unfollow";
        else $c = "follow";
    }
    else
        $c = "follow";

    $l = "";
    if(isset($_SESSION['sessUser'])){
        $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$k};";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0) $l = "dislike";
        else $l = "like";
    }
    else
        $l = "like";

}
else
    die("<h1>Picture was not found or deleted!</h1>");

?>




<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/photo.css">
    <link rel="stylesheet" type="text/css" href="https://localhost/img/styles/profile.css">
    <link rel="stylesheet" type="text/css" href="https://localhost/img/styles/styles.css">
    <link type="text/css" rel="stylesheet" href="https://localhost/img/js/magiczoomplus.css"/>
    <script type="text/javascript" src="https://localhost/img/js/magiczoomplus.js"></script>

    <body class="m-4 border p-4" style="overflow:auto;height:auto;">

        <div class="d-grid">
            <nav class="navbar order1 navbar-light bg-white <?php if(isset($_GET['sticky'])) echo'sticky-top';?>">
                <span class="navbar-brand w100-768 m-0">

                    <div class="card pc d-none rounded p-2 m-auto" style="width: 280px;border:1px solid lightgray!important;">

                        <span class="navbar-brand">
                            <span class="small text-muted d-block p-3" style="font-size: 11px;font-family: system-ui;">Photographer</span>
                            <img onerror="solvePic(this)" src="https://localhost/img/<?php echo $profilePic;?>" width="60px" height="60px" style="object-fit: cover;border-radius:50%;" class="d-inline-block align-top" alt="">
                            <span>
                                <span class="p-2" style="font-weight: bold;font-size: 15px;display: inline-block;">
                                    <a class="text-decoration-none text-dark" target="_blank" href="https://localhost/img/@<?php echo $id;?>"><?php echo $firstName." ".$lastName; ?>
                                    </a>
                                    <br>
                                    <span style="font-weight:100;font-size: 13px;"><b class="F"><?php echo $f;?></b> followers . <?php echo $location;?></span>
                                </span>
                            </span>

                            <?php if((isset($_SESSION['sessUser']) && $id != $_SESSION['sessUser']) || !isset($_SESSION['sessUser']))
    echo  '<span class="btn-group p-2 d-block align-top text-start" role="group" aria-label="Basic example">
                                 <button data-user="'.$id.'" data-command="'.$c.'" class="followButton btn btn-sm m-2 button_coloured rd__button--compact '.(($c == "unfollow")?"btn-primary":"rd__button--white").'">'.(($c == "unfollow")?"Following":"Follow").'</button>
                            </span>';
                            ?>


                        </span>

                    </div>
                    <span class="pd">


                        <img onerror="solvePic(this)"  src="https://localhost/img/<?php echo $profilePic;?>" width="60px" height="60px" style="object-fit: cover;border-radius:50%;" class="d-inline-block align-top" alt="">
                        <span>
                            <span class="p-2" style="font-weight: bold;font-size: 15px;display: inline-block;">
                                <a class="text-decoration-none text-dark" target="_blank" href="https://localhost/img/@<?php echo $id;?>"><?php echo $firstName." ".$lastName; ?>
                                </a>
                                <br>
                                <span style="font-weight:100;font-size: 13px;"><b class="F"><?php echo $f;?></b> followers . <?php echo $location;?></span>
                            </span>
                        </span>

                        <?php if((isset($_SESSION['sessUser']) && $id != $_SESSION['sessUser']) || !isset($_SESSION['sessUser']))
    echo  '
                      <span class="btn-group p-2 d-inline-block align-top text-start" role="group" aria-label="Basic example">

                        <button data-user="'.$id.'" data-command="'.$c.'" class="followButton btn btn-sm m-2 button_coloured rd__button--compact '.(($c == "unfollow")?"btn-primary":"rd__button--white").'">'.(($c == "unfollow")?"Following":"Follow").'</button>
                        </span>';?>
                    </span>


                </span>
                <span class="bt1 btn-group p-2 d-inline-block align-top text-center" role="group" aria-label="Basic example">

                    <button data-imgid="<?php echo $k;?>"  data-command="<?php echo $l;?>" class="likeButton bt2 m-2 <?php echo ($l == "dislike")?'likedbutton':'dislikedbutton';?>">
                        <i class="fa fa-heart" style="font-size: 24px;"></i>
                        &nbsp;
                        <b class="L"><?php echo $ll;?> </b> &nbsp; Likes</button>


                    <button data-id="<?php echo $k; ?>" style="font-weight:lighter;" class="collectButton bt3 m-2 button_coloured rd__button--compact rd__button--white">
                        <?php 
                        $q = "SELECT *
                          FROM collections a, collection_content b
                          where a.c_id = b.c_id
                          and a.userid = {$id}
                          and b.imgid  = {$k};";
                        $r = $conn->query($q);
                        if(mysqli_num_rows($r) > 0)
                            echo "<span><i class='fa fa-plus-circle' style='font-size: 24px;'></i></span>";
                        else 
                            echo "<span><i class='fa fa-plus-circle' style='font-size: 24px;background:black;color:white;border-radius:50%;'></i></span>";

                        ?>
                        &nbsp;Collect</button>

                    <div class="btn-group bt4" style="vertical-align: baseline;">

                        <button type="button" class="bt4 rounded-start button_coloured dropdown-toggle-split rd__button--compact rounded rounded-0"><i class="fa fa-download" style="font-size:24px;visibility:hidden;"></i>
                            <a id="imageLinkModal" data-id="<?php echo $k;?>" style="color:white;text-decoration: none;" href="https://localhost/img/img.php?pname=<?php echo $name;?>" download target="_blank">Free Download</a>
                        </button>
                        <button type="button" class="button_coloured dropdown-toggle dropdown-toggle-split rounded-end p-2" style="border-left: 1px solid lightgray;" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 250px;">
                            <h4 class="head-gray">Choose a size:</h4>
                            <ul class="list-group rounded-0">
                                <li class="list-group-item p-3 border-start-0 border-end-0">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" data-type="original" class="form-check-input" data-width="<?php echo $w;?>" data-height="<?php echo $h;?>" name="optradio">Original (<?php echo $w." x ".$h; ?>)
                                        </label>
                                    </div>

                                </li>
                                <?php if($w > 3000) echo '<li class="list-group-item p-3 border-start-0 border-end-0">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" data-type="large" class="form-check-input" data-width="1920" data-height="'.ceil(1920*($w/$h)).'" name="optradio">Large (1920 x '.ceil(1920*($w/$h)).')
                                        </label>
                                    </div>

                                </li>';?>

                                <li class="list-group-item p-3 border-start-0 border-end-0">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" data-type="medium" class="form-check-input" data-width="1280" data-height="<?php echo ceil(1280*($w/$h));?>" name="optradio">Medium (1280 x <?php  echo ceil(1280*($w/$h));?> )
                                        </label>
                                    </div>

                                </li>
                                <li class="list-group-item p-3 border-start-0 border-end-0  ">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" data-type="small" class="form-check-input"  data-width="640" data-height="<?php echo ceil(640*($w/$h));?>" name="optradio">Small (640 x <?php  echo ceil(640*($w/$h));?> )
                                        </label>
                                    </div>

                                </li>
                                <li class="list-group-item p-3 border-start-0 border-end-0  ">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" id="cusTModal" disabled="" data-type="custom" class="form-check-input" name="optradio">Custom
                                        </label>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <input type="text" id="customWidthModal"  class="form-control" placeholder="Width">
                                        </div>
                                        <div class="col">
                                            <input type="text" id="customHeightModal" class="form-control" placeholder="Height">
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 ">
                                    <a id="downITModal" data-id="<?php echo $k;?>" href="" download="Image.jpg" class="button_coloured w-100 rd__button--compact"> Free Download </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </span>

            </nav>
            <div class="container-fluid">
                <div class="row align-items-center" style="min-height: 50vh;">
                    <div class="col-1 col-md-1 col-sm-1 col-lg-1 <?php if(!isset($_GET["modal"])) echo 'd-none'; ?>">  
                        <a class="btn" onclick="prevSlide()">❮</a>   
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-10 text-center m-auto">
                        <div class="photoItem profilePhotoItem py-2 position-relative text-white">
                            <img class="imgCrousel"  src="http://localhost/img/img.php?pname=<?php echo $name;?>" />

                        </div>


                    </div>
                    <div class="col-1 col-md-1 col-sm-1 col-lg-1 <?php if(!isset($_GET["modal"])) echo 'd-none'; ?>">
                        <a class="btn" onclick="nextSlide()">❯</a>
                    </div>

                </div>

            </div>
            <div class="m-3 text-center order2">
                <h6 class="bt7 text-muted d-inline small"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php if($views < 1000) echo $views;
                    else
                        echo ($views/1000.00).' k'    ?> views</h6>
                &nbsp;&nbsp;
                <h6 class="bt8 text-muted d-inline small"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Free Download</h6>
                <span class="btn-group p-2 d-block align-top text-center" role="group" aria-label="Basic example">

                    <button class="bt5 btn text-muted m-2 button_coloured rd__button--compact rd__button--white" style="font-size:14px;color: black!important;"><i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;Share</button>
                    <button class="bt6 btn text-muted  m-2 button_coloured rd__button--compact rd__button--white" style="font-size:14px;color: black!important;" data-bs-toggle="collapse" data-bs-target="#infoCollapse" aria-expanded="false" aria-controls="infoCollapse"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Info</button>
                </span>
            </div>

            <div class="w-100 collapse  order3"  id="infoCollapse">
                <div class="card-columns cc col-lg-9 col-md-12 col-sm-12 col-12 m-auto" style="column-count: 2;">

                    <div class="card w100-768 p-3 m-2 d-inline-block" style="min-width: 320px;border: 1px solid lightgray!important;">

                        <span class="navbar-brand ">
                            <span class="small text-muted d-block p-3" style="font-size: 11px;font-family: system-ui;">Photographer</span>
                            <img onerror="solvePic(this)"  src="https://localhost/img/<?php echo $profilePic;?>" width="60px" height="60px" style="object-fit: cover;border-radius:50%;" class="d-inline-block align-top" alt="">
                            <span>
                                <span class="p-2" style="font-weight: bold;font-size: 15px;display: inline-block;">
                                    <a class="text-decoration-none text-dark" target="_blank" href="https://localhost/img/@<?php echo $id;?>"><?php echo $firstName." ".$lastName; ?>
                                    </a>                                    <br>
                                    <span style="font-weight:100;font-size: 13px;"><b class="F"><?php echo $f;?></b> followers . <?php echo $location;?></span>
                                </span>
                            </span>
                            <br>
                            <span class="btn-group p-2  text-start" role="group" aria-label="Basic example">

                                <button data-user="<?php echo $id;?>" data-command="<?php echo $c;?>" class="followButton btn btn-sm m-2 button_coloured rd__button--compact rd__button--white">Follow</button>
                            </span>



                        </span>

                        <span class="small text-muted border-bottom d-block p-3" style="font-size: 9px;font-family: system-ui;">MORE PHOTOS OF <?php echo strtoupper($firstName);?></span>
                        <div id="container2" style="max-width: 280px;margin: auto!important;">
                            <div id="imglist2">

                                <?php 

                                $query = "select * from uploads where userid = ".$id;
                                $result = $conn->query($query);
                                if ($result->num_rows > 0)
                                    while($row = mysqli_fetch_assoc($result)){

                                        $kk = "SELECT tag from tags where imgid ={$row['imgID']}";
                                        $r = $conn->query($kk);
                                        $s = "";
                                        if ($r->num_rows > 0)
                                            while($ro = mysqli_fetch_assoc($r)){  
                                                $s = $s.str_replace(" ","-",$ro['tag'])."-";

                                            }
                                        $s = $s.$row['imgID'];
                                        echo'
                                    <a class="d-inline text-decoration-none" style="width:20%" href="https://localhost/img/photo-'.$s.'" target="_blank">
                                    <img  class="border shadow rounded" style="width: 70px;height: 60px;object-fit: cover;" src="https://localhost/img/img.php?pname='.$row['name'].'">
                                    </a>

                                    '; 
                                    }
                                ?>


                            </div>

                        </div>
                    </div>
                    <div class="card w100-768 p-2 m-2 d-inline-block" style="min-width: 320px;border: 1px solid lightgray!important;">
                        <span class="small text-muted d-block p-3" style="font-size: 11px;font-family: system-ui;">Statistics</span>
                        <div class="d-inline-block h2 p-3" style="color: #05a081;font-family: system-ui;"><i class="fa fa-eye align-text-top"></i><span class="h1" style="font-weight:800;">&nbsp;<?php if($views < 1000) echo $views;
                            else
                                echo ($views/1000.00).'K'    ?></span>
                            <span class="d-inline-block" style="position: absolute;color: #05a081;font-family: system-ui;right: 16px;top: 50%;">

                                <?php
                                $us = "Select userid From likes Where imgid = {$k}";
                            $ur = mysqli_query($conn,$us) or die($conn->error);

                            if(mysqli_num_rows($ur) > 0){
                                while($row = mysqli_fetch_assoc($ur)){
                                    $h = $row ['userid'];
                                    $q = "Select * from user where userid = {$h};";
                                    $r = $conn->query($q);
                                    if(!(mysqli_num_rows($r) > 0));
                                    else
                                        while($ro = mysqli_fetch_assoc($r))
                                            $pl = $ro['profilePic'];
                                    echo '<img onerror="solvePic(this)"  src="'.$pl.'" class="border border-white sl swiftLeft" style="width:26px;height: 26px;border-radius: 50%;object-fit: cover;vertical-align: super;">';
                                }
                            }

                                ?>

                            </span>

                        </div>
                        <br>
                        <div class="text-center">
                            <h6 class=" d-inline"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;
                                <?php echo $dd;?>
                            </h6>
                            &nbsp;&nbsp;
                            <h6 class=" d-inline"><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;<?php echo $ll;?></h6>
                        </div>
                    </div>



                    <div class="card p-3 m-2 w100-768 d-inline-block" style="min-width: 280px;border: 1px solid lightgray!important;">

                        <span class="small text-muted d-block p-2" style="font-size: 11px;font-family: system-ui;">PHOTO INFORMATION
                        </span>
                        <span class="p-2" style="font-weight: 700;font-size: 17px;font-family: system-ui;display: inline-block;">
                        </span>
                        <span class="small text-muted d-block p-2" style="font-size: 13px;font-family: system-ui;">Uploaded at January 04, 2018
                        </span>
                        <table class="table table-borderless">

                            <tbody>


                                <?php 
                                function get($j){
                                    $i=0;
                                    for(;$i<strlen($j);$i++){
                                        if($j[$i] == '/') {return $i;}
                                    }
                                }

                                function calculate_ratio($num_1, $num_2){

                                    for($n=$num_2; $n>1; $n--) {
                                        if(($num_1%$n) == 0 && ($num_2%$n) == 0) {
                                            $num_1=$num_1/$n;
                                            $num_2=$num_2/$n;
                                        }
                                    }
                                    return $num_1.":".$num_2;
                                }
                                //print_r(exif_read_data("img.jpg"));
                                $a =  exif_read_data("ui/useruploads/Original-".$name);
                                if(isset($a["FocalLength"])){
                                    $v = $a["FocalLength"];
                                    $Lens="";
                                    $Lens = 
                                        intval($v)/intval(substr($v,get($v)+1)) 
                                        ."mm ".$a['COMPUTED']['ApertureFNumber']." ".
                                        intval($a['ExposureTime'])/intval(substr($a['ExposureTime'],get($a['ExposureTime'])+1)) ."s ISO ".$a['ISOSpeedRatings'];
                                    if($Lens !== ""){
                                        echo '<tr>
                                    <td>Lens</td>
                                    <td>'.$Lens.'</td>
                                        </tr>';
                                    }}
                                if(isset($a["FileSize"])){
                                    $Size = 0;
                                    $Size = intval($a['FileSize'])/1024/1024;
                                    $Size=number_format((float) $Size, 2, '.', '');
                                    if($Size !== 0){
                                        echo '
                                <tr>
                                    <td>Size</td>
                                    <td>'.$Size.' MB</td>
                                </tr>
                                ';}
                                }

                                if(isset($a["ImageWidth"]) && isset($a["ImageLength"])){

                                    $Resolution =  $a['ImageWidth']."px x ".$a['ImageLength']."px";

                                    if($Resolution !== ""){
                                        echo '
                                <tr>
                                    <td>Resolution</td>
                                    <td>'.$Resolution.'</td>
                                </tr>';}
                                }

                                if(isset($a["Model"])){

                                    $camera = $a['Model'];
                                    if($camera !== ""){
                                        echo '
                                <tr>
                                    <td>Camera</td>
                                    <td>'.$camera.'</td>
                                </tr>';}
                                }
                                if(isset($a["Software"])){

                                    $Software  = $a['Software'];

                                    $software = $a['Software'];
                                    if($software !== ""){
                                        echo '
                                <tr>
                                    <td>Software</td>
                                    <td>'.$software.'</td>
                                </tr>';}

                                }
                                if(isset($a["FileDateTime"])){

                                    $takenat = date("F d, Y h:i", $a["FileDateTime"]);
                                    if($takenat !== ""){
                                        echo '
                                <tr>
                                    <td>Taken at</td>
                                    <td>'.$takenat.'</td>
                                </tr>';}
                                }
                                if(isset($a["ImageWidth"]) && isset($a["ImageLength"])){
                                    $AspectRatio =  calculate_ratio($a['ImageWidth'],$a['ImageLength']) ;
                                    if($AspectRatio !== ""){
                                        echo '
                                <tr>
                                    <td>Aspect Ratio</td>
                                    <td>'.$AspectRatio.'</td>
                                </tr>';}
                                }


                                ?> 









                            </tbody>
                        </table>
                    </div> 

                    <div class="card p-3 m-2 w100-768 d-inline-block" style="min-width: 280px;border: 1px solid lightgray!important;">

                        <span class="small text-muted d-block p-2" style="font-size: 11px;font-family: system-ui;">LICENSE
                        </span>

                        <span class="small text-muted d-block p-2" style="font-size: 13px;font-family: system-ui;">✓ Free to use.
                        </span>
                        <span class="small text-muted d-block p-2" style="font-size: 13px;font-family: system-ui;">✓ No attribution required.
                        </span>

                        <a class="small text-dark cursor d-block p-2">Learn more about the license »</a>

                    </div>

                </div>
                <div class="w-75 order3 w100-768 m-auto">
                    <button class="btn  grey but w-100 w100-768 m-auto text-center"   data-bs-toggle="collapse" data-bs-target="#infoCollapse" aria-expanded="false" aria-controls="infoCollapse"  >Hide Information</button>
                </div>
            </div>

        </div>

        <div class="container-fluid mt-5 border-top p-3">
            <h1 class="p-3">

                Similar Photos

            </h1>
            <div class="row p-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card-columns card-columns-count-3" >
                        <?php 

                        $query = "SELECT u1.*, u2.*,u.profilepic,u.firstname,u.lastname  FROM (SELECT DISTINCT t2.imgid FROM `tags` t1, `tags` t2 WHERE t1.tag = t2.tag and t1.imgid = {$k} and t2.imgid <> t1.imgid
                        UNION 
                            SELECT imgid from uploads where userid = {$id}) u1, uploads u2,user u where u1.imgid = u2.imgid and u.userid = u2.userid";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0)
                            while($row = mysqli_fetch_assoc($result)){
                                if(isset($_SESSION['sessUser'])){
                                    $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$row['imgID']};";

                                    $ur = mysqli_query($conn,$us) or die("Query Failed.");
                                    $uR = mysqli_num_rows($ur);


                                    if($uR>0) $lll = "dislike";
                                    else $lll = "like";
                                }
                                else
                                    $lll = "like";

                                $kk = "SELECT tag from tags where imgid = {$row['imgID']}";
                                $r = $conn->query($kk);
                                $s = "";
                                if ($r->num_rows > 0)
                                    while($ro = mysqli_fetch_assoc($r)){  
                                        $s = $s.$ro['tag']."-";

                                    }
                                $s = str_replace(" ","-",$s).$row['imgID'];
                                echo '
                        <div class="card " >
                             <div class="photoItem profilePhotoItem py-2 position-relative text-white">
                               <img class="imgCard" data-target="'.$s.'" src="https://localhost/img/img.php?pname='.$row['name'].'" alt="Photo Not Found">

                        <div class="bottomThings d-none w-100 align-items-center position-absolute p-3" style="bottom:0">
                            <div class="d-flex align-items-center mr-auto">
                            <div class="px-1"><img class="rounded-circle" onerror="solvePic(this)" src="https://localhost/img/'.$row['profilepic'].'" alt="dp" style="width:30px; height:30px"></div>
                            <span class="px-1"><a class="text-decoration-none" style="color:inherit;" target="_blank" href="https://localhost/img/@'.$row['userID'].'">'.$row['firstname']." ".$row['lastname'].'</a></span>
                            </div>
                            <div class="options d-flex ml-auto">
                            <a download="'.$s.'.jpg" data-id="'.$row['imgID'].'" href="https://localhost/img/img.php?pname='.$row['name'].'&Original=" class="downs anchorUnstyled px-1 fa fa-download mt-2">

                            </a>
                            <button data-id="'.$row['imgID'].'" class="collectButton btn py-0 px-1">
                            <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                            </button>
                            <button  data-imgid="'.$row['imgID'].'"  data-command="'.$lll.'" class="likeButton btn py-0 px-1" style="background:none!important;">
                            <i class="fa icoHeart '.(($lll=="dislike")?'fa-heart text-danger':'fa-heart-o text-white').'" style="font-size: 22px;margin-top: 4px;background:none!important;"></i>
                            </button>
                            </div>
                            </div>
                            </div>
                            </div>
                            ';

                            }
                        else
                            "Upload Pictures.";
                        ?>


                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            $(document).ready(function(){
                likeButtons();
                downloader();
            });

            function downloader(){
                var width,height,type,link; 
                var a = document.getElementById("profileLoadModal").querySelectorAll("input[type='radio']");
                $(a).on("click",function(){
                    link = "";
                    let s = document.getElementById("profileLoadModal").querySelector("input:checked");
                    type = s.dataset.type;
                    if(type == "custom"){
                        width = $("#customWidthModal").val();
                        height = $("#customHeightModal").val();
                    }
                    else
                    {
                        width = s.dataset.width;
                        height = s.dataset.height;
                    }

                    if(width == "" || height == "" /*|| isNan(parseInt(width)) == true || isNan(parseInt(height))*/){
                        return;
                        alert("Please Enter valid width and height.");
                    }
                    else
                        link = $("#imageLinkModal").attr("href")+"&w="+width+"&h="+height;
                    if(link != ""){
                        console.log(link);
                        $("#downITModal").attr("href",link.replace("http:","https:"));
                    }

                });    
                $("#downITModal, .downs, #imageLinkModal").on("click",function(e){
                    if($(e.target).attr("href") == "")         e.preventDefault();
                    else
                        download($(e.target).attr("data-id"));

                });       
                $("#customHeightModal,#customWidthModal").on("input",function(){
                    if($("#customHeightModal").val() != "" && $("#customWidthModal").val() != "")
                        $("#cusTModal").removeAttr("disabled").click();
                    else{
                        $("#cusTModal").attr("disabled"," ");
                        $("#downITModal").attr("href","");
                        $("#cusTModal")[0].checked = false;
                    }

                }) ;
            }



        </script>
    </body>
</html>