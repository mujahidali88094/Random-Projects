<?php $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful"); ?>
<?php

include 'session.php';
if(isset($_SESSION['sessUser'])){
    $loggedIn = true;
    $query = "Select * From user Where userId=".$_SESSION['sessUser'].";" ;
    $queryResult = mysqli_query($conn,$query);
    $queryRow = mysqli_fetch_assoc($queryResult);
    $profilePic = $queryRow["profilePic"];
}
else{
    $loggedIn = false;
    $profilePic = "photos/user.png";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Pexels</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="styles/bootstrap.min.css" class="stylesheet">
        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/photo.css">

        <script src="js/jquery-3.6.0.js"></script>
        <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

        <script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <nav class="nav p-2 sticky-top">
            <a href="#" class="logoName d-flex anchorUnstyled h5 m-0 mr-auto">
                <svg xmlns="https://www.w3.org/2000/svg" width="2.5rem" height="2.5rem" viewBox="0 0 32 32">
                    <path d="M2 0h28a2 2 0 0 1 2 2v28a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" fill="#05A081"></path>
                    <path d="M13 21h3.863v-3.752h1.167a3.124 3.124 0 1 0 0-6.248H13v10zm5.863 2H11V9h7.03a5.124 5.124 0 0 1 .833 10.18V23z" fill="#fff"></path>
                </svg>
                <span class="font-weight-bolder align-self-center px-2">Pexels</span>
            </a>
            <form class="searchBox d-none mx-auto px-3 position-relative" id="navSearchBox" action="search.php" method="GET" onmouseenter="showTags();" onmouseleave="showTags();">
				<input type="text" placeholder="Search for Free Images" name="q" onkeyup="this.onchange();" onchange="synchronizeWithInput(1);">
				<button type="submit" class="btnNoStyle p-2"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></button>
				<div class="tagsPopup d-none">
					<div style="height:35px"></div>
				</div>
			</form>
            <div class="position-relative" id="explore">
                <a href="#" class="anchorUnstyled">Explore</a>
                <div class="dropdown">
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Discover Photos</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Popular Searches</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Leaderboard</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Challenges</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Pexels Blog</a></div>
                </div>
            </div>
            <a href="#" class="anchorUnstyled" id="license">License</a>
            <div class="position-relative" id="notifications">
                <button class="btnNoStyle">
                    <svg xmlns="https://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" 
                        fill="white"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/></svg>
                </button>
                <div class="dropdown" id="notify">
                    <h5>Notifications</h5>
                    <div class="d-flex" id="notifyContent">
                        <div class="imgWrapper">
                            <img src="photos/cat.jpg">
                        </div>
                        <div class="small">
                            <p class="mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae cumque ea 
                                expedita quibusdam numquam asperiores eos nulla molestiae quia consectetur fugit.
                            </p>
                            <ul class="pl-2">
                                <li><a href="#" class="anchorUnstyled"><b>Uploading your photos</b></a></li>
                                <li><a href="#" class="anchorUnstyled"><b>Following photographers that inspire you</b></a></li>
                                <li><a href="#" class="anchorUnstyled"><b>Discovering and liking trending photos</b></a></li>
                            </ul>
                            <span>5 months</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="navProfile" class="position-relative">
                <a href="#" class="d-flex align-items-center">
                    <div class="imgWrapper profileLogo" style="max-height:2rem; max-width:2rem">
                        <img src="<?php	echo $profilePic;	?>" class="mb-0" onerror="this.onerror=null;this.src='photos/user.png';" >
                    </div>
                    <svg xmlns="https://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="white"><path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6-1.41-1.41z"/></svg>
                </a>
                <div class="dropdown">
                    <?php 
                    if($loggedIn){
                    ?>
                    <div class="dropdownListItem"><a href="https://localhost/img/me" class="anchorUnstyled">Profile</a></div>
                    <div class="dropdownListItem"><a href="https://localhost/img/me/collections" class="anchorUnstyled">Collections</a></div>
                    <div class="dropdownListItem"><a href="logout.php" class="anchorUnstyled">Logout</a></div>
                    <div class="separator"></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Settings</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Change Language</a></div>
                    <?php
                    }else{
                    ?>
                    <div class="dropdownListItem"><a href="join.php?login=yes" class="anchorUnstyled">Login</a></div>
                    <div class="dropdownListItem"><a href="join.php" class="anchorUnstyled">Signup</a></div>
                    <div class="dropdownListItem"><a href="#" class="anchorUnstyled">Change Language</a></div>
                    <?php 
                    }
                    ?>
                    <div class="separator"></div>
                    <div class="dropdownListItem socialLinks">
                        <a href="#" class="anchorUnstyled"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#" class="anchorUnstyled"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" class="anchorUnstyled"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" class="anchorUnstyled"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        <a href="#" class="anchorUnstyled"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                    </div>				
                </div>
            </div>
            <div class="bars">
                <button class="btn btnNoStyle"><i class="fa fa-bars" aria-hidden="true"></i></button>
            </div>
            <button class="btn btnPrimary" id="uploadButton" onclick="location.href='ui/uploadImages.php'">Upload</button>
        </nav>
        <!-- nav-dropdown on small devices  -->
        <div id="barsMenu" class="p-3 d-none">
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Home</a></div>
            <div class="separatorSingle"></div>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Discover Photos</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Challenges</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Leaderboard</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Pexels Blog</a></div>
            <div class="separatorSingle"></div>
            <?php if ($loggedIn){ ?>
            <div class="barsMenuItem dropdownListItem"><a href="https://localhost/img/me" class="anchorUnstyled">Your Profile</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="https://localhost/img/me/collections" class="anchorUnstyled">Collections</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="ui/uploadImages.php" class="anchorUnstyled">Upload</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="logout.php" class="anchorUnstyled">Logout</a></div>
            <?php }else{ ?>
            <div class="barsMenuItem dropdownListItem"><a href="join.php?login=yes" class="anchorUnstyled">Login</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="join.php" class="anchorUnstyled">Join</a></div>
            <?php } ?>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">License</a></div>
            <div class="barsMenuItem dropdownListItem"><a href="#" class="anchorUnstyled">Settings</a></div>
            <div class="separatorSingle"></div>
            <div class="barsMenuItem socialLinks dropdownListItem">
                <a href="#" class="anchorUnstyled"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#" class="anchorUnstyled"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#" class="anchorUnstyled"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#" class="anchorUnstyled"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                <a href="#" class="anchorUnstyled"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
            </div>	
        </div>

        <section id="intro">
            <div id="introContent">
                <script>
					function showTags(){
						$(".tagsPopup").toggleClass("d-none d-block");
					}
					function addTagToSearch(){
						let e = event ;
						subject = $("input[name='q']");
						subject[0].value = subject[0].value + e.target.text +' ';
						subject[1].value = subject[1].value + e.target.text +' ';			
					}
					function placeTags(){
						var tagsCode="";
						for(let i=0;i<popularTags.length;i++){
							code = '<div class="tagsPopupItem"><a href="javascript:;" class="anchorUnstyled">'+popularTags[i]+'</a></div>';
							tagsCode += code ;
						}
						$(".tagsPopup").append(tagsCode);
						var allItems = document.querySelectorAll('.tagsPopupItem>a');
						for(let i=0;i<allItems.length;i++) allItems[i].addEventListener('click', addTagToSearch);
					}
					var popularTags;
					$.post("popularTags.php",{},(data)=>{
						popularTags = JSON.parse(data);
						placeTags();
					});
				</script>
                <h1>The best free stock photos & videos shared by talented creators.</h1>
                <form class="searchBox px-3 position-relative" action="search.php" method="GET" onmouseenter="showTags();" onmouseleave="showTags();">
					<input type="text" placeholder="Search for Free Images" name="q" onkeyup="this.onchange();" onchange="synchronizeWithInput(0);">
					<button type="submit" class="btnNoStyle p-2"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></button>
					<div class="tagsPopup d-none">
						<div style="height:35px"></div>
					</div>
				</form>
                <p id="suggested">Suggested:
                    <?php
                    $sql11 = "SELECT DISTINCT tag FROM tags LIMIT 7";
                    $result11 = mysqli_query($conn,$sql11);
                    while($row11 = mysqli_fetch_assoc($result11)){
                        $tag = $row11["tag"];
                        echo ' <a class="anchorUnstyled" href="https://localhost/img/search.php?q='.$tag.'">'.$tag.'</a>';
                    }
                    ?>
            </div>
        </section>

        <section id="main">
            <div id="tabs">
                <div><a href="#" class="anchorUnstyled activeTabLink" id="homeLink">Home</a></div>
                <div><a href="#" class="anchorUnstyled" id="discoverLink">Discover</a></div>
                <div><a href="#" class="anchorUnstyled" id="leaderboardLink">Leaderboard</a></div>
                <div><a href="#" class="anchorUnstyled" id="challengesLink">Challenges</a></div>
            </div>

            <section id="homeContent">
                <h4>Free Stock Photos</h4>
                <div id="contentWrapper" class="text-center">
                    <div class="card-columns">
                        <script>
                            //requesting photos and displaying some
                            var tableRows;
                            $.post(
                                "js_get.php",
                                {},
                                (data)=>{
                                    tableRows = JSON.parse(data);
                                    console.log(tableRows);
                                    getHomePhotos(0,6);
                                    pI();
                                    likeButtons();
                                    collectButtons();
                                    images();
                                }
                            );
                        </script>
                        <script>
                            //provides code for some photos
                            function getHomePhotos(offset,limit){ 
                                var i = offset;
                                var nextOffset = offset+limit; 
                                console.log(offset+" to "+nextOffset);
                                for(; i<(nextOffset) && i<tableRows.length; i++ ){
                                    code = `<div class="photoItem discoverPhotoItem py-2 position-relative text-white">
<img class="imgCard" data-target="`+tableRows[i].s+`" src="https://localhost/img/img.php?pname=`+tableRows[i].name+`" alt="Photo Not Found">

<div class="bottomThings d-none w-100 align-items-center position-absolute p-3" style="bottom:0">
<div class="d-flex align-items-center mr-auto">
<div class="px-1"><img class="rounded-circle" onerror="solvePic(this)" src="https://localhost/img/`+tableRows[i].profilepic+`" alt="dp" style="width:30px; height:30px"></div>
<span class="px-1"><a class="text-decoration-none" style="color:inherit;" target="_blank" href="https://localhost/img/@`+tableRows[i].userid+`">`+tableRows[i].username+`</a></span>
                            </div>
<div class="options d-flex ml-auto">
<a download="`+tableRows[i].s+`.jpg" data-id="`+tableRows[i].imgid+`" href="https://localhost/img/img.php?pname=`+tableRows[i].name+`&Original=" class="downs anchorUnstyled px-1 fa fa-download mt-2">

                            </a>
<button data-id="`+tableRows[i].imgid+`" class="collectButton btn py-0 px-1">
<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                            </button>
<button  data-imgid="`+tableRows[i].imgid+`"  data-command="`+tableRows[i].lll+`" class="likeButton btn py-0 px-1" style="background:none!important;">
<i class="fa   icoHeart `+((tableRows[i].lll == "dislike")?`fa-heart text-danger`:`fa-heart-o text-white`)+`" style="font-size: 22px;margin-top: 4px;background:none!important;"></i>
                            </button>
                            </div>
                            </div>
                            </div>

`;
                                    $("#homeContent .card-columns").append(code);
                                }
                                if( i != tableRows.length ){
                                    let loadMoreButton = '<button class="loadMore btn btnPrimary text-center my-3" data-offset="'+nextOffset+'" data-limit="'+limit+'" onclick="loadMore();">Load More</button>';
                                    $("#contentWrapper").append(loadMoreButton);
                                }


                            }
                        </script>

                    </div>
                </div>
            </section>
            <section id="discoverContent" class="m-auto d-none" style="max-width:1000px">
                <div class="discoverUnitWrapper">
                    <h1>All Collections</h1>
                    <?php
                    class collection{
                        public $id;
                        public $name;
                        public $quantity;
                        public $imgNames = array();
                        function __construct($i,$n,$q,$iN){
                            $this->id = $i;
                            $this->name = $n;
                            $this->quantity = $q;
                            $this->imgNames = $iN;
                        }
                    }

                    $sql2 = "SELECT *,(SELECT count(*) FROM c_views WHERE c_views.cid=collections.c_id) as noOfViews
										FROM collections
										INNER JOIN user ON collections.userid=user.userId
										ORDER BY noOfViews DESC
										LIMIT 3;" ;
                    $result2 = mysqli_query($conn,$sql2) or die($conn->error);

                    $arrOfCollections = array();
                    $arrOfTags = array();
                    if(mysqli_num_rows($result2) > 0){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $cID = $row2["c_id"];
                            $c_name = $row2["c_name"];

                            $sql3 = "SELECT * FROM collection_content
												INNER JOIN uploads ON collection_content.imgid=uploads.imgID
												WHERE c_id='{$cID}' LIMIT 5;";
                            $result3 = mysqli_query($conn,$sql3);
                            $quantity = mysqli_num_rows($result3);
                            $fiveImagesNames = array();

                            if($quantity > 0){
                                while($row3 = mysqli_fetch_assoc($result3)){
                                    array_push($fiveImagesNames,$row3["name"]);

                                    $imgId = $row3["imgID"];
                                    $sql4 = "SELECT tag FROM tags WHERE tags.imgID='{$imgId}';";
                                    $result4 = mysqli_query($conn,$sql4);
                                    while($row4=mysqli_fetch_array($result4)){
                                        if(!in_array($row4["tag"],$arrOfTags))
                                            array_push($arrOfTags,$row4["tag"]);
                                    }
                                }
                            }
                            $collectionObj = new collection($cID,$c_name,$quantity,$fiveImagesNames);
                            array_push($arrOfCollections,$collectionObj);
                        }
                    }
                    ?>
                    <div class="tagsList px-2 pb-3">
                        <?php
                        for($count=0;$count<sizeof($arrOfTags);$count++){
                            $currTag = $arrOfTags[$count];
                            echo '<div class="tag"><a href="#" class="anchorUnstyled">'.$currTag.'</a></div>';
                        }
                        ?>
                    </div>
                    <div class="gridCollection pb-3">
                        <?php
                        for($count=0;$count<sizeof($arrOfCollections);$count++){
                            $useless = 'https://localhost/img/collections/'.str_replace(' ','-',$arrOfCollections[$count]->name).'-'.$arrOfCollections[$count]->id ;
                        ?>
                        <div class="collectionCard w-100" onclick="location.href='<?php echo $useless; ?>'" >
                            <div class="p-2">
                                <div class="collectionImagesWrapper">
                                    <div class="bigImage mb-1">
                                        <div class="imgWrapper"><img src="https://localhost/img/img.php?pname=<?php echo $arrOfCollections[$count]->imgNames[0]; ?>" onerror="this.onerror=null;this.src='photos/camera.png';"></div>
                                    </div>
                                    <div class="imagesGroup d-flex mb-3">
                                        <div class="imgWrapper pr-1"><img src="https://localhost/img/img.php?pname=<?php echo $arrOfCollections[$count]->imgNames[1]; ?>" onerror="this.onerror=null;this.src='photos/camera.png';"></div>
                                        <div class="imgWrapper pr-1"><img src="https://localhost/img/img.php?pname=<?php echo $arrOfCollections[$count]->imgNames[2]; ?>" onerror="this.onerror=null;this.src='photos/camera.png';"></div>
                                        <div class="imgWrapper pr-1"><img src="https://localhost/img/img.php?pname=<?php echo $arrOfCollections[$count]->imgNames[3]; ?>" onerror="this.onerror=null;this.src='photos/camera.png';"></div>
                                        <div class="imgWrapper"><img src="https://localhost/img/img.php?pname=<?php echo $arrOfCollections[$count]->imgNames[4]; ?>" onerror="this.onerror=null;this.src='photos/camera.png';"></div>
                                    </div>
                                </div>
                                <div class="d-flex px-2">
                                    <span class="mr-auto"><?php echo ucwords($arrOfCollections[$count]->name); ?></span>
                                    <span class="ml-auto">
                                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"></path></svg>
                                        <span><?php echo $arrOfCollections[$count]->quantity; ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                $sql5 = "SELECT tag FROM `tags` 
										GROUP BY tag
										ORDER BY count(*) DESC
										LIMIT 5;" ;
                $result5 = mysqli_query($conn,$sql5);
                if(mysqli_num_rows($result5)>0){
                    while($row5 = mysqli_fetch_assoc($result5)){
                        $currentTag = $row5["tag"];
                ?>
                <div class="discoverPhotosUnitWrapper">
                    <h1><a href="localhost/img/search/<?php echo $currentTag; ?>" class="anchorUnstyled"><?php echo ucfirst($currentTag); ?></a></h1>
                    <div class="discoverPhotos">
                        <?php
                        $sql = "SELECT * FROM tags
											INNER JOIN uploads ON tags.imgID = uploads.imgID
											INNER JOIN user ON uploads.userID = user.userId
											Where LOWER(tags.tag) = LOWER('{$currentTag}') LIMIT 3;" ;
                        $result = mysqli_query($conn,$sql) or die("Query Failed.");
                        $noOfRows = mysqli_num_rows($result);
                        if( $noOfRows > 0){
                            while($row = mysqli_fetch_assoc($result)){

                                $kk = "SELECT tag from tags where imgid = {$row['imgID']}";
                                $r = $conn->query($kk);
                                $s = "";$lll="";
                                if ($r->num_rows > 0)
                                    while($ro = mysqli_fetch_assoc($r)){  
                                        $s = $s.$ro['tag']."-";

                                    }
                                $s = str_replace(" ","-",$s).$row['imgID'];
                                if(isset($_SESSION['sessUser'])){
                                    $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$row['imgID']};";

                                    $ur = mysqli_query($conn,$us) or die("Query Failed.");
                                    $uR = mysqli_num_rows($ur);


                                    if($uR>0) $lll = "dislike";
                                    else $lll = "like";
                                }
                                else
                                    $lll = "like";

                                $imgid = $row['imgID'];

                                $imgSource = $row["name"];
                                $userId = $row["userID"];
                                $userFirstName = $row["firstName"];
                                $userLastName = $row["lastName"];
                                $userDpSource = $row["profilePic"];
                                if($userDpSource==NULL) $userDpSource='';

                                echo '<div class="photoItem discoverPhotoItem p-2 position-relative text-white">
									<img class="imgCard" data-target="'.$s.'" src="https://localhost/img/img.php?pname='.$imgSource.'" alt="Photo Not Found">

                                <div class="bottomThings d-none w-100 align-items-center position-absolute p-3" style="bottom:0">
                                    <div class="d-flex align-items-center mr-auto">
                                        <div class="px-1"><img class="rounded-circle" onerror="solvePic(this)" src="https://localhost/img/'.$userDpSource.'" alt="dp" style="width:30px; height:30px"></div>
                                        <span class="px-1"><a class="text-decoration-none" style="color:inherit;" target="_blank" href="https://localhost/img/@'.$userId.'">'.$userFirstName." ".$userLastName.'</a></span>
                                    </div>
                                    <div class="options d-flex ml-auto">
                                        <a download="'.$s.'.jpg" data-id="'.$imgid.'" href="https://localhost/img/img.php?pname='.$imgSource.'&Original=" class="downs anchorUnstyled px-1 fa fa-download mt-2">

                                    </a>
                                        <button data-id="'.$row['imgID'].'" class="collectButton btn py-0 px-1">
                                            <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                                        </button>
                                        <button  data-imgid="'.$row['imgID'].'"  data-command="'.$lll.'" class="likeButton btn py-0 px-1" style="background:none!important;">
                                            <i class="fa   icoHeart '.(($lll=="dislike")?'fa-heart text-danger':'fa-heart-o text-white').'" style="font-size: 22px;margin-top: 4px;background:none!important;"></i>
                                        </button>
                                    </div>
                                </div>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </section>
            <section id="leaderboardContent" class="d-none"></section>
            <section id="challengesContent" class="d-none"></section>
        </section>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen p-5">
                <div class="modal-content rounded">
                    <span class="position-absolute rounded-top" style="cursor: pointer;color: black!important;right: 0px;z-index: 1050;top: -25px;font-size: 17px;width: 25px;text-align: center;height: 25px;background: white;" onclick="closeModal()">X</span>
                    <div class="modal-body" id="profileLoadModal" style="scroll-behavior:smooth ;">

                    </div>
                </div>
            </div>
        </div>


        <?php include 'u.php'; ?>

        <script>
            function synchronizeWithInput(target){
			current = target ? 0 : 1 ;
			subject = $("input[name='q']");
			subject[target].value = subject[current].value ;
            }
            function loadMore(){ // for home tab content
                let animation = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
                $("#contentWrapper").append(animation);
                let offset1=parseInt(event.target.dataset.offset);
                let limit1=parseInt(event.target.dataset.limit);
                event.target.remove();
                getHomePhotos(offset1,limit1);
                if($("#homeContent .lds-ellipsis").length){
                    $("#homeContent .lds-ellipsis").remove();
                }
            }

            $(document).ready(()=>{
                pI();
                likeButtons();
                collectButtons();
                images();
                //dropdowns on hover in main nav
                $.fn.showDropdown = function (selector){
                    $(selector+' .dropdown').show();
                }
                $.fn.hideDropdown = function (selector){
                    setTimeout(()=>{
                        if(document.querySelector(selector+' .dropdown').matches(':hover')){
                            $(selector+' .dropdown').mouseleave(()=>{
                                setTimeout(()=>{
                                    $(selector+' .dropdown').hide();
                                },200);
                            });
                        }
                        else $(selector+' .dropdown').hide();
                    },200);
                }

                $('#explore').hover(
                    ()=>{$.fn.showDropdown('#explore')},
                    ()=>{$.fn.hideDropdown('#explore')}
                );
                $('#notifications').hover(
                    ()=>{$.fn.showDropdown('#notifications')},
                    ()=>{$.fn.hideDropdown('#notifications')}
                );
                $('#navProfile').hover(
                    ()=>{$.fn.showDropdown('#navProfile')},
                    ()=>{$.fn.hideDropdown('#navProfile')}
                );

                //toggle Menu in small devices
                $('.bars>button').click(()=>{
                    $('#barsMenu').toggleClass("d-none d-flex");
                });

                //nav bar changes on scroll
                $(window).scroll(()=>{
                    let selected = $("#navSearchBox");
                    if(scrollY > 350 ){
                        $("nav").addClass("bg-dark");
                        selected.removeClass("d-none");
                        selected.addClass("d-flex");
                    }
                    else{
                        $("nav").removeClass("bg-dark");
                        selected.removeClass("d-flex");
                        selected.addClass("d-none");
                    }
                });

                //switch content tabs
                $('#tabs a').click((e)=>{
                    $('#tabs a').removeClass('activeTabLink');
                    $(e.currentTarget).addClass('activeTabLink');

                    let target = e.currentTarget.id.substr(0,e.currentTarget.id.indexOf('Link'))+'Content';
                    showthisTabOnly(target);
                });
                function showthisTabOnly(target){
                    const tabs=["homeContent","discoverContent","leaderboardContent","challengesContent"];
                    for(let i=0;i<tabs.length;i++){
                        if(tabs[i] === target){
                            $('section#'+target).removeClass('d-none');
                            $('section#'+target).addClass('d-block');
                        }
                        else{
                            $('section#'+tabs[i]).removeClass('d-block');
                            $('section#'+tabs[i]).addClass('d-none');
                        }
                    }
                }

                //hover on photo

            });	



        </script>
        <script src="js/collection.js"></script>

    </body>

</html>