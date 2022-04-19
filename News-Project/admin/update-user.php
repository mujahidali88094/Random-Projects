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
					<h1 class="admin-heading">Modify User Details</h1>
				</div>
				<div class="col-md-offset-4 col-md-4">
					<!-- Form Start -->
					<?php if(isset($_REQUEST["id"])){
						$id = $_REQUEST['id'];
						$query =    "Select *  From user Where user_id = '{$id}';" ;
						$result = mysqli_query($conn,$query) or die("Query Unsuccessful.");
						$noOfRows = mysqli_num_rows($result);
						if($noOfRows == 0) echo 'Invalid ID.<br>';
						else{
							$row = mysqli_fetch_assoc($result);
					?>
					<form  action="update-user.php" method ="POST">
						<div class="form-group">
							<input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id']; ?>" placeholder="" >
						</div>
							<div class="form-group">
							<label>First Name</label>
							<input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
						</div>
						<div class="form-group">
							<label>User Name</label>
							<input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
						</div>
						<div class="form-group">
							<label>User Role</label>
							<select class="form-control" name="role">
								<?php 
									if($row['role']=='normal')	echo	'<option selected value="normal">normal User</option>';
									else echo	'<option value="normal">normal User</option>' ;
									if($row['role']=='admin')	echo	'<option selected value="admin">admin</option>';
									else echo	'<option value="admin">admin</option>';
								?>
							</select>
						</div>
						<input type="submit" name="submit" class="btn btn-primary" value="Update" required />
					</form>
					<!-- /Form -->
					<?php
              }
						}
						if(isset($_POST["submit"])){
							$id = $_POST["user_id"];
							$fname = $_POST['f_name'];if(ctype_space($fname)) die("Invalid First-Name");
							$lname = $_POST['l_name'];if(ctype_space($lname)) die("Invalid Last-Name");
							$user = $_POST['username'];if(ctype_space($user)) die("Invalid username");
							$role = $_POST['role'];if(ctype_space($user)) die("Invalid Role");

							$usersql = "Select user_id From user Where username='{$user}';";
							$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
							$usernoOfRows = mysqli_num_rows($userresult);
							if($usernoOfRows>1) die("Username already taken.<br> Try another one.");

							$query = "UPDATE user
												SET first_name='{$fname}',
														last_name='{$lname}',
														username='{$user}',
														role='{$role}'
												WHERE user_id = '{$id}'
												;" ;
							mysqli_query($conn,$query) or die("Could not update Record.");                  
							echo "<br>Record Updated.<br>";
						}
          ?>
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?>
