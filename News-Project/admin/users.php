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
					<h1 class="admin-heading">All Users</h1>
				</div>
				<div class="col-md-2">
					<a class="add-new" href="add-user.php">add user</a>
				</div>
				<div class="col-md-12">
					<table class="content-table">
						<thead>
							<th>S.No.</th>
							<th>Full Name</th>
							<th>User Name</th>
							<th>Role</th>
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

								$query1 = "Select * From user";
								$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
								$noOfRecords = mysqli_num_rows($result);
								if($noOfRecords == 0) die();

								$query1 = "Select * From user
													Order By user_id
													LIMIT {$offset},{$limit};";
								$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
								$noOfRows = mysqli_num_rows($result);
								while($row = mysqli_fetch_assoc($result)){
									$id = $row['user_id'];
									$username = $row['username'];
									$name = $row['first_name']." ".$row['last_name'];
									$role = $row['role'];
							?>
								<tr>
									<td class='id'><?php echo $id;?></td>
									<td><?php echo $name;?></td>
									<td><?php echo $username;?></td>
									<td><?php echo $role;?></td>
									<td class='edit'><a href='update-user.php?id=<?php echo $id;?>'><i class='fa fa-edit'></i></a></td>
									<td class='delete'><a href='delete-user.php?id=<?php echo $id;?>'><i class='fa fa-trash-o'></i></a></td>
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
						<li class="<?php echo $isActive; ?>"><a href="users.php?page=<?php echo $i ?>"><?php echo $i; ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php include "header.php"; ?>
