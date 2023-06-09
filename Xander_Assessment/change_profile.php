<?php
session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
error_reporting(E_ERROR | E_PARSE);
    if(isset($_SESSION['userid']))
    {
        $id = $_SESSION['userid'];
        $login = new Login();
        $login->check_login($id);

        $result = $login->check_login($id);

        if($result){
            $user = new User();
            $user_data = $user->get_data($id);

            $name = "Welcome, " . $user_data['first_name'] . " " . $user_data['last_name'];
            $what = "Logout";
        }else{
            $what = "Login";
            $name = "Welcome to HubbyHive";  
        }
    }else{
        $what = "Login";
        $name = "Welcome to HubbyHive"; 
        header("Location: login.php");
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if($_POST['App']) {
            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
                $id = $_SESSION['userid'];
                $filename = "upload/" . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $filename); 
    
                if(file_exists($filename))
                {
                    $newfile = $filename;
                    $query = "UPDATE users SET profile_image = '$newfile' WHERE userid = '$id' LIMIT 1";
                    $DB = new Database();
                    $DB->save($query);
    
                    header("Location: change_profile.php");
                }
            }else{
                header("Location: change_profile.php");
            }
        }
        if($_POST['Appp']) {
            $newfirst_name = $_POST['newfirst_name'];
            $newlast_name = $_POST['newlast_name'];
            $query = "UPDATE users SET first_name = '$newfirst_name' WHERE userid = '$id' LIMIT 1";
            $query2 = "UPDATE users SET last_name = '$newlast_name' WHERE userid = '$id' LIMIT 1";
            $DB = new Database();
            $DB->save($query);
            $DB->save($query2);
        }

        if($_POST['Approve']) {
            $newpassword = $_POST['newpassword'];
            $query = "UPDATE users SET password = '$newpassword' WHERE userid = '$id' LIMIT 1";
            $DB = new Database();
            $DB->save($query);
        }
    }

?>
<html>
<head>
        <title>HubbyHive</title>

        <!-- ICON -->
        <link rel="icon" type="image/x-icon" href="images/icon/ICON.png">

        <!-- Online CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Tsukimi+Rounded:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=PT+Mono&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

        <!-- CSS -->
        <link rel="stylesheet" href="/Assessment/css/layout1.css">

        <!-- JS -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    </head>

    <style type="text/css">
        *{
            margin: 0;
        }
        body{
            background:#172a46;
        }
        /* PREKOADER */
        @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');
        #preloader{
            background-color: #000;
            background-image: url('images/loader.gif');
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 100;
            animation: load 4s;
            animation-delay: 2s;
        }
        .waviy {
            position: relative;
            top:65%;
            left:35%;
            -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(0,0,0,.2));
            font-size: 60px;
        }
        .waviy span {
            font-family: 'Alfa Slab One', cursive;
            position: relative;
            display: inline-block;
            color: #fff;
            text-transform: uppercase;
            animation: waviy 1s infinite;
            animation-delay: calc(.1s * var(--i));
        
        }
        @keyframes waviy {
            0%,40%,100% {
                transform: translateY(0)
            }
            20% {
                transform: translateY(-20px)
            }
        }
        /* NAV BAR */
        #NAV-BAR{
            background-color: #09192f;
            box-shadow: 0px 0px 5px 1px #030a14;
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        #NAV img{
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        #NAV a{
            font-family: PT Mono;
            text-decoration: none;
            color: #bec9e8;
            font-size: 16px;
        }
        #NAV SPAN{
            font-family: PT Mono;
            color: #64ffdb;
            font-size: 12px;
        }
        #NAV button{
            border: none;
            font-family: PT Mono;
            color: #bec9e8;
        }
        /* MAIN BAR */
        .MAINBAR{
            background:#172a46;
        }
        .MAINBAR h1{
            font-family: PT Mono;
            color: #bec9e8;
        }
        .MAINBAR input{
            font-family: PT Mono;
        }
        .Change{
            background-color: #0a192f;
            border-radius: 1em;
            margin-top: 1em;
        }
        .Change img{
            background-color: #0a192f;
            padding: 0em;
            border-radius: 1em;
            margin: 1em;
        }
        .new{
            margin-top: 1em;
        }
        /* LEFT BAR*/
        .LEFTBAR{
            height: 150vh;
            position: -webkit-sticky;
            position: sticky;
            top: 3.5em;
            z-index: 0;
            background-color: #0a192f;
        }
        /* RIGHT BAR*/
        .RIGHTBAR{
            height: 150vh;
            position: -webkit-sticky;
            position: sticky;
            top: 3.5em;
            z-index: 0;
            background-color: #0a192f;
        }
        
        /* Flickity */
        .carousel-cell{
            margin-left: 0.25rem;
            margin-right: 0.25rem;
        }
        .flickity-page-dots .dot {
            height: 0px;
            width: 0px;
            margin: 0;
            border-radius: 0;
            background-color:none;
        }
        .flickity-button {
            display: none;
        }

    </style>

    <body>
        <div id="preloader">
            <div class="waviy">
                <span style="--i:1">L</span>
                <span style="--i:2">O</span>
                <span style="--i:3">A</span>
                <span style="--i:4">D</span>
                <span style="--i:5">I</span>
                <span style="--i:6">N</span>
                <span style="--i:7">G</span>
                <span style="--i:8">.</span>
                <span style="--i:9">.</span>
                <span style="--i:10">.</span>
            </div>
        </div>    
        <!-- Navigation Bar -->
        <header class="container-fluid text-center" id="NAV-BAR">
                <div class="row align-items-center" id="NAV">
                    <div class="col-lg-6 text-start">
                        <a href="#"><img src="images/icon/ICON.png" height="40em"></a>
                    </div>
                    <div class="col-lg-6 text-end">
                        <div class="row">
                            <div class="col-4">

                            </div>
                            <div class="col-3">
                                <span>0.1 <span><a href="homepage.php">Timeline</a>
                            </div>
                            <div class="col-3">
                                <span>0.2 <span><a href="change_profile.php">Settings</a>
                            </div>
                            <div class="col-2">
                                <a href="index.php"><?php echo $what ?></a>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
        <!-- Main -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 LEFTBAR">

                </div>
                <div class="col-8 MAINBAR">
                    <div class="Change">
                        <div class="row">
                            <div class="col-4">
                                <?php 
                                    $image = "";
                                    if(file_exists($user_data['profile_image']))
                                    {
                                    $image = $user_data['profile_image'];
                                    }
                                ?>
                                <img src="<?php echo $image ?>" width="300rem">
                            </div>
                            <div class="col-8 new">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file" name="file">
                                    <br>
                                    <input type="submit" value="Change Profile" name="App">
                                </form><br>
                                <form method="POST">
                                    <div class="col">
                                        <input name="newfirst_name" type="text" placeholder="First Name"><br>
                                        <input name="newlast_name" type="text" placeholder="Last Name"><br>
                                        <input type="submit" value="Change Username" name="Appp">
                                    </div>
                                </form><br>
                                <form method="POST">
                                    <div class="col">
                                        <input name="password" type="password" placeholder="New Password"><br>
                                        <input name="newpassword" type="password" placeholder="Retype New Password"><br>
                                        <input type="submit" value="Change Password" name="Approve">
                                    </div>
                                </form>    
                            </div>
                        </div>        
                    </div>
                </div>
                <div class="col-2 RIGHTBAR">

                </div>
            </div>
        </div>

        <script>
            var loader = document.getElementById("preloader");
            window.addEventListener("load", function(){
                loader.style.display = "none";
            })
        </script>
    </body>
</html>