
<?php 
require_once "session.php";
$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");
if(!isset($_GET['i']) && !isset($k)) die("404");
else if(isset($k) && !isset($_GET['i']));
else $k = $_GET['i'];
$q = "Select * from collections where userid = {$_SESSION['sessUser']}";
$result = mysqli_query($conn,$q) or die("Error1");
$img;$n;$ci;$pid="";$nnn;
if(mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)){
        $ci = $rows['c_id'];
        $na = $rows['c_name'];
        $qqq = "Select * from collection_content where c_id = '{$ci}' and imgid = {$k} limit 1;";
        $ress = mysqli_query($conn,$qqq) or die("Failure");
        if(mysqli_num_rows($ress) > 0){
            while($rrrrr = mysqli_fetch_assoc($ress)){
                $pid = $rrrrr['imgid'];
            }
        }
        else{
            $qqqq = "Select * from collection_content where c_id = '{$ci}'  ORDER BY id DESC LIMIT 1 ;";
            $resss = mysqli_query($conn,$qqqq) or die("Failure 3");
            if(mysqli_num_rows($resss) > 0){
                while($r = mysqli_fetch_assoc($resss)){
                    $pid = $r['imgid'];
                }

            }

        }
        $usersql = "Select * From uploads Where imgid='{$pid}' limit 1;";

        $userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


        $usernoOfRows = mysqli_num_rows($userresult);


        if($usernoOfRows>0)
            while($rrr = mysqli_fetch_assoc($userresult)) {
                $nnn = $rrr['name'];
            }
        if($pid != "" ){
            echo '
    <li class="p-3 collectionListItem cursor">

    <div class="ListInnerBigDiv shadow border-0 text-center withImg" style="background:url(https://localhost/img/img.php?pname='.$nnn.');" data-id="'.$ci.'">
        <div class="check '.(($k == $pid)?'':'d-none').'">
            <svg class="ic_cross_tick" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:60px;height:60px;display:block!important;margin:auto;">
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
    <div  class="p-3 listDrop text-white ListBottomText ">'.$na.'</div>
</li> 
';     

        }
        else
        {
            echo
                '
    <li class="p-3 collectionListItem cursor">

    <div class="ListInnerBigDiv shadow border-0 withImg text-center"  data-id="'.$ci.'">
        <i class="fa fa-camera fa-10x"></i>
        <div class="check d-none">
            <svg class="ic_cross_tick" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:60px;height:60px;display:block!important;margin:auto;">
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
    <div  class="p-3 listDrop text-white ListBottomText ">'.$na.'</div>
</li> 
';   


        }

    }
}
else
    echo '
                                <li onclick="createC()" class="p-3 collectionListItem firstCollec cursor">
                                <div class="ListInnerBigDiv2"></div>
                                <div  class="p-3 listDrop text-muted ListBottomText ">Create Collection</div>
                                </li>
                                ';


?>




