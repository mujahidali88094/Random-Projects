<?php $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful"); ?>
<?php

	//provides popular Tags in json format
	$popularTags = array();

	$sql = "SELECT uploads.imgID,
					(SELECT count(*) FROM downloads WHERE downloads.imgid=uploads.imgID) as noOfDownloads,
					(SELECT count(*) FROM likes WHERE likes.imgid=uploads.imgID) as noOfLikes,
					(SELECT count(*) FROM views WHERE views.imgid=uploads.imgID) as noOfViews
					FROM uploads
					INNER JOIN user ON uploads.userID=user.userId
					ORDER BY noOfDownloads DESC,noOfLikes DESC,noOfViews DESC
					LIMIT 10;" ;
	$result = mysqli_query($conn,$sql) or die("Query Failed.");
	$noOfRows = mysqli_num_rows($result);
	if( $noOfRows > 0){
		while($row = mysqli_fetch_assoc($result)){
			$imgid = $row["imgID"];
			$sql1 = "SELECT tag FROM tags WHERE imgID={$imgid};" ;
			$result1 = mysqli_query($conn,$sql1) or die("Query Failed.");
			$noOfRows1 = mysqli_num_rows($result1);
			if( $noOfRows1 > 0){
				while($row1 = mysqli_fetch_assoc($result1)){
					if(!in_array($row1["tag"],$popularTags))
						$popularTags[] = $row1["tag"];
				}
			}
		}
	}
	echo json_encode($popularTags);
?>