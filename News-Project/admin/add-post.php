<?php
	session_start();
	if(isset($_SESSION['username'])){
			if(!((time()-$_SESSION['last_login'])<=86400)){
					session_unset();
					session_destroy();
					header('Location: index.php');
			}
	}
	else header('Location: index.php');
?>
<?php include "header.php"; ?>
	<div id="admin-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="admin-heading">Add New Post</h1>
				</div>
				<div class="col-md-offset-3 col-md-6">
					<!-- Form -->
					<form  action="add-post.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label> Description</label>
							<textarea name="desc" class="form-control" rows="5"  required></textarea>
						</div>
						<div class="form-group">
							<label>Category</label>
							<select name="category" class="form-control">
								<?php
									$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
									$sql = "Select * From category;" ;
									$result = mysqli_query($conn,$sql) or die("Query Failure");
									while($row = mysqli_fetch_assoc($result)){
										$id = $row['category_id'];
										$name = $row['category_name'];
										echo "<option value='{$id}'> {$name}</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Post image</label>
							<input type="file" name="fileToUpload" required>
						</div>
						<input type="submit" name="save" class="btn btn-primary" value="Save" required />
					</form>
					<!--/Form -->
					<?php
						if(isset($_POST['save'])){
							$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");

							$title = mysqli_real_escape_string($conn,$_POST['title']); if(ctype_space($title)) die("Invalid Title.");
							$desc = mysqli_real_escape_string($conn,$_POST['desc']); if(ctype_space($desc)) die("Invalid Description.");
							$category = $_POST['category']; if($category==NULL) die("Invalid category.");
							$date = date("Y-m-d");

							$author = $_SESSION['username'];
							$sql1 = "Select user_id From user Where username='{$author}';";
							$result1 = mysqli_query($conn,$sql1) or die("Query Unsuccessful.");
							$row1 = mysqli_fetch_assoc($result1);
							$auhtorID = $row1['user_id'];

							//file upload Process
							$fileName = $_FILES['fileToUpload']['name'];
							$fileSize = $_FILES['fileToUpload']['size'];
							$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
							$fileType = explode("/",$_FILES['fileToUpload']['type'])[0];
							$fileExt = strtolower(explode("/",$_FILES['fileToUpload']['type'])[1]);

							$uploadStatus = 1;
							
							echo "<br>";
							if($fileType!='image'){echo "You should upload an IMAGE.<br>";$uploadStatus=0;}
							if($fileExt!='jpeg' && $fileExt!='jpg' && $fileExt!='gif' && $fileExt!='png'){echo "File Extension should be jpg,jpeg,gif or png.<br>";$uploadStatus=0;}
							if($fileSize>2097152){echo "File should be less than 2MB.<br>";$uploadStatus=0;}
							if(file_exists("../uploads/".$fileName)){echo "File already exists.<br>";$uploadStatus=2;}


							if($uploadStatus==1){
								if(move_uploaded_file($fileTmpName,"../uploads/".$fileName))
									echo "File Uploaded.<br>";
								else die("Some error occured while uploading.<br>");
							}
							else if($uploadStatus==0) die();
							//File Upload process Ends
							$sql2 = "INSERT INTO post
											VALUES(NULL,'$title','$desc','$category','$date','$auhtorID','$fileName')
											;";
							$result2 = mysqli_query($conn,$sql2) or die("Query Unsuccessful.");
							echo "<h3>Post Added.</h3><br>";

						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?>
