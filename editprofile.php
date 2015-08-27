<?php
	require_once('load.php');
	error_reporting(0);
	$logged = $j->checkLogin();

	if ( $logged == false ) {
		//Build our redirect
		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$redirect = str_replace('editprofile.php', 'login.php', $url);
		//Redirect to the home page
		header("Location: $redirect?msg=login");
		exit;
	} else {
		//Grab our authorization cookie array
		$cookie = $_COOKIE['user'];
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
		$results = mysql_fetch_assoc( $results );
?>
<?php

$con=mysqli_connect("localhost","root","","login_register");
$user_login_sql = $results['user_login'];

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: <br>" . mysqli_connect_error();
}
//check that we have a file
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 1.4MB
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);

  if (($ext == "jpeg") && ($_FILES["uploaded_file"]["type"] == "image/jpeg") &&
    ($_FILES["uploaded_file"]["size"] < 3048580000)) {
    //Determine the path to which we want to save this file
      $newname = dirname(__FILE__).'/img/'.$filename;
      $filename = mysqli_real_escape_string($con, $filename);
      $sql = "UPDATE users SET img='$filename' WHERE user_login='$user_login_sql'";
      mysqli_query($con,$sql);

      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
           echo "Upload Complete! ";
        } else {
           echo "Error: A problem occurred during file upload!";
        }
      } else {
         echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
      }
  } else {
     echo "Error: File too big to upload";
  }
}

?>

<?php

$edit_name  = $_POST['edit_name'];
$edit_email = $_POST['edit_email'];
$submit_name  = $_POST['submit_name'];
$submit_email = $_POST['submit_email'];

$edit_name_sql = "UPDATE users SET user_name = '$edit_name' WHERE user_login = '$user_login_sql'";
$edit_email_sql = "UPDATE users SET user_email = '$edit_email' WHERE user_login = '$user_login_sql'";

if (isset($submit_name)) {
	mysqli_query($con, $edit_name_sql);
}

if (isset($submit_email)) {
	mysqli_query($con, $edit_email_sql);
}


?>

<html>
	<head>
		<title>Edit profile</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
	</head>

	<body>

		<div style="width: 90%; background: #fff; border: 1px solid #f1f1f1; padding: 20px; margin: 10px auto;">
	        <div align="right" style="float:right;">

	        <ul class="dropdown">

        		<img src=<?php if(!$results['user_img']) {echo "img/default.png";} else {echo "img/" . $results['user_img'] . "";} ?> style="width:56px;border-radius:50%;"><li class="drop"><a href="#"><?php echo $results['user_name']; ?></a>
                        <ul class="sub_menu">
                        <li><a href="admin.php">Admin</a></li>
                        <li><a href="login.php?action=logout">Sign out</a></li>
			    </ul>
			        </li>
			</ul>

                        <div style="float:right;">
	        <h3>User info</h3>
			<table>
				<tr>
					<td>Username: </td>
					<td><?php echo $results['user_login']; ?></td>
				</tr>

				<tr>
					<td>Email: </td>
					<td><?php echo $results['user_email']; ?></td>
				</tr>

				<tr>
					<td>Registered: </td>
					<td><?php echo date('l, F jS, Y', $results['user_registered']); ?></td>
				</tr>
			</table>
                  </div>

	        </div>
                        <div align="left">
                        <label style="font-size:20px;">Edit profile</label>
                                <form action="" method="post" enctype="multipart/form-data" style="width:320px;margin-top:100px;">

                                        <input type="file" class="filestyle" data-buttonName="btn-primary" name="uploaded_file" id="uploaded_file" value="Choose image">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <input type="hidden" name="image_type" value="" /><br />
                                        <input type="hidden" name="MM_insert" value="form" />
                                        <output id="list"></output>
                                        <input type="submit" value="Upload">
                                </form>

                                <!-- Update name form -->
                                <form action="" method="post" style="width:320px;margin-top:100px;">
                                        <input type="text" placeholder=<?php echo $results['user_name']; ?> name="edit_name">
                                        <input type="submit" value="Done" name="submit_name">
                                </form>

                                <!-- Update email form -->
                                <form action="" method="post" style="width:320px;margin-top:100px;">
                                        <input type="text" placeholder="email" name="edit_email">
                                        <input type="submit" value="Done" name="submit_email">
                                </form>
                        </div>

		</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/nav.js"></script>

	</body>
</html>
<?php } ?>
