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
		$query = "Select *  From user Where username='{$username}';";
		$result = mysqli_query($conn,$query) or die("Query Failure.");
		$row = mysqli_fetch_assoc($result);
		$currentUserID = $row['user_id'];
		$currentUserRole = $row['role'];
	}
	else header('Location: index.php');
?>
<?php include "header.php"; ?>
<div id="admin-content">
	<div class="container">
	<div class="row">
	<div class="col-md-12">
		<h1 class="admin-heading">Update Post</h1>
	</div>
	<div class="col-md-offset-3 col-md-6">
		<?php if(isset($_REQUEST["id"])){
			$id = $_REQUEST['id'];
			$query =    "Select *  From post Where post_id = '{$id}';" ;
			$result = mysqli_query($conn,$query) or die("Query Unsuccessful.");
			$noOfRows = mysqli_num_rows($result);
			if($noOfRows == 0) echo 'Invalid ID.<br>';
			else{
				$row = mysqli_fetch_assoc($result);
				if(!($row['author']==$currentUserID || $currentUserRole=="admin")) die("<h3>You cannot edit this post.</h3>");
				$imgName = $row['post_img'];
		?>
		<!-- Form for show edit-->
		<form action="update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
			<div class="form-group">
				<input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id']; ?>" placeholder="">
			</div>
			<div class="form-group">
				<label for="exampleInputTile">Title</label>
				<input type="text" name="title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>" required>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1"> Description</label>
				<textarea name="desc" class="form-control"  required rows="5" required>
				<?php echo $row['description']; ?>
				</textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputCategory">Category</label>
				<select class="form-control" name="category" required>
					<?php 
						function separateCode(){
							global $row;
							$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
							$query =    "Select * From Category" ;
							$result = mysqli_query($conn,$query) or die("Query process Unsuccessful");
							$noOfRows = mysqli_num_rows($result);
							while($classRow = mysqli_fetch_assoc($result)){
								if($row['category']==$classRow['category_id'])
									$isSelected = "Selected";
								else
									$isSelected = "";
								echo '<option '.$isSelected.' value="'.$classRow["category_id"].'">'.$classRow["category_name"].'</option>';
							}
						}
						separateCode();
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="">Post image</label>
				<input type="file" name="new-image">
				<img  <?php echo "src='../uploads/{$imgName}'"; ?> height="150px">
				<input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Update" />
		</form>
		<!-- Form End -->
		<?php
				}
			}
			if(isset($_POST["submit"])){
				$id = $_POST['post_id'];
				$title = $_POST['title']; if(ctype_space($title)) die("Invalid Title.");
				$desc = $_POST['desc']; if(ctype_space($desc)) die("Invalid Description.");
				$category = $_POST['category']; if($category==NULL) die("Invalid category.");
				$date = date("Y-m-d");

				$author = $_SESSION['username'];
				$sql1 = "Select user_id From user Where username='{$author}';";
				$result1 = mysqli_query($conn,$sql1) or die("Query Unsuccessful.");
				$row1 = mysqli_fetch_assoc($result1);
				$auhtorID = $row1['user_id'];

				if(!($_FILES['new-image']['name']=="")){
					//file upload Process
					$fileName = $_FILES['new-image']['name'];
					$fileSize = $_FILES['new-image']['size'];
					$fileTmpName = $_FILES['new-image']['tmp_name'];
					$fileType = explode("/",$_FILES['new-image']['type'])[0];
					$fileExt = strtolower(explode("/",$_FILES['new-image']['type'])[1]);

					$uploadStatus = 1;
					
					echo "<br>";
					if($fileType!='image'){echo "You should upload an IMAGE.<br>";$uploadStatus=0;}
					if($fileExt!='jpeg' && $fileExt!='jpg' && $fileExt!='gif' && $fileExt!='png'){echo "<File Extension should be jpg,jpeg,gif or png.<br>";$uploadStatus=0;}
					if($fileSize>2097152){echo "File should be less than 2MB.<br>";$uploadStatus=0;}
					if(file_exists("../uploads/".$fileName)){echo "File already exists.<br>";$uploadStatus=2;}


					if($uploadStatus==1){
						if(move_uploaded_file($fileTmpName,"../uploads/".$fileName))
							echo "File Uploaded.<br>";
						else die("Some error occured while uploading.<br>");
					}
					else if($uploadStatus==0) die();
					//File Upload process Ends
				}
				if(!(isset($fileName))) $fileName = $_POST['old-image'];
				$sql2 = "UPDATE post
								SET
								title='$title',description='$desc',category='$category',post_date='$date',
								author='$auhtorID',post_img='$fileName'
								WHERE post_id='{$id}';";
				$result2 = mysqli_query($conn,$sql2) or die("Query Unsuccessful.");
				echo "<h3>Post Updated.</h3><br>";
			}
		?>
		</div>
	</div>
	</div>
</div>
<?php include "footer.php"; ?>
