<?php
if(isset($_GET["q"])){
    $q = $_GET["q"];
}
else{
    die("Invalid Search");
}
	$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");
	$arr = array();
	$arr1 = explode(' ',$q);
	for($i=0;$i<sizeof($arr1);$i++){
		if($arr1[$i] != '' && !in_array($arr1[$i],$arr)) $arr[] = $arr1[$i];
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Search: <?php echo ucwords($q); ?></title>
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
        <section id="header">
            <div class="text-center">
                <h4>Search Results for:</h4>
                <h1><?php echo ucwords($q); ?></h1>
            </div>
        </section>
        <div class="discoverUnitWrapper p-3">
            <h1>Collections</h1>
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

            $subSql = "";
						for($i=0;$i<sizeof($arr);$i++){
							$subSql .= " LOWER(c_name) LIKE LOWER('%{$arr[$i]}%') " ;
							if( $i != sizeof($arr) - 1 ) $subSql .= "OR";
						}
						$sql2 = "SELECT * FROM collections WHERE".$subSql.";";
            $result2 = mysqli_query($conn,$sql2);

            $arrOfCollections = array();

            if(mysqli_num_rows($result2) > 0){
                while($row2 = mysqli_fetch_assoc($result2)){
                    $cID = $row2["c_id"];
                    $c_name = $row2["c_name"];

                    $sql3 = "SELECT * FROM collection_content
									INNER JOIN uploads ON collection_content.imgid=uploads.imgID
									WHERE c_id='{$cID}' LIMIT 5;";
                    $result3 = mysqli_query($conn,$sql3);
                    $quantity = mysqli_num_rows($result3);
                    if($quantity > 0){
                        $fiveImagesNames = array();
                        while($row3 = mysqli_fetch_assoc($result3)){
                            array_push($fiveImagesNames,$row3["name"]);
                        }
                    }
                    $collectionObj = new collection($cID,$c_name,$quantity,$fiveImagesNames);
                    array_push($arrOfCollections,$collectionObj);
                }
            }
            ?>
            <div id="searchGridCollection" class="gridCollection pb-3">
                <?php
                if(sizeof($arrOfCollections) == 0) echo "No Related Collections Found";
                for($count=0;$count<sizeof($arrOfCollections) && $count<6 ;$count++){
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"></path></svg>
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
        <div class="separator"></div>
        <section id="homeContent" class="p-3">
            <h1>Photos</h1>
            <div id="contentWrapper" class="text-center">
                <div class="card-columns">
                    <?php
                    $subSql = "";
										for($i=0;$i<sizeof($arr);$i++){
											$subSql .= " LOWER(tags.tag) LIKE LOWER('%{$arr[$i]}%') " ;
											if( $i != sizeof($arr) - 1 ) $subSql .= "OR";
										}
										$query = "SELECT * FROM tags
															INNER JOIN uploads ON tags.imgID = uploads.imgID
															INNER JOIN user ON uploads.userID = user.userId
															WHERE".$subSql.";";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0){
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
                            // echo "<pre>";
                            // print_r($row);
                            // echo "</pre>";
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
                    }else{
                        echo "Nothing Related Found :(";
                    }
                    ?>
                </div>
            </div>
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

        <?php include 'u.php';?>
        <script src="js/collection.js">
        </script>
    </body>
</html>