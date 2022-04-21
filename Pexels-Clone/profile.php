
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
        <link rel="stylesheet" href="styles/bootstrap.min.css" class="stylesheet">
        <link rel="stylesheet" href="styles/profile.css" class="stylesheet">
        <link rel="stylesheet" href="styles/styles.css" class="stylesheet">
        <link rel="stylesheet" href="styles/photo.css" class="stylesheet">

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
                        
                <?php 
                if(isset($_SESSION['collectionDeleted']))
                    if($_SESSION['collectionDeleted'])
                        echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice"> Collection was deleted successfully.</div>
			</div>';
                $_SESSION['collectionDeleted'] = 0;
                if(isset($_SESSION['collectionUpdated']))
                    if($_SESSION['collectionUpdated'])
                        echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice"> Collection was updated successfully.</div>
			</div>';
                $_SESSION['collectionUpdated'] = 0;
                if(isset($_SESSION['profileUpdated']))
                    if($_SESSION['profileUpdated'])
                        echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice"> Profile was updated successfully.</div>
			</div>';
                $_SESSION['profileUpdated'] = 0;
                if(isset($_SESSION['passUpdated']))
                    if($_SESSION['passUpdated'])
                        echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice">Password was updated successfully.</div>
			</div>';
                $_SESSION['passUpdated'] = 0;
                if(isset($_SESSION['imgUploadtext']))
                    if($_SESSION['imgUploadtext'] != "")
                        echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice"> '.$_SESSION['imgUploadtext'].'</div>
			</div>';
                $_SESSION['imgUploadtext'] = "";
                ?>
                <div class="col-lg-8 col-12 col-sm-12 col-md-12 m-auto">
                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="imgWrapper d-flex">
                                <img id="dp"  onerror="this.onerror=null;this.src='https://localhost/img/photos/userpic.png';" class="ml-md-auto" style="object-fit: cover;width: 120px; height: 120px;border-radius: 50%;" src="<?php echo $profilePic;?>" alt="dp">
                            </div>
                        </div>
                        <div class="col-md-9" id="infoTextArea">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                                    <h1 class="d-inline mr-2" style="font-size: 36px;font-weight: 700;"><?php echo $firstName." ".$lastName;?></h1>
                                    <span class="d-inline-block mt-3" style="vertical-align:super;">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <?php
                                            if(isset($_SESSION['sessUser'])){ 
                                                if($id == $_SESSION["sessUser"])
                                                    echo '<div class="btn-group mr-2" role="group" aria-label="First group">
								        <a href="edit-profile.php" class="btn button_coloured font-weight-light" style="height: 32px;font-size:16px;padding-top: 0px;padding-bottom: 0px;"><i class="fa fa-pencil" style="font-size:12px;" ></i>&nbsp;Edit profile</a>
								    </div>' ;
                                                else{

                                                    echo '<div  class="btn-group mr-2" role="group" aria-label="First group">
								        <button data-user="'.$id.'" data-command="'.$c.'"  class="followButton  button_coloured rd__button--white '.(($c == "unfollow")?"btn-primary":"").' font-weight-light" style="height: 32px;font-size:16px;padding-top: 0px;padding-bottom: 0px;">'.(($c == "unfollow")?"Following":"Follow").'</button>
								    </div>';
                                            }



                                            }
                                            ?>		
                                        </div>
                                    </span>
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
<div class="navbar">
<span class="navbar-brand">
       <a class="border-bottom border-primary h6 p-3 text-primary" style="cursor:pointer;">Photos</a>
        <a href="https://localhost/img/<?php echo (($id==$_SESSION['sessUser'])?"me":"@".$id);?>/collections"  class="border-primary h6 p-3 text-dark text-decoration-none" style="cursor:pointer;">Collections</a>

    
</span>    
    
    
    
</div>

                <div class="row border-top p-4">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card-columns text-center card-columns-count-3">
                            <?php 

                        $query = "select * from uploads where userid = ".$id." limit 15";
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
                                        <div class="px-1"><img class="rounded-circle" onerror="solvePic(this)" src="https://localhost/img/'.$profilePic.'" alt="dp" style="width:30px; height:30px"></div>
                                        <span class="px-1"><a class="text-decoration-none" style="color:inherit;" target="_blank" href="https://localhost/img/@'.$id.'">'.$firstName." ".$lastName.'</a></span>
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


        <script src="js/collection.js">

        </script>


    </body>
</html>