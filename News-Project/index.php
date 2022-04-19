<?php include 'header.php';
$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
?>
	<div id="main-content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
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
													WHERE post.author=user.user_id AND post.category=category.category_id;";
								$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
								$noOfRecords = mysqli_num_rows($result);
								if($noOfRecords == 0) die('<p>No Records Found.</p>');

								$query1 = "Select * From post,user,category
													WHERE post.author=user.user_id AND post.category=category.category_id
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
										<h3><a href="single.php?id=<?php echo $id; ?>"><?php echo $title;?></a></h3>
										<div class="post-information">
											<span>
												<i class="fa fa-tags" aria-hidden="true"></i>
												<a href="category.php?category=<?php echo $category; ?>"><?php echo $category;?></a>
											</span>
											<span>
												<i class="fa fa-user" aria-hidden="true"></i>
												<a href="author.php?author=<?php echo $authorID; ?>"><?php echo $author;?></a>
											</span>
											<span>
												<i class="fa fa-calendar" aria-hidden="true"></i>
												<?php echo date_format(date_create($date),"M d, Y"); ?>
											</span>
										</div>
										<p class="description max-4-lines">
											<?php echo $description;?>
										</p>
										<a class='read-more pull-right' href="single.php?id=<?php echo $id; ?>">read more</a>
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
										if($i == $page) $isActive = "active";
										else $isActive = ""; 
								?>
								<li class="<?php echo $isActive; ?>"><a href="index.php?page=<?php echo $i ?>"><?php echo $i; ?></a></li>
								<?php } ?>
						</ul>
					</div><!-- /post-container -->
				</div>
				<?php include 'sidebar.php'; ?>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>
