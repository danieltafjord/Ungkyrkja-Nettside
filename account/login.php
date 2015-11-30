<?php
# PHP Login and Register Script

# Import classes
use Project\Helpers\Hash;
use Project\Error\error;
require 'hash.php';
include('error.php');

$alert = '';
$alert_type = '';

# Connect to database
$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
if (!$con) {
	error::report($_SERVER['PHP_SELF'],'Failed to connect to database: ' . mysqli_error($con), 'Fatal', $_SERVER['REMOTE_ADDR'], date('Y-m-d h:i:sa'));
	$alert = 'Det har oppstått en feil.';
	$alert_type = 'danger';
}

#
# Register user
#
if (isset($_POST['register'])) {
	if (isset($_POST['name']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email'])) {

		# Get values
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$user = mysqli_real_escape_string($con, $_POST['user']);
		$pass = mysqli_real_escape_string($con, $_POST['pass']);
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$registered = date('Y-m-d h:m:s');
		$ip = $_SERVER['REMOTE_ADDR'];

		# Encypt password
		$encrypted_pass = Hash::create($pass);

		$loggedin = Hash::create('loggedin');

		# Check if username allready exist
		$check_uniqe = mysqli_query($con, "SELECT * FROM users WHERE user='$user' LIMIT 1");

		# If username is found, give error
		if ($check_unique && mysqli_fetch_array($check_uniqe,MYSQLI_ASSOC) == true) {
			$alert = 'Det finnes allerede en bruker med det brukernavnet.';
      $alert_type = 'warning';
		}
		# Add values to database
		else {
			mysqli_query($con, "INSERT INTO users (name, user, pass, email, registered, ip, active) VALUES ('$name', '$user', '$encrypted_pass', '$email', '$registered', '$ip', '1')");
			setcookie('auth', $encrypted_pass, time() + (86400 * 5), '/', '', '', true);
			setcookie('auth-u', $user, time() + (86400 * 5), '/', '', '', true);
			setcookie('auth-logged', $loggedin, time() + (86400 * 5), '/', '', '', true);
			header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1001');
		}

	} else {
		$alert = 'Alle feltene må fylles inn!';
		$alert_type = 'warning';
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
		$db_pass = mysqli_query($con, "SELECT * FROM users WHERE user = '$user'");
		$loggedin = Hash::create('loggedin');

		# Set cookies for login
		if($db_pass){
			while ($rows = mysqli_fetch_array($db_pass, MYSQLI_ASSOC)) {
				if (Hash::check($pass, $rows['pass']) && $user == $rows['user']) {
					if ($rows['active'] != 0) {
						setcookie('auth', $rows['pass'], time() + (86400 * 5), '/', '', '', true);
						setcookie('auth-u', $user, time() + (86400 * 5), '/', '', '', true);
						setcookie('auth-logged', $loggedin, time() + (86400 * 5), '/', '', '', true);
						header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1002');
					} else {
						header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1008');
					}
				} else {
					$alert = 'Feil brukernavn eller passord!';
					$alert_type = 'danger';
				}
			}
		}
	} else {
		$alert = 'Alle feltene må fylles inn!';
		$alert_type = 'warning';
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
		}
	}
}


#
# Logout
#

if (isset($_POST['logout'])) {
	setcookie("auth", "", time()-3600, '/');
	setcookie("auth-u", "", time()-3600, '/');
	setcookie("auth-logged", "", time()-3600, '/');
	header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1003');
}


#
# Change password
#

if (isset($_POST['changepass'])) {
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];
	$username = $_POST['username'];
	$db_pass = mysqli_query($con, "SELECT * FROM users WHERE user = '$username'");
	$row = mysqli_fetch_array($db_pass);
	if (Hash::check($oldpass, $row['pass'])) {
		$encnewpass = Hash::create($newpass);
		mysqli_query($con, "UPDATE users SET pass = '$encnewpass' WHERE user = '$username'");
		header('Location: index.php?alert=1011');
	} else {
		header('Location: index.php?alert=1012');
	}
}
?>
