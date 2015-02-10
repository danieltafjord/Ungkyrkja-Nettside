<?php
    error_reporting(0);
?>
<div style="font-size:5px;opacity:0;">
<?php

    require_once('load.php');
    $logged = $j->checkLogin();
    if ( $logged == false ) {
        //Build our redirect
        $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $redirect = str_replace('indexa.php', 'login.php', $url);
        //Redirect to the home page
        header("Location: $redirect?msg=login");
        exit;
    } else {
        //Grab our authorization cookie array
        $cookie = $_COOKIE['joombologauth'];
        //Set our user and authID variables
        $user = $cookie['user'];
        $authID = $cookie['authID'];
        //Query the database for the selected user
        $table = 'users';
        $sql = "SELECT * FROM $table WHERE user_login = '" . $user . "'";
        $results = $jdb->select($sql);
        //Kill the script if the submitted username doesn't exit
        if (!$results) {
            die('Sorry, that username does not exist!');
        }
        //Fetch our results into an associative array
        $results = mysql_fetch_assoc($results);
?>

</div>
<html>
    <head>
        <title>Admin</title>
        <style type="text/css">
            body { background: #f9f9f9;}
        </style>

        <link rel="stylesheet" type="text/css" href="css/style.css">
    
    </head>

    <body>
<div align="center">
    <h3>Admin, <?php echo $results['user_name']; ?></h3>
    <a href="login.php?action=logout" style="float:right;margin-top:-50px;margin-right:30px;">Logout</a>
    <div style="widht:900px;min-height:100px;border:1px solid #f1f1f1;">

        
        <div align="center" style="margin-top:85px;">
            <div class="form-container">
                <div class="form-main">
                    <form action="insert.php" method="post" enctype="multipart/form-data">
                        <input type="file" class="filestyle" data-buttonName="btn-primary" name="uploaded_file" id="uploaded_file">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <input type="hidden" name="image_type" value="" /><br />    
                        <input type="hidden" name="MM_insert" value="form" />
                        <input type="text" placeholder="Description" name="desc" maxlength="256">
                        <input type="text" placeholder="Category" name="category">
                    
                        <input type="submit" value="Ferdig">
                    </form>
                </div>
            </div>
        </div>

        <!-- DELETE IMAGES -->

        <div>

            <?php
                $con = mysqli_connect('localhost','root','','UploadGallery');
                $get_img = mysqli_query($con, 'SELECT * FROM gallery');
                # Displaying images
                /*while($img = mysqli_fetch_array($get_img,MYSQLI_ASSOC)){
                    $img_img = $img['img'];
                    $img_desc = $img['description'];
                    /*echo "<div style='display:inline;'>";
                    echo "<a href='indexa.php?img=" . $img_img . "&id=" . $img_desc . "'><img style='max-width:50px;' src='images/" . $img_img . "'></a>";
                    echo "</div>";
                    echo "
                            <div>
                            <span><img style='max-width:60px;' src='images/" . $img_img . "'></<span>
                            <span><br><a href='indexa.php?img=" . $img_img . "&id=" . $img_desc . "'>Delete</a></span>
                            </div>
                    ";
                }*/
                ?>



<div style="width:1150px;margin-top:50px;">

    <h2>Click on an image to delete it</h2>
        <section id="photos">
            <?php
                # Displaying images
                while($img = mysqli_fetch_array($get_img,MYSQLI_ASSOC)){
                    $img_img = $img['img'];
                    $img_desc = $img['description'];
                    echo "
                        <div>
                        <span><a href='indexa.php?img=" . $img_img . "&id=" . $img_desc . "'><img src='images/" . $img_img . "'></a></<span>
                        </div>
                    ";
                }
            ?>
        </section>
    </div>

                <?php
                $img_id   = mysqli_real_escape_string($con, $_GET['img']);
                $img_desc = mysqli_real_escape_string($con, $_GET['id']);
                $answer   = mysqli_real_escape_string($con, $_GET['answer']);

                if (isset($_GET['img'])) {
                    echo "<div style='position:absolute;top:34%;left:34%;background-color:#fff;width:380px;height:180px;font-size:25px;border:1px solid #f1f1f1;padding:20px;>";
                    
                    echo "<div><a href='indexa.php'></a>";
                    echo "<div><a href='indexa.php'><input type='submit' value='No' style='border:none;font-size:25px;background-color:#fff;' name='submitanswer'></a><br><br>";
                    echo "<a href='indexa.php?img=$img_id&id=$img_desc&answer=yes'>
                    <input type='submit' value='Yes' style='border:none;font-size:25px;background-color:#fff;' name='submitanswer1'></a><br><br><p>Are you sure?</p></div>";
                    echo "</div>";

                    if ($answer == 'yes') {
                            mysqli_query($con, "DELETE FROM gallery WHERE img = '" . $img_id . "'");
                        }
                    if (isset($_POST['submitanswer'])) {
                        header('Location: indexa.php');
                    }
                    if (isset($_POST['submitanswer1'])) {
                        header('Location: indexa.php');
                    }
                }
            ?>
        </div>

        <!-- /DELETE IMAGES -->

    </div>
</div>
    </body>
</html>
<?php } ?>