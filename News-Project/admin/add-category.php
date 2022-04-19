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
					<h1 class="admin-heading">Add New Category</h1>
				</div>
				<div class="col-md-offset-3 col-md-6">
					<!-- Form Start -->
					<form action="add-category.php" method="POST" autocomplete="off">
						<div class="form-group">
							<label>Category Name</label>
							<input type="text" name="cat" class="form-control" placeholder="Category Name" required>
						</div>
						<input type="submit" name="save" class="btn btn-primary" value="Save" required />
						<?php
							if(isset($_POST['save'])){
								$name = $_POST['cat'];
								if(ctype_space($name)) die("Invalid Name");

								$query =   "INSERT INTO category
                            Values( NULL,'{$name}'); " ;
								mysqli_query($conn,$query) or die("Could not Add Record.");                  
								echo "<br>Record Added.<br>";
							}
						?>
					</form>
					<!-- /Form End -->
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?>
