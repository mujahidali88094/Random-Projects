<?php  
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "test";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass , $db) or die($conn);

include '../session.php';

function validFormat($str){

	$imgFormats = ".apng .avif .gif .jpg .jpeg .jfif .pjpeg .pjp .png .svg .webp";
	$imgFs = explode(" ", $imgFormats);
	return in_array(strtolower($str),$imgFs);

}

// returns index of picture assigned before upload
function findIndex($nameOfFile){
	$maxSize = $_POST['maxSize'];
	for($x=0;$x<$maxSize;$x++){
		if( $_POST['pictureName'.$x] == $nameOfFile ){
			return $x;
		}
	}
	return -1;
}

function getUniqueId(){

    $k = random_int(10000000, 99999999999);
    
    $u = "Select userid From uploads Where imgid='{$k}';";
    
    $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");    
    $ur = mysqli_query($conn,$u) or die("Database Error");
    
    $uR = mysqli_num_rows($ur);
    
    if($uR<1) 
        return $k;
    else 
        return getUniqueId();

}


function get_extension($fname){ 
	return substr($fname, strrpos($fname, ".") + 1);
}


function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

if(isset($_POST['noOfFiles'])){
	$noOfFiles = $_POST['noOfFiles'];
	$authorID = $_POST['authorID'];
	if(isset($_FILES['files']['name'][0])){

		echo '<div class="mx-auto">';

		$total = $noOfFiles;
		$notUploaded = 0;

		for($i=0;$i<$noOfFiles;$i++){
			$id       = getUniqueId();
			$fileName = $_FILES['files']['name'][$i];
			$file = "pexels-photo-".$id.".".get_extension($fileName);
			$tempName = $_FILES['files']['tmp_name'][$i];
			$targetLocation = "userUploads/".$file;
            move_uploaded_file($tempName,"userUploads/Original-".$file);
            $img = resize_image("useruploads/Original-".$file, 640, 640);

			if(imagejpeg($img,"useruploads/".$file)){
				list($w,$h) = getimagesize($targetLocation);

				$tags="";
				$location="";
				$index = findIndex($fileName);
				if($index >= 0){
					$tags = $tags.$_POST['tags'.$index];
					$location = $location.$_POST['location'.$index];
				}
				$tagsArray = explode(",",$tags);

				/*//check if file already exists
				$query = "SELECT imgID
											FROM test.uploads
											WHERE name = '{$fileName}';";
				$result = mysqli_query($conn,$query);
				if(!($result)){
					++$notUploaded;
					echo "<p class='error'>Query Failed for [{$fileName}]</p>";
					continue;
				}
				$count = mysqli_num_rows($result);
				if($count > 0){
					++$notUploaded;
					echo "<p class='error'>[{$fileName}] already exists</p>";
					continue;
				}*/

				//upload file
				$query = "INSERT INTO test.uploads
										VALUES ({$id},'{$authorID}','{$file}','{$location}',{$w},{$h});";
				if(!(mysqli_query($conn,$query))){
					++$notUploaded;
					echo "<p class='error'>Could not Add Record of [{$fileName}].</p>";
					continue;
				}
				//skip if no tags are there
				if($tags==""){
					echo '<p class="success">'.$fileName.' was uploaded successfully<br></p>';
					continue;
				}
				/*//get iamgeID to assign tags
				$query = "SELECT imgID
											FROM test.uploads
											WHERE name = '{$fileName}';";
				$result = mysqli_query($conn,$query);
				if(!($result)){
					echo "<p class='error'>Query Failed for [{$fileName}]</p>";
					continue;
				}
				$row = mysqli_fetch_assoc($result);
				if($row == NULL){
					echo "<p class='error'>photo ID of [{$fileName}] not found</p>";
					continue;
				}
				*/
				$imgID = $id;

				//assign tags
				for($j=0;$j<sizeof($tagsArray);$j++){
					$tag = trim($tagsArray[$j]);
					$query = "INSERT INTO test.tags
												VALUES ('{$imgID}','{$tag}');";
					if(!(mysqli_query($conn,$query))){
						//echo "<p class='error'>Could not Add Tag of [{$fileName}].<br>{$tag} could be already existing.</p>";
						continue;
					}
				}
				
				echo '<p class="success">'.$fileName.' was uploaded successfully<br></p>';
			}
			else{
				++$notUploaded;
				echo '<p class="error">'.$fileName.' was not uploaded<br></p>';
			}
		}
		if($total - $notUploaded > 0)
            
			echo '<p class="success">'.($total - $notUploaded).' of '.$total.' uploaded successfully.<br></p>';
        
		else echo '<p class="error">'.($total - $notUploaded).' of '.$total.' uploaded.<br></p>';
        $_SESSION['imgUploadtext'] = ($total - $notUploaded).' of '.$total.' image(s) uploaded successfully.';
		echo '</div>'; 
	}
}
