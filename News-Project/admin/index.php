<?php
    session_start();
    if(isset($_SESSION['username'])){
        if((time()-$_SESSION['last_login'])<=86400) //last_login is in between 24 hours
            header('Location: post.php');
        else{
            session_unset();
            session_destroy();
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="index.php" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->
                        <?php
                            if(isset($_POST['login'])){
                                $conn = mysqli_connect("localhost","root","","news") or die("Connection Unsuccessful");

                                $username = mysqli_real_escape_string($conn,$_POST['username']);
                                $password = md5(mysqli_real_escape_string($conn,$_POST['password']));

                                $query = "Select username From user Where username='{$username}' And password='{$password}';";
                                $result = mysqli_query($conn,$query) or die("Query Failure.");
                                $row = mysqli_fetch_assoc($result);
                                if($row == NULL) die("<h3>Invalid username/password.<br>Please Retry.</h3><br>");
                                $username = $row['username'];
                                echo "<h3>Login Successful.</h3><br>";

                                $_SESSION['username'] = $username;
                                $_SESSION['last_login'] = time();
                                header('Location: post.php');
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
