
<?php
require_once 'session.php';
if(!isset($_SESSION['sessUser']))
    die("404");
$co = "";
if(isset($_SESSION['collection']) && $_SESSION['collection'] !== ""){
    $co = $_SESSION['collection'];
    unset($_SESSION['collection']);
}
else
    die("404");

$id;
$cn;
$cd;
$cp;

$conn = mysqli_connect('localhost','root','','test') or die("Connection Unsuccessful");

$usersql = "Select * From collections Where c_id='{$co}' limit 1;";

$userresult = mysqli_query($conn,$usersql) or die("Query Failed.");


$usernoOfRows = mysqli_num_rows($userresult);


if($usernoOfRows>0){
    while($row = mysqli_fetch_assoc($userresult)) {
        $id        = $row["userid"];
        $cn        = $row['c_name'];
        $cd        = $row['c_desc'];
        $cp        = $row['private'];
    }
    
    
    if(isset($_SESSION['sessUser']))
        if($id != $_SESSION['sessUser'])
            die(404);
    $us = "Select * From user Where userId='{$id}' limit 1;";

    $ur = mysqli_query($conn,$us) or die("Query Failed.");


    $uR = mysqli_num_rows($ur);


    if($uR>0){
        while($ro = mysqli_fetch_assoc($ur)) {
            $id        = $ro["userId"];
        }


    }
    else
     die("<h1>404!</h1>");




}
else
     die("<h1>404!</h1>");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://localhost/img/styles/bootstrap.min.css" class="stylesheet">

        <script src="https://kit.fontawesome.com/2eb8fe39e3.js" crossorigin="anonymous"></script>
    </head>
    <body style="overflow: auto;">
        <div class="container-fluid">

            <div class="row p-3">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-2 d-flex justify-content-end align-items-center border-bottom">
                    <div class="px-1 ml-auto">
                        <a class="logo" href="#">
                            <svg xmlns="https://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 32 32">
                                <path d="M2 0h28a2 2 0 0 1 2 2v28a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" fill="#05A081"></path>
                                <path d="M13 21h3.863v-3.752h1.167a3.124 3.124 0 1 0 0-6.248H13v10zm5.863 2H11V9h7.03a5.124 5.124 0 0 1 .833 10.18V23z" fill="#fff"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="px-1 mr-auto">Pexels</div>
                </div>
                <div class="col-12 col-md-6 col-sm-12 col-lg-5 p-5 border ml-auto mr-auto mt-5 rounded shadow">
                    <h2 class="d-block font-weight-bolder mb-5 mt-2 text-center">Edit Collection</h2>
                    <form id="updateCollectionForm">



                        <div class="form-group">
                            <label class="font-weight-bold small">Name</label>
                            <input type="text" class="form-control form-control-sm" required value="<?php echo $cn ;?>" name="cname">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Description</label>
                            <input type="text" class="form-control form-control-sm" value="<?php echo $cd ;?>" name="cdesc">
                        </div>

                        <div class="form-group">
                            <input type="checkbox" <?php echo (!$cp)?"":"checked";?> class="form-check-inline mr-0" style="vertical-align:middle;" name="cprivateCheckbox">
                            <input type="hidden" name="cid" value="<?php echo $co ;?>">
                            <input type="hidden" name="updateCollection" value="true">

                            <label class="font-weight-bold small">Make collection private&nbsp;<i class="fa fa-lock text-muted"></i></label>
                        </div>

                        <hr>
                        <span class="float-left">

                            <input type="submit" value="Update collection" class="btn btn-primary btn-md font-weight-light button_coloured">
                            <a class="btn btn-md btn-light font-weight-light button_coloured button_grey" href="/img/me">Cancel</a>




                        </span>
                    </form>

                    <span class="float-right">
                        <div id="deleteDrop" class="border p-3 position-absolute shadow" style="display: none;right: 90px;bottom: 80px;background: ghostwhite;">
                            <h6 class="font-weight-bold mb-4 small">Confirm</h6>
                            <form id="deleteCollectionForm">
                                <input type="hidden" name="cid" value="<?php echo $co ;?>" >
                                <input type="hidden" name="deleteCollection" value="<?php echo $co ;?>" >

                                <input type="submit" class="deleteCButton btn btn-danger btn-sm" value="Delete Collection" name="deleteCollection">
                            </form>
                        </div>
                        <button title="Delete collection" class="deleteConfirmbutton btn btn-md btn-light font-weight-light button_coloured button_grey">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="22" viewBox="10 8 13 21" version="1.1" style="fill:#d3d3d3;" class="svg-icon">
                                <path d="M22.4157996,14.8870782 L10,14.8870782 L10.8630032,26.1390136 C10.9435002,27.3026104 11.6455093,28.0840468 12.8080364,28.0840468 L19.6077633,28.0840468 C20.7716275,28.0840468 21.4525095,27.3015407 21.5527965,26.1390136 L22.4157996,14.8870782 Z M21.8945746,10.6750237 L12.1667343,8.06756132 C10.6624291,7.66641327 10.2612811,9.15066106 10.0607071,9.9123075 L22.7971577,13.3220659 C22.9977317,12.5804769 23.3988798,11.0761717 21.8945746,10.6750237 Z" fill-rule="evenodd"></path>
                            </svg>
                        </button>



                    </span>
                </div>

            </div>


        </div>
        <script src="https://localhost/img/js/collection.js">

        </script>
        <script>
            $(document).ready(function(){
                $(".deleteConfirmbutton").on("click",function(e){
                    e.preventDefault();
                    $("#deleteDrop").toggle();
                });
                $("body").click(function(e){
                    var a = e.target;
                    if($(a).hasClass('deleteConfirmbutton') || $(a).attr("id") == "deleteDrop" || $(a).parents("#deleteDrop").length !=0 || $(a).parents(".deleteConfirmbutton").length !=0);
                    else
                        $("#deleteDrop").hide(); 
                });  
                $("#updateCollectionForm").submit(function(e){
                    e.preventDefault();
                    var d = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "https://localhost/img/driver.php",
                        data: d,
                    }).done(function(data){

                        if(data == "success")
                            window.location.href = "https://localhost/img/me";
                        else
                            alert(data);
                    });

                });

                $("#deleteCollectionForm").submit(function(e){
                    e.preventDefault();
                    var d = $(this).serialize();
                    console.log(d);
                    $.ajax({
                        type: "POST",
                        url: "https://localhost/img/driver.php",
                        data: d,
                    }).done(function(data){

                        if(data == "success")
                            window.location.href = "https://localhost/img/me";
                        else
                            alert(data);
                    });

                });


            });



        </script>

    </body>
</html>