<?php
include 'session.php';
//$conn = mysqli_connect('localhost','id12553108_saadi','I$|IOm6lM9TY$Ic3','id12553108_pexels') or die("Connection Unsuccessful");
$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");





use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'p/src/Exception.php';
require_once 'p/src/PHPMailer.php';
require_once 'p/src/SMTP.php';


function generate_string($s) {
    $input = '0123456789abcdefghijklkskfjsfmkfkdsfkmmnopqrstuvwxyzABCDEgdggkgjfkgvmdkFGHIJKLMNOPQRSTUVWXYZ';
    $strength = $s;

    $input_length = strlen($input);$random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT token FROM fp WHERE token='$random_string' LIMIT 1";
    $result5 = $conn->query($sql);
    if ($result5->num_rows > 0) return generate_string();

    return $random_string;
}

function generate_string_2($s) {
    $input = '0123456789abcdefghijklkskfjsfmkfkdsfkmmnopqrstuvwxyzABCDEgdggkgjfkgvmdkFGHIJKLMNOPQRSTUVWXYZ';
    $strength = $s;

    $input_length = strlen($input);$random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT c_id FROM collections WHERE c_id='$random_string' LIMIT 1";
    $result5 = $conn->query($sql);
    if ($result5->num_rows > 0) return generate_string();

    return $random_string;
}



function getUniqueId(){

    $k = random_int(11111111, 999999999);

    $u = "Select userId From user Where userId='{$k}';";

    $conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");    
    $ur = mysqli_query($conn,$u) or die("Database Error");

    $uR = mysqli_num_rows($ur);

    if($uR<1) 
        return $k;
    else 
        return getUniqueId();

}


if(isset($_POST['deleteCollection'])){

    $cid = $_POST['cid'];
    $qq = "DELETE FROM collections where c_id = '{$cid}'";
    $ress = mysqli_query($conn,$qq) or die("Some error occured, please inform us on info@pexels.pk");
    $qq = "DELETE FROM collection_content where c_id = '{$cid}'";
    $ress = mysqli_query($conn,$qq) or die("Some error occured, please inform us on info@pexels.pk");

    $_SESSION['collectionDeleted'] = 1;

    die("success");
}

if(isset($_POST['updateCollection'])){
    $cname = $_POST['cname'];
    $cdesc = $_POST['cdesc'];
    $cprivate = (isset($_POST['cprivateCheckbox']))?1:0;
    $cid = $_POST['cid'];
    $us = "UPDATE collections set
        c_name ='{$cname}',
        c_desc ='{$cdesc}',
        private ={$cprivate}

        Where c_id='{$cid}';";

    $ur = mysqli_query($conn,$us) or die("Action Failed.");
    $_SESSION['collectionUpdated'] = 1;

    die("success");
}





if(isset($_POST['downloadimg'])){

    if(isset($_SESSION['sessUser'])){
        $q = "INSERT into downloads(imgid,userid) values ({$_POST['downloadimg']},{$_SESSION{'sessUser'}})";
        $r = $conn->query($q);
        die("success");
    }
    else
        die("Login.");
}





if(isset($_POST['likeimg'])){

    if(isset($_SESSION['sessUser'])){
        $q = "INSERT into likes(imgid,userid) values ({$_POST['likeimg']},{$_SESSION{'sessUser'}})";
        $r = $conn->query($q);
        die("success");
    }
    else
        die("Login.");
}








if(isset($_POST['user']) && isset($_POST['getFollowers'])){
    $us = "Select * From follows Where followed={$_POST['user']};";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");
    $uR = mysqli_num_rows($ur);


    $f = $uR;
    echo $f;

    die();
}


if(isset($_POST['imgid']) && isset($_POST['getLikes'])){
    $us = "Select * From likes Where imgid = {$_POST['imgid']};";

    $ur = mysqli_query($conn,$us) or die($conn->error);
    $uR = mysqli_num_rows($ur);


    $f = $uR;
    echo $f;

    die();
}


if(isset($_POST['imgid']) && isset($_POST['getDownloads'])){
    $us = "Select * From downloads Where imgid = {$_POST['imgid']};";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");
    $uR = mysqli_num_rows($ur);


    $f = $uR;
    echo $f;

    die();
}



if(isset($_POST['pid']) && isset($_POST['collection']) && isset($_POST['toggleCollection']) ){

    $pid = $_POST['pid'];
    $cid = $_POST['collection'];
    $q = "Select * from collection_content where c_id = '{$cid}' and imgid = {$pid} ;";
    $res = mysqli_query($conn,$q) or die("Failure");
    if(mysqli_num_rows($res) > 0){
        $qq = "DELETE FROM collection_content where c_id = '{$cid}' and imgid = {$pid} ;";
        $ress = mysqli_query($conn,$qq) or die("Failure");
    }
    else{
        $qq = "INSERT into collection_content (c_id,imgid) VALUES ('{$cid}',{$pid})";
        $ress = mysqli_query($conn,$qq) or die("error");
    }
    $q = "Select * from collection_content where c_id = '{$cid}'  ORDER BY id DESC LIMIT 1 ;";
    $res = mysqli_query($conn,$q) or die("Failure 3");
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            $pid = $row['imgid'];
        }
        $usersql = "Select * From uploads Where imgid='{$pid}' limit 1;";

        $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


        $usernoOfRows = mysqli_num_rows($userresult);


        if($usernoOfRows>0){
            while($row = mysqli_fetch_assoc($userresult)) {
                $name = $row['name'];
            }
            $name = "img.php?pname=".$name;
            die($name);
        }
    }
    else{
        die("9e5dsftr6");
    }



    die();
}



if(isset($_POST['createCollection']) && isset($_POST['id']) && isset($_POST['name'])){

    $cid = generate_string_2(8);
    $q = "INSERT into collections (c_id,userid,c_name) VALUES ('{$cid}',{$_SESSION['sessUser']},'{$_POST['name']}')";
    $r = mysqli_query($conn,$q) or die("error");
    $q = "INSERT into collection_content (c_id,imgid) VALUES ('{$cid}',{$_POST['id']})";
    $r = mysqli_query($conn,$q) or die("error");
    $name;
    $usersql = "Select * From uploads Where imgid='{$_POST['id']}' limit 1;";

    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


    $usernoOfRows = mysqli_num_rows($userresult);


    if($usernoOfRows>0){
        while($row = mysqli_fetch_assoc($userresult)) {
            $name = $row['name'];
        }

        echo
            '
    <li class="p-3 collectionListItem cursor">

    <div class="ListInnerBigDiv border-0 withImg text-center" style="background:url(https://localhost/img/img.php?pname='.$name.');background-position: center;background-size: cover;">

        <div class="check">
            <svg class="ic_cross_tick" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:60px;height:60px;display:block;margin:auto;">
                <g class="cross_tick_container" transform="translate(12,12)">
                    <g class="cross_tick_container_rotate" transform="rotate(0)">
                        <g class="cross_tick_container_translate" transform="translate(-12,-12)">
                            <path class="cross_tick_path" stroke="#fff" stroke-width="5" stroke-linecap="square" d="M6.4 6.4l11.2 11.2m-11.2 0L17.6 6.4">

                                <animate class="tick_to_cross_path_animation" attributeName="d" begin="indefinite" dur="300ms" calcMode="spline" keyTimes="0;1" keySplines="0.4 0 0.2 1" fill="freeze" values="M4.8,13.4 L9,17.6 M10.4,16.2 L19.6,7;M6.4,6.4 L17.6,17.6 M6.4,17.6 L17.6,6.4"></animate>
                                <animate class="cross_to_tick_path_animation" attributeName="d" begin="indefinite" dur="300ms" calcMode="spline" keyTimes="0;1" keySplines="0.4 0 0.2 1" fill="freeze" values="M6.4,6.4 L17.6,17.6 M6.4,17.6 L17.6,6.4;M4.8,13.4 L9,17.6 M10.4,16.2 L19.6,7"></animate>
                            </path>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
    </div>
    <div  class="p-3 listDrop text-white ListBottomText ">'.$_POST['name'].'</div>
</li> 
';   
    }


    else
        die("error");




    die();




}


if(isset($_POST['user']) && isset($_POST['command'])){

    $u = $_POST['user'];
    $c = $_POST['command'];

    if(!isset($_SESSION['sessUser']))
        die("Please Login First.");

    if($_SESSION['sessUser'] == $u)
        die("Self Follow Error");


    if($c == "follow"){
        $us = "Select * From follows Where follower={$_SESSION['sessUser']} AND followed={$u};";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0) die("Already Following");

        $query = "INSERT INTO follows(follower,followed)
        Values({$_SESSION['sessUser']},{$u}) ";

        mysqli_query($conn,$query) or die($conn -> error);
        die("success");


    }
    elseif ($c == "unfollow")
    {
        $us = "Select * From follows Where follower={$_SESSION['sessUser']} AND followed={$u};";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0) {
            $query = "Delete from follows where follower = {$_SESSION['sessUser']} and followed = {$u};";
            $r = mysqli_query($conn,$query) or die("You were not following the user.");
            die("success");
        }

    }



    die();
}






if(isset($_POST['imgid']) && isset($_POST['command'])){

    $u = $_POST['imgid'];
    $c = $_POST['command'];

    if(!isset($_SESSION['sessUser']))
        die("Please Login First.");

    if($_SESSION['sessUser'] == $u)
        die("Self image like error");


    if($c == "like"){
        $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$u};";

        $ur = mysqli_query($conn,$us) or die($conn -> error);
        $uR = mysqli_num_rows($ur);


        if($uR>0) die("Already Liked");

        $query = "INSERT INTO likes(userid,imgid)
        Values({$_SESSION['sessUser']},{$u}) ";

        mysqli_query($conn,$query) or die($conn -> error);
        die("success");


    }
    else if ($c == "dislike")
    {
        $us = "Select * From likes Where userid={$_SESSION['sessUser']} AND imgid={$u};";

        $ur = mysqli_query($conn,$us) or die($conn -> error);
        $uR = mysqli_num_rows($ur);


        if($uR>0) {
            $query = "Delete from likes where userid = {$_SESSION['sessUser']} and imgid = {$u};";
            $r = mysqli_query($conn,$query);
            die("success");
        }

    }



    die();
}







if(isset($_POST['login']) && !isset($_SESSION['sessUser'])){

    $email = $_POST['loginemail'];

    $password = md5($_POST['loginpassword']);

    $usersql = "Select password From user Where email='{$email}';";

    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
    $usernoOfRows = mysqli_num_rows($userresult);

    if($usernoOfRows>0){

        $us = "Select userId From user Where email='{$email}' AND password='{$password}';";

        $ur = mysqli_query($conn,$us) or die("Query Failed.");
        $uR = mysqli_num_rows($ur);


        if($uR>0){

            while($row = mysqli_fetch_assoc($ur)) $id = $row['userId'];
            $_SESSION['sessUser'] = $id;
            die("success");

        }
        else 
            die("Wrong Password.");


    }
    else
        die("You are not registered with us.");

    die("Error");
} 

if(isset($_POST['signup']) && !isset($_SESSION['sessUser'])){

    $fname = $_POST['fName'];

    $lname = $_POST['lName'];

    $email = $_POST['email'];

    $linked = 0;

    if(isset($_POST['linked'])){

        $linked = 1;

        $password = md5(md5(md5(random_int(159988888899,99999999999999))));

    }
    else
        $password = md5($_POST['password']);

    $usersql = "Select userId From user Where email='{$email}';";

    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


    $usernoOfRows = mysqli_num_rows($userresult);
    $id = getUniqueId();
    if($usernoOfRows>0)
        if($linked) {  
            while($row = mysqli_fetch_assoc($userresult)) {
                $id = $row['userId'];
            }
            $_SESSION['sessUser'] = $id;
            die("success");
        }        
    else if($usernoOfRows>0) 
        die("Email already registered,try logging in.");





    $query = "INSERT INTO user(userId,firstName,lastName,email,password,linkedwithfacebook)
        Values({$id}, '{$fname}','{$lname}','{$email}','{$password}','{$linked}'); ";

    mysqli_query($conn,$query) or die($conn -> error);

    $_SESSION['sessUser'] = $id;

    die("success");

}

if(isset($_POST['fp']) && !isset($_SESSION['sessUser'])){

    $email = $_POST['forgEmail'];
    $usersql = "Select userId From user Where email='{$email}';";
    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
    $usernoOfRows = mysqli_num_rows($userresult);
    if($usernoOfRows>0){

        while($row = mysqli_fetch_assoc($userresult))
            $id = $row['userId'];


        $us= "Delete From fp Where id='{$id}';";
        $ur = mysqli_query($conn,$us) or die("Query Failed.");

        $token = generate_string(14);

        $query = "INSERT INTO fp(token,id)
           Values('{$token}', {$id}); ";

        mysqli_query($conn,$query) or die($conn -> error);

        $link = "localhost/img/forgot.php?accesstoken=".$token;


        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = '';
        $mail->Port = 587;
        $mail->Username = 'pexelsteam@gmail.com'; // YOUR gmail email
        $mail->Password = 'SaadPexelsMujahid'; // YOUR gmail password
        $mail->setFrom('pexelsteam@gmail.com', 'Pexels PR Team');
        $mail->addAddress($email, 'Recover your Password');
        $mail->IsHTML(true);
        $mail->WordWrap = 50;

        $mail->Subject = 'Reset your password';

        $message_body = '
            <div style="padding: 12px;border: 1px solid #ccc;border-radius: 5px;">    
            <div style="margin: auto;width: 100px; height: 100px;background: cadetblue; text-align: center; border-radius: 50px;box-shadow: 6px 9px 47px -8px  cadetblue;">

            <div style="text-shadow: 0 0 white;padding-top: 25px;font-size: 1.8rem;font-weight: bolder;font-family: monospace;">
            Pexels
            </div>
            </div>
            <hr>
            <br>
            Click the button bellow to redirect you to reset page.
            <br>

            <span style="margin-top: 35px;width: 100%;display: block;text-align: center;">
            <a href="'.$link.'" target="_blank" style="background: cadetblue;color: white;padding: 15px;border-bottom: none;">
            Reset Password
            </a>
            </span>

            <br>
            <br>

            <span>
            This link is generated to reset your password. It is not autogenerated by the machine rather someone requested on the pexels website for it, if you have not requested for password reset please ignore this mail and do not share this mail with anyone.<br>

            <b>Note: This link would work only once.</b>
            </span>
            </div>

            <p>
            Sincerely,<br>
            Pexels team<br>
            Dev Team Head: Mujahid<br>
            Suppervisor: Saadi
            </p>


            ';

        $mail->Body = $message_body;

        if($mail->send()) die("success");
        else
            die("Some error Occured, Please try later.");


    }
    else
        die("You are not registered with us!");
}


if(isset($_POST['fpf']) && !isset($_SESSION['sessUser'])){
    $pass = $_POST['pass'];
    $confirmpass = $_POST['confirmPass'];
    $accessToken = $_POST['accessToken'];

    if($accessToken == "")
        die("Some error Occured.");

    if(strlen($accessToken) < 14 )
        die("Some error Occured.");
    if($pass != $confirmpass)
        die("Confirm Password is not same as password.");
    if($pass == $confirmpass && strlen($pass) < 8)
        die("Password's length should be 8 or greater.");

    $usersql = "Select id From fp Where token='{$accessToken}';";
    $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");
    $usernoOfRows = mysqli_num_rows($userresult);

    if($usernoOfRows>0){
        while($row = mysqli_fetch_assoc($userresult))
            $id = $row['id'];
        $pass = md5($pass);
        $us = "UPDATE user set password ='{$pass}' Where userId={$id};";
        $ur = mysqli_query($conn,$us) or die("Action Failed.");

        $us= "Delete From fp Where id='{$id}';";
        $ur = mysqli_query($conn,$us) or die("Query Failed.");

        die("success");



    }
    else
        die("Some error occured.");


}



?>



<?php
/*$date=date_create();

$diff = date_timestamp_get($date);
echo "  ".$diff."   ".time()."   ";
$h = $diff / 3600 % 24;
 $m = $diff / 60 % 60; 
 $s = $diff % 60;
 echo $h.":".$m.":".$s.".";  
*/?>