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
											if(isset($_GET['id'])){
												$id = $_GET['id'];
											}
											else header("Location: index.php");
											
											$query1 = "Select * From post,user,category
																WHERE post.author=user.user_id AND post.category=category.category_id
																AND post.post_id='{$id}';";
											$result = mysqli_query($conn,$query1) or die("Query Unsuccessful");
											$noOfRecords = mysqli_num_rows($result);
											if($noOfRecords == 0) die('<h1>Nothing Here.</h1>');
										?>
										<?php
											if(isset($_GET['page'])){
												$page = $_GET['page'];
											}
											else $page = 1;
											$limit = 3;
											$offset = ($page - 1)*$limit;

											$query1 = "Select * From post,user,category
																WHERE post.author=user.user_id AND post.category=category.category_id
																AND post.post_id='{$id}'
																LIMIT {$offset},{$limit};";
											$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
											$noOfRows = mysqli_num_rows($result);
											$row = mysqli_fetch_assoc($result);
												$title = $row['title'];
												$description = $row['description'];
												$category = $row['category_name'];
												$date = $row['post_date'];
												$author = $row['first_name']." ".$row['last_name'];
												$authorID = $row['author'];
												$imgName = $row['post_img'];
										?>
                        <div class="post-content single-post">
                            <h3><?php echo $title;?></h3>
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
                            <img class="single-feature-image" src="uploads/<?php echo $imgName;?>" alt=""/>
                            <p class="description">
															<?php echo $description;?>
                            </p>
                        </div>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
