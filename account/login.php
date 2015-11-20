<?php
# PHP Login and Register Script

# Import classes
use Project\Helpers\Hash;
use Project\Error\error;
require 'hash.php';
include('error.php');



# Connect to database
$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
if (!$con) {
	error::report($_SERVER['PHP_SELF'],'Failed to connect to database: ' . mysqli_error($con), 'Fatal', $_SERVER['REMOTE_ADDR'], date('Y-m-d h:i:sa'));
	die(header('Location: index.php'));
}


#
# Register user
#
if (isset($_POST['register'])) {
	if (isset($_POST['name']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email'])) {

		# Get values
		$name = mysqli_real_escape_string($_POST['name']);
		$user = mysqli_real_escape_string($_POST['user']);
		$pass = mysqli_real_escape_string($_POST['pass']);
		$email = mysqli_real_escape_string($_POST['email']);
		$registered = date('Y-m-d h:m:s');
		$ip = $_SERVER['REMOTE_ADDR'];

		# Encypt password
		$encrypted_pass = Hash::create($pass);

		# Check if username allready exist
		$check_uniqe = mysqli_query($con, "SELECT * FROM users WHERE user='$user' LIMIT 1");

		# If username is found, give error
		if ($check_unique && mysqli_fetch_array($check_uniqe,MYSQLI_ASSOC) == true) {
			echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>User allready exist</div>";
		}

		# Add values to database
		else {
			mysqli_query($con, "INSERT INTO users (name, user, pass, email, registered, ip) VALUES ('$name', '$user', '$encrypted_pass', '$email', '$registered', '$ip')");
			setcookie('auth', $rows['pass'], 0, '', '', '', true);
			setcookie('auth-u', $user, 0, '', '', '', true);
			setcookie('auth-logged', $loggedin, 0, '', '', '', true);
			header('Location: ' . $_SERVER['PHP_SELF']);

		}

	} else {
		echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Every field is required</div>";
	}
}



#############
# Login user
#############
if (isset($_POST['login'])) {
	if (isset($_POST['user']) && isset($_POST['pass'])) {

		# Get values
		$user = mysqli_real_escape_string($con, $_POST['user']);
		$pass = mysqli_real_escape_string($con, $_POST['pass']);
		$db_pass = mysqli_query($con, "SELECT * FROM users");
		$loggedin = Hash::create('loggedin');

		# Set cookies for login
		if($db_pass){
			while ($rows = mysqli_fetch_array($db_pass, MYSQLI_ASSOC)) {
				if (Hash::check($pass, $rows['pass']) && $user == $rows['user']) {
					setcookie('auth', $rows['pass'], 0, '', '', '', true);
					setcookie('auth-u', $user, 0, '', '', '', true);
					setcookie('auth-logged', $loggedin, 0, '', '', '', true);
					header('Location: ' . $_SERVER['PHP_SELF']);

				} else {
					echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Wrong username or password!</div>";
				}
			}
		}
	} else {
		echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Every field is requried!</div>";
	}
}


#
# Check if user is logged in
#
$db_pass = mysqli_query($con, "SELECT * FROM users");
if($db_pass){
	while ($row = mysqli_fetch_array($db_pass,MYSQLI_ASSOC)) {
		if (!empty($_COOKIE['auth-logged']) && Hash::check($_COOKIE['auth'], $row['pass'])) {
			$islogged = true;
			echo "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>User is check for logged in!</div>";
		}
	}
}


#
# Logout
#

if (isset($_POST['logout'])) {
	setcookie("auth", "", time()-3600);
	setcookie("auth-u", "", time()-3600);
	setcookie("auth-logged", "", time()-3600);
	header('Location: ' . $_SERVER['PHP_SELF']);
}

?>
