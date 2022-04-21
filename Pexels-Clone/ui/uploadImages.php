<?php
	include '../session.php';
	if(isset($_SESSION['sessUser'])){
		$authorID = $_SESSION['sessUser']; 
	}
	//else $_SESSION['sessUser'] = 1;
	else header("Location: join.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Upload</title>
	<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/bootstrap.min.css" class="stylesheet">
	<link rel="stylesheet" href="../styles/upload.css" class="stylesheet">
	<script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
	<script src="../js/jquery-3.6.0.js"></script>
	<script src="bts/src/bootstrap-tagsinput.js"></script>
	<link rel="stylesheet" href="bts/src/bootstrap-tagsinput.css">
	
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container mx-auto p-3" style="max-width:780px; width: 100%;">
		<div class="text-center">
			<h2 class="font-weight-bold my-4">Upload Photos & Videos</h2>
			<ul id="guidelines">
				<li>Your uploads will be distributed for free under the Pexels license. Learn more</li>
				<li>To increase the chance of being featured, please ensure that your submissions meet our guidelines.</li>
				<li>We'll review your submission. If it gets selected, you will receive an email notification and your content will be featured in our search.</li>
			</ul>
			<div id="uploadBox">
				<form class="d-inline-block mx-auto py-4"  action="upload.php" method="post" enctype="multipart/form-data">
					<label for="hiddenInput" class="btn btnPrimary mr-2">
						Browse
						<input type="file" id="hiddenInput" class="js-file-input" accept="image/jpg, image/jpeg, image/png" multiple>
					</label>
					<span class="font-weight-bold">Or Drag and Drop</span>
				</form>
			</div>
		</div>
	</div>
	<div id="serverResponse" class="d-flex flex-column">
		<div id="progressBar" class="mx-auto w-75 d-none flex-column">
			<div id="bar">
				<div id="width"></div>
			</div>
			<p id="uploadStatus" class="mx-auto">Photos Upload Status: 0%</p>
		</div>
	</div>
	<div id="previewBox">
		<forma id="form"  enctype="multipart/form-data">
			<input type="hidden" name="authorID" value="<?php echo $authorID; ?>" >
		</forma>
	</div>
	<div style="height:80px;width:100%"></div>
	<footer class="fixed-bottom">
		<button id="publish" class="btn btnPrimary">Publish</button>
	</footer>
	<script src="upload.js"></script>
	
	
    <link rel="stylesheet" href="bts/dist/bootstrap-tagsinput.css">
    <script src="bts/dist/bootstrap-tagsinput.min.js"></script>
</body>
</html>