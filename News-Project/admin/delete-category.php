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
<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	else header("Location: category.php");
	
	$query1 = "Delete FROM category Where category_id='{$id}';";
	if(mysqli_query($conn,$query1)) echo "<h3>Deleted Successfully</h3><br>";
	else echo "<h3>Unable to Delete</h3><br>";

	echo "<h4>You will be redirected in a few seconds</h4><br>";
?>
<meta http-equiv="refresh" content="5;category.php">
