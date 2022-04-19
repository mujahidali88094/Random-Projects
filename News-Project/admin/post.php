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
<?php
$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
?>
<?php include "header.php"; ?>
	<div id="admin-content">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h1 class="admin-heading">All Posts</h1>
				</div>
				<div class="col-md-2">
					<a class="add-new" href="add-post.php">add post</a>
				</div>
				<div class="col-md-12">
					<table class="content-table">
						<thead>
							<th>S.No.</th>
							<th>Title</th>
							<th>Category</th>
							<th>Date</th>
							<th>Author</th>
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
								$counter = 1;

								$query1 = "Select * From post,user,category
													WHERE post.author=user.user_id AND post.category=category.category_id;";
								$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
								$noOfRecords = mysqli_num_rows($result);
								if($noOfRecords == 0) die();

								$query1 = "Select * From post,user,category
													WHERE post.author=user.user_id AND post.category=category.category_id
													Order By post.post_date DESC
													LIMIT {$offset},{$limit};";
								$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
								$noOfRows = mysqli_num_rows($result);
								while($row = mysqli_fetch_assoc($result)){
									$id = $row['post_id'];
									$title = $row['title'];
									$description = $row['description'];
									$category = $row['category_name'];
									$date = $row['post_date'];
									$author = $row['first_name']." ".$row['last_name'];
									$authorID = $row['author'];
									$imgName = $row['post_img'];
							?>
							<tr>
								<td class='id'><?php echo $offset+($counter++);?></td>
								<td><?php echo $title;?></td>
								<td><?php echo $category;?></td>
								<td><?php echo date_format(date_create($date),"M d, Y"); ?></td>
								<td><?php echo $author;?></td>
								<td class='edit'><a href='update-post.php?id=<?php echo $id;?>'><i class='fa fa-edit'></i></a></td>
								<td class='delete'><a href='delete-post.php?id=<?php echo $id;?>'><i class='fa fa-trash-o'></i></a></td>
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
						<li class="<?php echo $isActive; ?>"><a href="post.php?page=<?php echo $i ?>"><?php echo $i; ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php include "footer.php"; ?>
