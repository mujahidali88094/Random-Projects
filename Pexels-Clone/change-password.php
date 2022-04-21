
<?php 
$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

require_once 'session.php';
 if(!isset($_SESSION['sessUser']))
 	header("Location: join.php");
 else if(isset($_POST['changepass'])){

 $pass = $_POST['pass'];
 $confirmpass = $_POST['confirmpass'];
 
 if($pass != $confirmpass)
    die("Confirm Password is not same as password.");
 if($pass == $confirmpass && strlen($pass) < 8)
    die("Password's length should be 8 or greater.");
    $id = $_SESSION['sessUser'];
    $pass = md5($pass);
    $us = "UPDATE user set password ='{$pass}' Where userId={$id};";
    $ur = mysqli_query($conn,$us) or die("Action Failed.");
 	   $_SESSION['passUpdated'] = 1;
	   die("success");

}
 
?>


<?php
    if (!isset($_POST['changepass']))
{?>
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
		
		<div class="col-12 col-md-6 col-sm-12 col-lg-4 p-5 border ml-auto mr-auto mt-5 rounded shadow">
			<h2 class="d-block font-weight-bolder mb-5 mt-2 text-center">Change your password</h2>
	<form id="changePass" method="post" action="change-password.php">

		

  <div class="form-group">
      <label class="font-weight-bold h6">Password</label>
      <input type="password" class="form-control form-control-lg" name="pass">
  </div>
  <div class="form-group">
      <label class="font-weight-bold h6">Confirm Password</label>
      <input type="password" class="form-control form-control-lg"  name="confirmpass">
      <input type="hidden" class="form-control form-control-lg"  name="changepass">

  </div>
 
  <hr>
  <span class="float-right">
  	  <a class="btn btn-md btn-light font-weight-light button_coloured button_grey" href="/img/me/">Cancel</a>


  	  <input type="submit" value="Change Password" class="btn btn-md font-weight-light button_coloured">

</span>
	</form>
	</div>
			
		</div>

		</div>


	
	</div>
	

</body>
</html>


<?php 
}
else
{
 die("");
}
?>
