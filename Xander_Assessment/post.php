<div class="container container-post">
    <div class="col">
        <div class="row">
            <div class="col-2">
            <?php 
                    $image = "";
                    if(file_exists($ROW_USER['profile_image']))
                    {
                        $image = $ROW_USER['profile_image'];
                    }
                    ?>
                <img src="<?php echo $image ?>" width="150px">
            </div>
            <div class="col-10">
                <h1><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name']?></h1>
                <h2><?php echo $ROW['date']?></h2>
                <h3><?php echo $ROW['post']?></h3>
                <div class="row">
                    <div class="col-2">
                        <form method="GET">
                            <input type="hidden" value="1" name="add">
                            <h4><input type="submit" value="Send Likes" name="likes"></input>
                            <?php echo $ROW['likes']?></h4>
                        </form>
                    </div>
                    <div class="col-2">
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</div><br>