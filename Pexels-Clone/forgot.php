
<?php 
require_once 'session.php';
if(isset($_SESSION['sessUser']))
	header("Location: index.php");
?>

<?php

$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");


if(!isset($_GET['accesstoken']))
	header("location: join.php");
else{

$usersql = "Select id From fp Where token='{$_GET['accesstoken']}';";
$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
$usernoOfRows = mysqli_num_rows($userresult);

echo '<!DOCTYPE html>
<html lang="en">

<head>

	<title>Pexels</title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="styles/bootstrap.min.css" class="stylesheet">
	<link rel="stylesheet" href="styles/styles.css" class="stylesheet">

	<script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
	<script src="js/jquery-3.6.0.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/logs.js"></script>

</head>
<body>

    
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-2 d-flex justify-content-end align-items-center">
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
		</div>
		<div class="separator"></div>
		<div class="row px-3 font-size-xlarge" id="contentBox">
			<div class="col-md-12 col-sm-12 col-lg-5 m-auto no-gutters p-5" id="leftBox">
		';
if($usernoOfRows>0){
	while($row = mysqli_fetch_assoc($userresult))
         $id = $row['id'];

     $us = "Select firstName From user Where userId={$id};";
$ur = mysqli_query($conn,$us) or die("Query Failed.");

while($row = mysqli_fetch_assoc($ur))
         $name = $row['firstName'];

echo '<h1 class="text-center font-weight-bold">Hi '.$name.', Reset Your Password</h1>';
echo'
		<p class="text-center text-black-50">Take your photography to the next level. Get it seen by millions.</p>
		<div id="passwordChanged" class="alert alert-success d-none"></div>
			<div id="errors" class="alert alert-danger d-none"></div>

				<form id="forgetForm">
				
					<div class="mb-3">
						<input type="password" name="pass" class="form-control" placeholder="Password" required>
					</div>
					<div class="mb-3">
						<input type="password" name="confirmPass" class="form-control" placeholder="Confirm Password" required>
					</div>
					<button type="submit" name="signup" class="btn btn-primary w-100 bgPColor">Change my Password</button>
					<input name="accessToken" type="hidden" value="'.$_GET['accesstoken'].'">
				</form>
				
			</div>
		</div>
	</div>' ;

}
else
{

	echo'<h1 class="text-center font-weight-bold">This link is expired or invalid please try again.</h1>';
}

}

?>





</body>

</html>