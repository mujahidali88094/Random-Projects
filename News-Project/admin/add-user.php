<?php
	session_start();
	if(isset($_SESSION['username'])){
			if(!((time()-$_SESSION['last_login'])<=86400)){
					session_unset();
					session_destroy();
					header('Location: index.php');
			}
			$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
			$username = mysqli_real_escape_string($conn,$_SESSION['username']);
			$query = "Select role From user Where username='{$username}';";
			$result = mysqli_query($conn,$query) or die("Query Failure.");
			$row = mysqli_fetch_assoc($result);
			if($row == NULL || $row['role'] != "admin"){
				header("Location: post.php");
			}
	}
	else header('Location: index.php');
?>
<?php include "header.php"; ?>
	<div id="admin-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="admin-heading">Add User</h1>
				</div>
				<div class="col-md-offset-3 col-md-6">
					<!-- Form Start -->
					<form  action="add-user.php" method ="POST" autocomplete="off">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="fname" class="form-control" placeholder="First Name" required>
						</div>
							<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="lname" class="form-control" placeholder="Last Name" required>
						</div>
						<div class="form-group">
							<label>User Name</label>
							<input type="text" name="user" class="form-control" placeholder="Username" required>
						</div>

						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<div class="form-group">
							<label>User Role</label>
							<select class="form-control" name="role" >
								<option value="normal">Normal User</option>
								<option value="admin">Admin</option>
							</select>
						</div>
						<input type="submit"  name="save" class="btn btn-primary" value="Save" required />
						<?php
							if(isset($_POST['save'])){
								$fname = $_POST['fname'];if(ctype_space($fname)) die("Invalid First-Name");
								$lname = $_POST['lname'];if(ctype_space($lname)) die("Invalid Last-Name");
								$user = $_POST['user'];if(ctype_space($user)) die("Invalid username");
								$password  = $_POST['password'];if(ctype_space($password)) die("Invalid Password"); $password = md5($password);
								$role = $_POST['role'];if(ctype_space($role)) die("Invalid Role");

								$usersql = "Select user_id From user Where username='{$user}';";
								$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
								$usernoOfRows = mysqli_num_rows($userresult);
								if($usernoOfRows>0) die("Username already taken.<br> Try another one.");

								$query = "INSERT INTO user
													Values( NULL,'{$fname}','{$lname}','{$user}','{$password}','{$role}'); " ;
								mysqli_query($conn,$query) or die("Could not Add Record.");                  
								echo "<br>Record Added.<br>";
							}
						?>
					</form>
					<!-- Form End-->
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?>
