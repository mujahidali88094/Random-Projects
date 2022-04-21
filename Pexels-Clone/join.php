<?php 
require_once 'session.php';
if(isset($_SESSION['sessUser']))
	header("Location: index.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<title>Pexels</title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="styles/bootstrap.min.css" class="stylesheet">
	<link rel="stylesheet" href="styles/styles.css" class="stylesheet">
	<link rel="stylesheet" href="styles/profile.css" class="stylesheet">

	<script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
	<script src="js/jquery-3.6.0.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/logs.js"></script>

</head>
<body style="overflow:hidden;">
	
	<div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0" nonce="vKU7ofNO"></script>
    
    
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
				<div class="px-2 d-md-block d-none">Have an Account?</div>
				<div class="px-2"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#logInModal" id="logIn">Sign-in</button></div>
			</div>
		</div>
		<div class="separator"></div>
		<?php
			if(isset($_SESSION['AccountDeleted']))
				if($_SESSION['AccountDeleted'])
				echo'
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="small flash flash--notice"> Your account and related data was deleted successfully.</div>
			</div>';
			$_SESSION['AccountDeleted'] = 0;
		?>
		<div class="row px-3 font-size-xlarge" id="contentBox">
			<div class="col-md-5 col-12 no-gutters p-5" id="leftBox">
				<h1 class="text-center font-weight-bold">Join The Pexels Community</h1>
				<p class="text-center text-black-50">Take your photography to the next level. Get it seen by millions.</p>
				<form id="signUpForm">
				<div class="text-center">
                <div class="fb-login-button" data-width="" data-scope="public_profile,email" data-onlogin="checkLoginState();" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true"></div>
            	</div>
					<p class="text-center mb-4 text-black-50">OR</p>
					<div class="row">
						<div class="mb-3 col-6 pr-1">
							<input type="text" name="fName" class="form-control" placeholder="First-Name" required>
						</div>
						<div class="mb-3 col-6 pl-1">
							<input type="text" name="lName" class="form-control" placeholder="Last-Name (optional)">
						</div>
					</div>
					<div class="mb-3">
						<input type="email" name="email" class="form-control" placeholder="Email" required>
					</div>
					<div class="mb-3">
						<input type="password" name="password" class="form-control" placeholder="Password" required>
					</div>
					<button type="submit" name="signup" class="btn btn-primary w-100 bgPColor">Create New Account</button>
				</form>
				<p id="terms" class="text-center my-2 text-black-50">By joining, you agree to our Terms of Service and Privacy Policy</p>
			</div>
			<div class="col-md-7 col-12 position-relative px-5" id="rightBox">
				<div class="row" id="gallery">
					<div class="col-md-4 col-6 px-2 galleryCol">
						<div class="signInCard"><img src="photos/signIn_1_1.jpeg"></div>
						<div class="signInCard"><img src="photos/signIn_1_2.jpeg"></div>
						<div class="signInCard"><img src="photos/signIn_3_3.jpeg"></div>
					</div>
					<div class="col-md-4 col-6 px-2 galleryCol">
						<div class="signInCard"><img src="photos/signIn_2_1.jpeg"></div>
						<div class="signInCard"><img src="photos/signIn_2_2.jpeg"></div>
						<div class="signInCard"><img src="photos/signIn_2_3.jpeg"></div>
					</div>
					<div class="col-md-4 px-2 galleryCol">
						<div class="signInCard"><img src="photos/signIn_3_1.jpeg"></div>
						<div class="signInCard" id="qoute">
							<p class="mb-0">"Love that I can share my	photos with the world. Also the fact that I got my photos published
								on Forbes.com is priceless."</p>
							<img class="mx-auto mt-3" src="photos/signIn_3_2_person.png"> 
							<p class="mb-0">Aleksandar Pasaric</p>
						</div>
						<div class="signInCard"><img src="photos/signIn_3_3.jpeg"></div>
					</div>
				</div>
				<div class="signInCard qouteOutside" id="qoute">
					<p class="mb-0">"Love that I can share my	photos with the world. Also the fact that I got my photos published
						on Forbes.com is priceless."</p>
					<img class="mx-auto mt-3" src="photos/signIn_3_2_person.png"> 
					<p class="mb-0">Aleksandar Pasaric</p>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$(window).resize(function(){
				$(window).scrollTop(0);
			});
			$("#forgot-btn").click(function(){
        $("#logInModal").modal('hide');
			});
			$("#dismissModal").click(function(){
        $("#forgotPasswordModal").modal('hide');
			});
		});
	</script>

	<!-- Login Modal -->
	<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title m-auto" id="exampleModalLongTitle">Welcome back to Pexels</h5>
				</div>
				<div class="modal-body">
				<div class="text-center">
					<form action="" id="logInForm">
						<div class="text-center"> 
							<div class="fb-login-button"  data-scope="public_profile,email" data-onlogin="checkLoginState();" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true"></div>
						</div>
						<p class="text-center my-4 text-black-50">OR</p>
						<div class="mb-3">
							<input type="email" name="loginEmail" class="form-control" placeholder="Email" required>
						</div>
						<div class="mb-3">
							<input type="password" name="loginPassword" class="form-control" placeholder="Password" required>
						</div>
						<button type="submit" name="login" class="btn btn-primary w-100 bgPColor">Login</button>
					</form>
					<p id="terms" class="text-center my-2 text-black-50"><button class="btn btn-md" id="forgot-btn" data-toggle="modal" data-target="#forgotPasswordModal">Forgot your password?</button></p>
        </div>
				</div>
			</div>
		</div>
	</div>
	<!--- Forgot-Password Modal --->
	<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title m-auto" id="exampleModalLongTitle">Reset your password!</h5>
				</div>
				<div class="modal-body">
					<form id="fpForm">
						<div class="mb-3">
						<input type="email" name="forgEmail" class="form-control" placeholder="Email" required>
					</div>
					<button type="submit" name="submit" class="btn btn-primary w-100 bgPColor">Send Reset Information</button>
				</form>
					<div class="my-4">
						<p id="mailSent" class="d-none">Mail sent...<br>Follow instructions in the mail to reset your password.</p>
						<p id="accountNotFound" class="d-none">Account not found...<br>You should <span class="px-2"><button type="button" class="btn btn-light" id="dismissModal">Sign-up</button></span> first. </p>
					</div>

				</div>
			</div>
		</div>
	</div>


</body>

</html>