
<?php
require_once 'session.php';
$user = "";
if(isset($_SESSION['sessUser']))
    if(!isset($_GET['user']) ||  $_GET['user'] == $_SESSION['sessUser'])
        $user = $_SESSION['sessUser'];
if(isset($_GET['user']))
    $user = $_GET['user'];
if(isset($_SESSION['prof'])){
    $user = $_SESSION['prof'];
    unset($_SESSION['prof']);
}
$firstName;
$lastName;
$email;
$id;
$shortBio;
$webLink;
$instagram;
$twitter;
$location;
$profilePic;
$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

$usersql = "Select * From user Where userId='{$user}' limit 1;";

$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


$usernoOfRows = mysqli_num_rows($userresult);


if($usernoOfRows>0){
    while($row = mysqli_fetch_assoc($userresult)) {
        $id        = $row["userId"];
        $firstName = $row['firstName'];
        $lastName  = $row['lastName'];
        $email     = $row['email'];
        $shortBio  = $row['shortBio'];
        $webLink   = $row['webLink'];
        $instagram = $row['instagram'];
        $twitter   = $row['twitter'];
        $location  = $row['location'];
        $profilePic = $row['profilePic'];
    }


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

                <div class="col-lg-8 col-12 col-sm-12 col-md-12 m-auto">
                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="imgWrapper d-flex">
                                <img id="dp" onerror="this.onerror=null;this.src='https://localhost/img/photos/userpic.png';" class="ml-md-auto" style="object-fit: cover;width: 120px; height: 120px;border-radius: 50%;" src="https://localhost/img/<?php echo $profilePic;?>" alt="dp">
                            </div>
                        </div>
                        <div class="col-md-9" id="infoTextArea">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                                    <h1 class="d-inline mr-2" style="font-size: 36px;font-weight: 700;"><?php echo $firstName." ".$lastName;?></h1>

                                </div>

                            </div>

                            <div id="links" class="mt-2 small">
                                <?php 
                                if($location != "")
                                    echo '<span class="mr-2 p-2" style="padding-left: 0px!important;"><i class="fa fa-map-marker p-2" aria-hidden="true" style="padding-left: 0.2rem!important;"></i>'.$location.'</span>';
                                if($instagram != "")
                                    echo '<span class="mr-2 p-2"><i class="fa fa-instagram p-2" aria-hidden="true"></i><a class="link link-secondary" href="https://instagram.com/'.$instagram.'" style="color:black;">'.$instagram.'</a></span>';
                                if($twitter != "")
                                    echo '<span class="mr-2 p-2"><i class="fa fa-twitter p-2" aria-hidden="true"></i><a class="link link-secondary" href="https://twitter.com/'.$twitter.'" style="color:black;">'.$twitter.'</a></span>';
                                if($webLink != "")
                                    echo '<span class="p-2 d-inline-block"><i class="fa fa-link p-2" aria-hidden="true"></i><a class="link link-secondary" style="color:black;" href="'.$webLink.'">'.$webLink.'</a></span>';
                                echo "</div>";
                                if($shortBio != "")
                                    echo "<p class='my-3'>".$shortBio."</p>";

                                ?>

                            </div>


                        </div>
                    </div>
                </div>


            </div>

        </div>

<div class="navbar">
<span class="navbar-brand p-4">
       <a href="https://localhost/img/<?php echo (($id=="me")?"":"@").$id;?>" class="border-primary h6 p-3 text-dark text-decoration-none" style="cursor:pointer;">Photos</a>
        <a  class=" border-bottom border-primary h6 p-3 text-primary" style="cursor:pointer;">Collections</a>

    
</span>    
    
    
    
</div>
        <div class="container-fluid border border-top">
            <div class="row p-4">
                <?php 
                $q = "Select * from collections where userid = {$id}";
                $r = mysqli_query($conn,$q) or die("1");
                if(mysqli_num_rows($r) > 0){
                    while($row = mysqli_fetch_assoc($r)){
                        if(isset($_SESSION['sessUser']) && $row['private'] == 1){
                            if($id != $_SESSION['sessUser'])
                                continue;
                        }
                        else if(!isset($_SESSION['sessUser']) && $row['private'] == 1){
                                continue;
                        }
                        $images = array();
                        $images[0] = "";$images[1] = "";$images[2] = "";$images[3] = "";$images[4] = "";                      
                        $cc = $row['c_id'];
                        $cn = $row['c_name'];
                        $qq = "Select * from collection_content where c_id = '{$cc}' ORDER BY id DESC Limit 5";
                        $rr = mysqli_query($conn,$qq) or die("2");

                        $countc = mysqli_num_rows($rr);
                        $i = 0;
                        while($rower = mysqli_fetch_assoc($rr)){
                            //$images[$i++] = $rower['imgid'];
                            $qqq = "Select name from uploads where imgid = {$rower['imgid']} LIMIT 1;";
                            $rrr = mysqli_query($conn,$qqq) or die("3");
                            while($ro = mysqli_fetch_assoc($rrr)){
                                $images[$i++] = $ro['name'];
                            }
                        }
                        
                        echo
                            '<a href="https://localhost/img/collections/'.str_replace(' ','-',$cn).'-'.$cc.'" class="d-block col-12 col-sm-12 col-md-4 col-lg-4 text-decoration-none text-dark">
                                    <div class="p-2 p-22 m-1 border rounded-lg cursor">
				                        <div class="collectionImagesWrapper">
					                       <div class="bigImage mb-1">
                                           <div class="imgWrapper"><img src="'.(($images[0] == "")?"https://localhost/img/photos/camera.png":"https://localhost/img/img.php?pname=".$images[0]).'"></div>
                                    </div>
                                        <div class="imagesGroup d-flex mb-3">
                                        <div class="imgWrapper pr-1"><img src="'.(($images[1] == "")?"https://localhost/img/photos/camera.png":"https://localhost/img/img.php?pname=".$images[1]).'"></div>
                                        <div class="imgWrapper pr-1"><img src="'.(($images[2] == "")?"https://localhost/img/photos/camera.png":"https://localhost/img/img.php?pname=".$images[2]).'"></div>
                                        <div class="imgWrapper pr-1"><img src="'.(($images[3] == "")?"https://localhost/img/photos/camera.png":"https://localhost/img/img.php?pname=".$images[3]).'"></div>
                                        <div class="imgWrapper"><img src="'.(($images[4] == "")?"https://localhost/img/photos/camera.png":"https://localhost/img/img.php?pname=".$images[4]).'"></div>
                                        </div>
                                        </div>
                                        <div class="d-flex px-2 align-items-baseline">
                                        <span class="mr-auto h2 font-weight-light">'.$cn.'</span>
                                        <span class="ml-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"></path></svg>
                                        <span h6>'.$countc.'</span>
                                        </span>
                                        </div>
                                        </div>
                                        </a>';





                    }




                }

                ?>





            </div>



        </div>





    </body>
</html>