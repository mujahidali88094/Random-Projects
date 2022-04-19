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
			<div class="col-md-10">
				<h1 class="admin-heading">All Categories</h1>
			</div>
			<div class="col-md-2">
				<a class="add-new" href="add-category.php">add category</a>
			</div>
			<div class="col-md-12">
				<table class="content-table">
					<thead>
						<th>S.No.</th>
						<th>Category Name</th>
						<th>No. of Posts</th>
						<th>Edit</th>
						<th>Delete</th>
					</thead>
					<tbody>
					<?php
						if(isset($_GET['page'])){
							$page = $_GET['page'];
						}
						else $page = 1;
						$limit = 5;
						$offset = ($page - 1)*$limit;

						$query1 = "Select * From category;";
						$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
						$noOfRecords = mysqli_num_rows($result);
						if($noOfRecords == 0) die();

						$query1 = "Select * From category
											LIMIT {$offset},{$limit};";
						$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
						$noOfRows = mysqli_num_rows($result);
						while($row = mysqli_fetch_assoc($result)){
							$id = $row['category_id'];
							$name = $row['category_name'];

							$sql1 = "Select * From post
											WHERE post.category='{$id}';";
							$sql1result = mysqli_query($conn,$sql1) or die("Query process Unsuccessful");
							$count = mysqli_num_rows($sql1result);

					?>
						<tr>
							<td class='id'><?php echo $id;?></td>
							<td><?php echo $name;?></td>
							<td><?php echo $count;?></td>
							<td class='edit'><a href='update-category.php?id=<?php echo $id;?>'><i class='fa fa-edit'></i></a></td>
							<td class='delete'><a href='delete-category.php?id=<?php echo $id;?>'><i class='fa fa-trash-o'></i></a></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
				<ul class='pagination admin-pagination'>
					<?php
						$noOfPages = ceil($noOfRecords / $limit); 
						for($i=1;$i<=$noOfPages;$i++){
							if($i == $page) $isActive = "active";
							else $isActive = ""; 
					?>
					<li class="<?php echo $isActive; ?>"><a href="category.php?page=<?php echo $i ?>"><?php echo $i; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php include "footer.php"; ?>
