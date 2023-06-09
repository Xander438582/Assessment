<?php
session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");


    if(isset($_SESSION['userid']))
    {
        $id = $_SESSION['userid'];
        $login = new Login();
        $login->check_login($id);

        $result = $login->check_login($id);

        if($result){
            $user = new User();
            $user_data = $user->get_data($id);

            $name = $user_data['first_name'] . " " . $user_data['last_name'];
            $what = "Logout";
        }else{
            $what = "Login";
            $name = "Welcome to HubbyHive";  
        }
    }else{
        $what = "Login";
        $name = "Welcome to HubbyHive"; 
    }

    //For Posting
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if($_POST['publish']) {
            $post = new Post();
            $id = $_SESSION['userid'];
            $data = $_POST;

            $result = $post->create_post($id, $data);

            if($result ==""){
                header("Location: homepage.php");
                die;
            }else{
                header("Location: homepage.php");
                die;
            }
        }
    }
    if(isset($_POST['post'])){
        unset($_POST['post']);
    }

    $post = new Post();
    $id = $_SESSION['userid'];
    $posts = $post->get_posts($id);

    $user = new User();
    $id = $_SESSION['userid'];
    $friends = $user->get_friends($id);

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
        /* POSTING */
        .post textarea{
            padding: 1rem;
            font-family: PT Mono;
            resize: none;
        }
        .post textarea{
            background-color: #09192f;
            color: #bec9e8;
            font-color: #bec9e8;
            -moz-appearance:none;
            outline:0px none transparent;
            border-radius: 1rem;
            border: none;
        }
        .publish {
            margin-top: -2rem;
            margin-right: 0.5rem;
            background: ;
        }
        .publish input{
            background-color: white;
            font-family: PT Mono;
            border-radius: 0.5rem;
            border: none;
        }
        .publish span{
            font-family: PT Mono;
            color: #64ffdb;
            font-size: 12px;
        }
        /* POST */
        .container-post{
            background-color: #09192f;
            padding: 1em;
            border-radius: 1em;
        }
        .container-post img{
            border-radius: 1rem;
        }
        .container-post h1{
            color: #bec9e8;
            font-weight: light;
            font-size: 20px;
            margin-bottom: -0.1rem;
            font-family: PT Mono;
        }
        .container-post h2{
            color: #bec9e8;
            font-weight: light;
            font-size: 12px;
            margin-bottom: 1rem;
            font-family: PT Mono;
        }
        .container-post h3{
            font-weight: light;
            color: #bec9e8;
            height: 2rem;
            font-size: 16px;
            font-family: PT Mono;
        }
        .container-post h4{
            font-family: PT Mono;
            margin-top: 2rem;
            color: #64ffdb;
            font-size: 12px;
        }
        .container-post span{
            font-weight: light;
            color: #bec9e8;
            font-size: 14px;
            font-family: PT Mono;
        }
        /* PROFILE PIC */
        .profile-pic img{
            border-radius: 1rem;
        }
        .profile-pic a{
            font-family: PT Mono;
            text-decoration: none;
            color: #bec9e8;
            font-size: 14px;
        }
        .profile-pic h2{
            font-family: PT Mono;
            color: #bec9e8;
            font-size: 20px;
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
        .LEFTBAR h1{
            font-family: PT Mono;
            color: #bec9e8;
            text-align: center;
            font-size: 2em;
        }
        .LEFTBAR h2{
            font-family: PT Mono;
            color: #bec9e8;
            font-size: 1em;
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
        .RIGHTBAR h1{
            font-family: PT Mono;
            color: #bec9e8;
            text-align: center;
            font-size: 2em;
        }
        .friend-list{
            background-color: #172a46;
            margin-left: 0rem;
            margin-right: 0rem;
            padding: 0.4rem;
            border-radius: 10rem;    
        }
        .friend-list img{
            border-radius: 10rem;
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
                <h1>USERS</h1>
                    <?php 
                    if($friends){

                        foreach ($friends as $FRIEND_ROW){
                         include("user.php");
                        }

                     }
                    ?>
                </div>
                <div class="col-8 MAINBAR">
                    <Games class="container-fluid con-carousel">
                        <div class="carousel" data-flickity='{ "autoplay": true, "wrapAround": true, "autoPlay": 3000, "pauseAutoPlayOnHover": true}'>
                        <div class="carousel-cell">
                                <a href="#">
                                    <img src="images/game/valorant.jpg" width="500px">
                                </a>
                            </div>
                            <div class="carousel-cell">
                                <a href="#">
                                    <img src="images/game/lol.jpg" width="500px">
                                </a>
                            </div>
                            <div class="carousel-cell">
                                <a href="#">
                                    <img src="images/game/ow2.png" width="500px">
                                </a>
                            </div>
                            <div class="carousel-cell">
                                <a href="#">
                                    <img src="images/game/star.jpg" width="500px">
                                </a>
                            </div>
                            <div class="carousel-cell">
                                <a href="#">
                                    <img src="images/game/genshin.jpg" width="500px">
                                </a>
                            </div>
                        </div>
                    </Games>
                    <newpost class="container text-center post">
                        <form method="POST">
                            <div class="col">
                            <textarea placeholder="Whats on your mind?" name="post" type="text" cols="95" rows="5" maxlength="230"></textarea>
                            </div>
                            <div class="col text-end publish">
                                <input id="post_button" type="submit" name="publish" value="Post">
                            </div>
                        </form>
                    </newpost>
                    <?php
                        if($posts){
                            
                            foreach ($posts as $ROW){
                                $user = new User();
                                $ROW_USER = $user->get_user($ROW['userid']);

                                include("post.php");
                                
                                if($_SERVER['REQUEST_METHOD'] == "POST")
                                {
                                    $id = $ROW['postid'];
                                    $query = "UPDATE posts SET likes = 1 WHERE postid = '$id' LIMIT 1";
                                    $DB = new Database();
                                    $DB->save($query);
                                }
                            }
                        }
                    ?>
                </div>
                <div class="col-2 RIGHTBAR">
                    <div class="col">
                        <h1>PROFILE</h1>
                        
                    </div>
                    <div class="col text-center profile-pic">
                    <?php 
                        $image = "";
                        if(file_exists($user_data['profile_image']))
                        {
                            $image = $user_data['profile_image'];
                        }
                        ?>
                        <img src="<?php echo $image ?>" width="100rem" height="100rem">
                    </div>
                    <div class="col text-center profile-pic">
                        <h2><?php echo $name ?></h2>
                        <a href="change_profile.php?change=profile">Change Profile</a>
                    </div>
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