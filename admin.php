<?php

    require_once('load.php');
    $logged = $j->checkLogin();
    if ( $logged == false ) {
        //Build our redirect
        $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $redirect = str_replace('admin.php', 'login.php', $url);
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
<html>
	<head>
		<title>Admin</title>
                <link rel="stylesheet" type="text/css" href="css/style.css">
				<link rel="stylesheet" type="text/css" href="css/nav.css">
                <link rel="icon" type="image/png" href="logo.png">
                <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>

		<div style="width: 90%; background: #fff; border: 1px solid #f1f1f1; padding: 20px; margin: 10px auto;">
	        <div align="right" style="float:right;">
	        <ul class="dropdown">
        		<img src=<?php if(!$results['user_img']) {echo "'img/default.png'";} else {echo "img/" . $results['user_img'] . "";} ?> style="width:56px;border-radius:50%;"><li class="drop"><a href="#"><?php echo $results['user_name']; ?></a>
                    <ul class="sub_menu">
                        <li><a href="editprofile.php">Edit profile</a></li>
                        <li><a href="login.php?action=logout">Sign out</a></li>
		    		</ul>
			    </li>
			</ul>
	        </div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/nav.js"></script>
	</body>
</html>
<?php } ?>
