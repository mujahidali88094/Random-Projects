<?php $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful"); ?>
<?php
require_once "session.php";

//provides all photos data in json format

$sql = "SELECT u.userid,CONCAT(u.firstname,' ',u.lastname) as username,imgid,name,u.profilepic ,(SELECT count(*) FROM views WHERE views.imgid=uploads.imgID) as noOfViews
					FROM uploads
					INNER JOIN user u ON uploads.userID=u.userId
					ORDER BY noOfViews DESC;" ;
$result = mysqli_query($conn,$sql) or die("Query Failed.");
$noOfRows = mysqli_num_rows($result);
$lll="";
$jsrows= array();
if( $noOfRows > 0){
    while($row = mysqli_fetch_assoc($result)){
        $kk = "SELECT tag from tags where imgid = {$row['imgid']}";
        $r = $conn->query($kk);
        $s = "";
        if ($r->num_rows > 0)
            while($ro = mysqli_fetch_assoc($r)){  
                $s = $s.$ro['tag']."-";

            }
        $s = str_replace(" ","-",$s).$row['imgid'];
        if(isset($_SESSION['sessUser'])){
            $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$row['imgid']};";

            $ur = mysqli_query($conn,$us) or die("Query Failed.");
            $uR = mysqli_num_rows($ur);


            if($uR>0) $lll = "dislike";
            else $lll = "like";
        }
        else
            $lll = "like";
        $row['s'] = $s;
        $row['lll'] = $lll;

        $jsrows[] = $row;
    }
}
echo json_encode($jsrows);
?>