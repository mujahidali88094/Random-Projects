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
					<h1 class="adin-heading"> Update Category</h1>
				</div>
				<div class="col-md-offset-3 col-md-6">
					<?php if(isset($_REQUEST["id"])){
						$id = $_REQUEST['id'];
						$query =    "Select *  From category Where category_id = '{$id}';" ;
						$result = mysqli_query($conn,$query) or die("Query Unsuccessful.");
						$noOfRows = mysqli_num_rows($result);
						if($noOfRows == 0) echo 'Invalid ID.<br>';
						else{
							$row = mysqli_fetch_assoc($result);
					?>
					<form action="update-category.php" method ="POST">
						<div class="form-group">
							<input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
						</div>
						<div class="form-group">
							<label>Category Name</label>
							<input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?>"  placeholder="" required>
						</div>
						<input type="submit" name="save" class="btn btn-primary" value="Update" required />
					</form>
					<?php
              }
						}
						if(isset($_POST["save"])){
							$id = $_POST["cat_id"];
							$name = $_POST['cat_name'];if(ctype_space($name)) die("Invalid Name");

							$categorysql = "Select category_id From category Where category_name='{$name}';";
							$categoryresult = mysqli_query($conn,$categorysql) or die("Query Failed.");
							$categorynoOfRows = mysqli_num_rows($categoryresult);
							if($categorynoOfRows>0) die("Category with this name already exists.<br> Try another one.");

							$query = "UPDATE category
												SET category_name='{$name}'
												WHERE category_id = '{$id}'
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
