<?php include 'header.php';
	$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
?>
	<div id="main-content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<?php
						if(isset($_GET['category'])){
							$category = $_GET['category'];
						}
						else header("Location: index.php");
						
						$query1 = "Select * From post,user,category
											WHERE post.author=user.user_id AND post.category=category.category_id
											AND category.category_name='{$category}';";
						$result = mysqli_query($conn,$query1) or die("Query Unsuccessful");
						$noOfRecords = mysqli_num_rows($result);
						if($noOfRecords == 0) die('<h1>No Posts in this Category.</h1>');
					?>
					<h2 class="page-heading"><?php echo $category ?></h2>
					<!-- post-container -->
					<div class="post-container">
						<?php
							if(isset($_GET['page'])){
								$page = $_GET['page'];
							}
							else $page = 1;
							$limit = 3;
							$offset = ($page - 1)*$limit;

							$query1 = "Select * From post,user,category
												WHERE post.author=user.user_id AND post.category=category.category_id
												AND category.category_name='{$category}'
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
						<div class="post-content">
							<div class="row">
								<div class="col-md-4">
									<a class="post-img" href="single.php?id=<?php echo $id; ?>"><img src="uploads/<?php echo $imgName;?>" alt=""/></a>
								</div>
								<div class="col-md-8">
									<div class="inner-content clearfix">
										<h3><a class="discardAnchor" href="single.php?id=<?php echo $id; ?>"><?php echo $title;?></a></h3>
										<div class="post-information">
											<span>
												<i class="fa fa-tags" aria-hidden="true"></i>
												<a href="category.php?category=<?php echo $category; ?>"><?php echo $category;?></a>
											</span>
											<span>
												<i class="fa fa-user" aria-hidden="true"></i>
												<a href='<?php echo "author.php?author={$authorID}" ?>'><?php echo $author;?></a>
											</span>
											<span>
												<i class="fa fa-calendar" aria-hidden="true"></i>
												<?php echo date_format(date_create($date),"M d, Y"); ?>
											</span>
										</div>
										<p class="description max-4-lines">
											<?php echo $description;?>
										</p>
										<a class='read-more pull-right' href='single.php?id=<?php echo $id; ?>'>read more</a>
									</div>
								</div>
							</div>
						</div>
						<?php
							}
						?>
						<ul class='pagination'>
							<?php
								$noOfPages = ceil($noOfRecords / $limit); 
								for($i=1;$i<=$noOfPages;$i++){
									if($i == $page) $isActive = "class='active'";
									else $isActive = ""; 
									echo "<li {$isActive}><a href='category.php?category={$category}&page={$i}'>{$i}</a></li>";
								}
							?>
						</ul>
					</div><!-- /post-container -->
				</div>
				<?php include 'sidebar.php'; ?>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>
