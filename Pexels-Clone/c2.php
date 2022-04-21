
<?php
require_once 'session.php';
$co = "";
if(isset($_SESSION['collection']) && $_SESSION['collection'] !== ""){
    $co = $_SESSION['collection'];

    unset($_SESSION['collection']);
}
else
    die("404");
$firstName;
$lastName;
$id;
$profilePic;
$cn;
$cd;
$cp;

$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

$usersql = "Select * From collections Where c_id='{$co}' limit 1;";

$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


$usernoOfRows = mysqli_num_rows($userresult);


if($usernoOfRows>0){
    while($row = mysqli_fetch_assoc($userresult)) {
        $id        = $row["userid"];
        $cn        = $row['c_name'];
        $cd        = $row['c_desc'];
        $cp        = $row['private'];
    }
    if(isset($_SESSION['sessUser']) && $cp ==1){
        if($id != $_SESSION['sessUser'])
            die("404");
    }
    else if($cp == 1)
        die("404");


    $us = "Select * From user Where userId='{$id}' limit 1;";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");


    $uR = mysqli_num_rows($ur);


    if($uR>0){
        while($ro = mysqli_fetch_assoc($ur)) {
            $id        = $ro["userId"];
            $firstName = $ro['firstName'];
            $lastName  = $ro['lastName'];
            $profilePic = $ro['profilePic'];
        }


    }
    else
        die("<h1>User not found!</h1>");



    if(isset($_SESSION['sessUser'])){
        $us = "Select * From follows Where follower={$_SESSION['sessUser']} AND followed={$id};";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0) $c = "unfollow";
        else $c = "follow";
    }
    else
        $c = "follow";   

}
else
    die("<h1>User not found!</h1>");

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://localhost/img/styles/bootstrap.min.css" class="stylesheet">
        <link rel="stylesheet" href="https://localhost/img/styles/profile.css" class="stylesheet">
        <link rel="stylesheet" href="https://localhost/img/styles/styles.css" class="stylesheet">
        <link rel="stylesheet" href="https://localhost/img/styles/photo.css" class="stylesheet">

        <script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
        <script type="text/javascript">

        </script>
    </head>
    <body style="overflow: auto;">
        <div class="container-fluid">

            <div class="row p-3">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-2 d-flex justify-content-end align-items-center border-bottom">
                    <div class="px-1 ml-auto">
                        <a class="logo" href="#">
                            <svg xmlns="https://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 32 32">
                                <path d="M2 0h28a2 2 0 0 1 2 2v28a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" fill="#05A081"></path>
                                <path d="M13 21h3.863v-3.752h1.167a3.124 3.124 0 1 0 0-6.248H13v10zm5.863 2H11V9h7.03a5.124 5.124 0 0 1 .833 10.18V23z" fill="#fff"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="px-1 mr-auto">Pexels</div>
                </div>

                <div class="col-12 text-center mt-5 pb-2">

                    <h1 class="font-weight-bolder"><?php echo $cn;?></h1>
                    <?php echo ($cd !== "")?'<h3 class="font-weight-bold">'.$cd.'</h3>':"";?>

                    <span class="text-muted">
                        <?php

                        $query = "select * from collection_content where c_id ='{$co}'";
                        $result = $conn->query($query);
                        echo $result->num_rows;
                        ?>
                        photos collected by&nbsp;&nbsp;<a href="https://localhost/img/@<?php echo $id;?>" class="text-muted"><img id="dp" onerror="this.onerror=null;this.src='photos/cat.jpg';" class="ml-md-auto" style="object-fit: cover;width: 24px; height: 24px;border-radius: 50%;vertical-align:top;" src="https://localhost/img/<?php echo $profilePic;?>" alt="dp">
                        <?php echo $firstName." ".$lastName;?></a>
                        <?php 
                        if(isset($_SESSION['sessUser'])){
                            if($id == $_SESSION['sessUser'])
                            {
                        ?>
                        — 
                        <a href="https://localhost/img/edit-collection/<?php echo $co;?>" class="text-muted"><i class="fa fa-pen mr-1"></i><span class="text-decoration-underline">Edit</span></a>
                        <?php 

                            }
                        }
                        ?>
                    </span>

                </div>

                <div class="row border-top p-4">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card-columns text-center card-columns-count-3">
                            <?php 
                            $query = "select * from collection_content where c_id ='{$co}'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0)
                                while($row = mysqli_fetch_assoc($result)){
                                    if(isset($_SESSION['sessUser'])){

                                        $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$row['imgid']};";

                                        $ur = mysqli_query($conn,$us) or die("Query Failed.");
                                        $uR = mysqli_num_rows($ur);


                                        if($uR>0) $lll = "dislike";
                                        else $lll = "like";
                                    }
                                    else
                                        $lll = "like";
                                    $q = "select * from uploads where imgid ={$row['imgid']}";
                                    $r = $conn->query($q);
                                    if ($r->num_rows > 0)
                                        while($ro = mysqli_fetch_assoc($r)){
                                            $k = "SELECT tag from tags where imgid = {$ro['imgID']}";
                                            $rr = $conn->query($k);
                                            $s = "";
                                            if ($rr->num_rows > 0)
                                                while($rro = mysqli_fetch_assoc($rr)){  
                                                    $s = $s.$rro['tag']."-";
                                                }
                                            $s = $s.$ro['imgID'];
                                            echo '
                        <div class="card " >
                             <div class="photoItem profilePhotoItem py-2 position-relative text-white">
                               <img class="imgCard" data-target="'.$s.'" src="https://localhost/img/img.php?pname='.$ro['name'].'" alt="Photo Not Found">

                                <div class="bottomThings d-none w-100 align-items-center position-absolute p-3" style="bottom:0">
                                    <div class="d-flex align-items-center mr-auto">
                                        <div class="px-1"><img class="rounded-circle" onerror="solvePic(this)" src="https://localhost/img/'.$profilePic.'" alt="dp" style="width:30px; height:30px"></div>
                                        <span class="px-1"><a class="text-decoration-none" style="color:inherit;" target="_blank" href="https://localhost/img/@'.$id.'">'.$firstName." ".$lastName.'</a></span>
                                    </div>
                                    <div class="options d-flex ml-auto">
                                        <a download="'.$s.'.jpg" data-id="'.$ro['imgID'].'" href="https://localhost/img/img.php?pname='.$ro['name'].'&Original=" class="downs anchorUnstyled px-1 fa fa-download mt-2">

                                    </a>
                                        <button data-id="'.$ro['imgID'].'" class="collectButton btn py-0 px-1">
                                            <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                                        </button>
                                        <button  data-imgid="'.$ro['imgID'].'"  data-command="'.$lll.'" class="likeButton btn py-0 px-1" style="background:none!important;">
                                            <i class="fa   icoHeart '.(($lll=="dislike")?'fa-heart text-danger':'fa-heart-o text-white').'" style="font-size: 22px;margin-top: 4px;background:none!important;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       ';

                                        }
                                }
                            else
                                "Upload Pictures.";
                            ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen p-5">
                <div class="modal-content rounded">
                    <span class="position-absolute rounded-top" style="cursor: pointer;color: black!important;right: 0px;z-index: 1050;top: -25px;font-size: 17px;width: 25px;text-align: center;height: 25px;background: white;" onclick="closeModal()">X</span>
                    <div class="modal-body" id="profileLoadModal" style="scroll-behavior:smooth ;">

                    </div>
                </div>
            </div>
        </div>

        <?php include 'u.php'; ?>


        <script src="https://localhost/img/js/collection.js">

        </script>


    </body>
</html>