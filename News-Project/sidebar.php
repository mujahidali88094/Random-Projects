<?php
	$conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");
?>
<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php
				$query1 = "Select * From post,user,category
									WHERE post.author=user.user_id AND post.category=category.category_id
									Order By post.post_date DESC
									LIMIT 5;";
				$result = mysqli_query($conn,$query1) or die("Query process Unsuccessful");
				$noOfRows = mysqli_num_rows($result);
        if($noOfRows == 0) die('<p>No Records Found.</p>');
        while($row = mysqli_fetch_assoc($result)){
					$id = $row['post_id'];
					$title = $row['title'];
					$description = $row['description'];
					$category = $row['category_name'];
					$date = $row['post_date'];
					$author = $row['first_name']." ".$row['last_name'];
					$imgName = $row['post_img'];
			?>
        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo $id; ?>">
                <img src="uploads/<?php echo $imgName;?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo $id; ?>"><?php echo $title;?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href="category.php?category=<?php echo $category; ?>"><?php echo $category;?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
					<?php echo date_format(date_create($date),"M d, Y"); ?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $id; ?>">read more</a>
            </div>
        </div>
				<?php
				}
				?>
		</div>
    </div>
    <!-- /recent posts box -->
</div>
