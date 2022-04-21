
<?php 
$firstName;
$lastName;
$email;
$shortBio;
$webLink;
$instagram;
$twitter;
$location;
$profilePic;
require_once 'session.php';
if(!isset($_SESSION['sessUser']))
    die("Session Expired!");
else if(isset($_FILES['userImage'])){
    if(is_array($_FILES)) {
        if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
            $sourcePath = $_FILES['userImage']['tmp_name'];
            $targetPath = "photos/".time()."-".$_FILES['userImage']['name'];
            if(move_uploaded_file($sourcePath,$targetPath)) {
                $conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");
                $us = "UPDATE user set profilepic ='{$targetPath}' Where userId={$_SESSION['sessUser']};";
                $ur = mysqli_query($conn,$us) or die("Action Failed.");
                die($targetPath);


            }
            else
                die("Error");
        }
    }
    die("");
}
else if(isset($_POST['editProfileForm'])){
    if($_POST['fname'] == "") die("First name cannot be empty.");
    if($_POST['email'] == "") die("Email cannot be empty.");
    $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

    foreach ($_POST as $key => $value) {
        $_POST[$key] = $conn -> real_escape_string($value);
    }
    $us = "UPDATE user
	 		set firstname ='{$_POST["fname"]}',
	 		 lastname ='{$_POST["lname"]}',
	 		 email ='{$_POST["email"]}',
	 		 shortbio ='{$_POST["shortbio"]}',
	 		 instagram ='{$_POST["userinstagram"]}',
	 		 twitter ='{$_POST["usertwitter"]}',
			 location ='{$_POST["userlocation"]}',
			 weblink = '{$_POST['userWebsite']}'
	 		Where userId={$_SESSION['sessUser']};";
    $ur = mysqli_query($conn,$us) or die($conn -> error);
    $_SESSION['profileUpdated'] = 1;
    die("success");

}
else{
    $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

    $usersql = "Select * From user Where userId='{$_SESSION["sessUser"]}' limit 1;";

    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


    $usernoOfRows = mysqli_num_rows($userresult);


    if($usernoOfRows>0)
        while($row = mysqli_fetch_assoc($userresult)) {
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $email = $row['email'];
            $shortBio = $row['shortBio'];
            $webLink = $row['webLink'];
            $instagram = $row['instagram'];
            $twitter = $row['twitter'];
            $location = $row['location'];
            $profilePic = $row['profilePic'];
        }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Profile</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="styles/bootstrap.min.css" class="stylesheet">
        <link rel="stylesheet" href="styles/profile.css" class="stylesheet">

        <script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
        <script src="js/jquery-3.6.0.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/logs.js"></script>

    </head>
    <body>


        <script type="text/javascript">


            $(document).ready(function (e) {
                $("#updateImage").on('submit',(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "edit-profile.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData:false,
                        success: function(data)
                        {
                            if(data.trim() !="Error"){
                                $(".previewImage").attr("src",data);
                                $("#updateImage").prepend("<span class='flash flash--notice small m-2 d-block'>Profile picture uploaded successfully.</div>");
                            }
                            else
                                alert(data);
                        },
                        error: function() 
                        {
                        } 	        
                    });
                }));
            });

            function showPreview(objFileInput) {
                if (objFileInput.files[0]) {
                    var fileReader = new FileReader();
                    fileReader.onload = function (e) {
                        $(".previewImage").attr("src",e.target.result);
                    }
                    fileReader.readAsDataURL(objFileInput.files[0]);
                }
            }

        </script>
        <div class="container-fluid">

            <div class="row">

                <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-2 d-flex justify-content-end align-items-center border-bottom">
                    <div class="px-1 ml-auto">
                        <a class="logo" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 32 32">
                                <path d="M2 0h28a2 2 0 0 1 2 2v28a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" fill="#05A081"></path>
                                <path d="M13 21h3.863v-3.752h1.167a3.124 3.124 0 1 0 0-6.248H13v10zm5.863 2H11V9h7.03a5.124 5.124 0 0 1 .833 10.18V23z" fill="#fff"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="px-1 mr-auto">Pexels</div>
                </div>

                <div class="col-12 col-md-7 col-sm-12 col-lg-5 p-5 border ml-auto mr-auto mt-4 mb-4 rounded">
                    <h2 class="d-block font-weight-bolder mb-5 mt-2 text-center">Edit Your Profile</h2>
                    <div class="form-group">
                        <label class="font-weight-bold h6">Avatar</label>
                        <div class="mb-5 mt-3">
                            <form id="updateImage" action="upload.php" method="post">
                                <img src="<?php echo $profilePic;?>" class="m-auto previewImage" onclick="$('#userImage').click()" width="60" height="60" style="object-fit: cover;border-radius: 50%;cursor: pointer;">

                                <input name="userImage" id="userImage" required onchange="showPreview(this)" type="file" class="inputFile d-none"/>

                                <input type="submit" value="Upload Photo" class="btn button_coloured"  style="padding: 6px 13px;font-size: 14px;font-weight: 600;margin: 0;min-height: 32px;" />
                            </form>


                        </div>
                    </div>
                    <form id="editProfile" method="post" action="index.php">
                        <input type="hidden" name="update" value="">
                        <input type="hidden" value="editProfile" name="editProfileForm">



                        <div class="form-row">
                            <div class="form-group  col-sm-6 col-6 col-md-6">
                                <label class="font-weight-bold h6">First Name</label>
                                <input type="text" class="form-control form-control-md" required value="<?php echo $firstName;?>" name="fname">
                            </div>
                            <div class="form-group col-sm-6 col-6 col-md-6">
                                <label class="font-weight-bold h6">Last Name</label>
                                <input type="text" class="form-control form-control-md" value="<?php echo $lastName;?>" name="lname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Email</label>
                            <input type="email" class="form-control form-control-md" required value="<?php echo $email;?>" name="email">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Short Bio</label>
                            <input type="text" class="form-control form-control-md" value="<?php echo $shortBio;?>" name="shortbio">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Website <span class="text-muted font-weight-light">(e.g. Portfolio, Facebook, Dribble,...)</span></label>
                            <input type="url"
                                   pattern="https://.*" size="65" maxlength="65" class="form-control form-control-md" value="<?php echo $webLink;?>" name="userWebsite">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Instagram username</label>
                            <input type="text" class="form-control form-control-md" value="<?php echo $instagram;?>" name="userinstagram">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Twitter username</label>
                            <input type="text" class="form-control form-control-md" value="<?php echo $twitter;?>" name="usertwitter">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Location</label>
                            <input type="text" class="form-control form-control-md" value="<?php echo $location;?>" name="userlocation">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold h6">Password</label>
                            <a href="./change-password" target="_blank"  type="text" class="p-0 border-0 outline-0 link link-secondary form-control form-control-md" style="text-decoration: underline;color: black;" name="shortbio">Change Password</a>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold h6">Delete your account</label>
                            <a target="_blank" href="./delete-account" type="text" class="p-0 border-0 outline-0 link link-secondary form-control form-control-md" style="text-decoration: underline;color: black;" name="shortbio">Delete your account (You can't undo this!)</a>
                        </div>
                        <hr>
                        <span class="float-right">
                            <a href="https://localhost/img/me" class="btn btn-md btn-light font-weight-light button_coloured button_grey">Cancel</a>


                            <button type="submit" class="btn btn-md font-weight-light button_coloured">Update Profile</button>

                        </span>
                    </form>
                    
                </div>

            </div>

        </div>



        

    </body>
</html>






