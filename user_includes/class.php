<?php
// Our main class
if(!class_exists('Joomba')){
	class Joomba {
		
		function register($redirect) {
			global $jdb;
		
			//Check to make sure the form submission is coming from our script
			//The full URL of our registration page
			$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			//The full URL of the page the form was submitted from
			$referrer = $_SERVER['HTTP_REFERER'];

			/*
			 * Check to see if the $_POST array has date (i.e. our form was submitted) and if so,
			 * process the form data.
			 */
			if ( !empty ( $_POST ) ) {

				/* 
				 * Here we actually run the check to see if the form was submitted from our
				 * site. Since our registration from submits to itself, this is pretty easy. If
				 * the form submission didn't come from the register.php page on our server,
				 * we don't allow the data through.
				 */
				if ( $referrer == $current ) {
				
					//Require our database class
					require_once('db.php');
						
					//Set up the variables we'll need to pass to our insert method
					//This is the name of the table we want to insert data into
					$table = 'users';
					
					//These are the fields in that table that we want to insert data into
					$fields = array('user_name', 'user_login', 'user_pass', 'user_email', 'user_registered', 'user_ip', 'user_role');
					
					//These are the values from our registration form... cleaned using our clean method
					$values = $jdb->clean($_POST);
					
					//Now, we're breaking apart our $_POST array, so we can storely our password securely
					$username = $_POST['name'];
					$userlogin = $_POST['username'];
					$userpass = $_POST['password'];
					$useremail = $_POST['email'];
					$userreg = $_POST['date'];
					$userip  = $_POST['ip'];
					$userrole = $_POST['role'];
					
					//We create a NONCE using the action, username, timestamp, and the NONCE SALT
					$nonce = md5('registration-' . $userlogin . $userreg . NONCE_SALT);
					
					//We hash our password
					$userpass = $jdb->hash_password($userpass, $nonce);
					
					//Recompile our $value array to insert into the database
					$values = array(
								'name' => $username,
								'username' => $userlogin,
								'password' => $userpass,
								'email' => $useremail,
								'date' => $userreg,
								'ip' => $userip,
								'role' => $userrole,
							);
					
					//And, we insert our data
					$insert = $jdb->insert($link, $table, $fields, $values);
					
					if ( $insert == TRUE ) {
						$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$aredirect = str_replace('register.php', $redirect, $url);
						
						header("Location: $redirect?reg=true");
						exit;
					}
				} else {
					die('Your form submission did not come from the correct page. Please check with the site administrator.');
				}
			}
		}
		
		function login($redirect) {
			global $jdb;
		
			if ( !empty ( $_POST ) ) {
				
				//Clean our form data
				$values = $jdb->clean($_POST);

				//The username and password submitted by the user
				$subname = $values['username'];
				$subpass = $values['password'];

				//The name of the table we want to select data from
				$table = 'users';

				/*
				 * Run our query to get all data from the users table where the user 
				 * login matches the submitted login.
				 */
				$sql = "SELECT * FROM $table WHERE user_login = '" . $subname . "'";
				$results = $jdb->select($sql);

				//Kill the script if the submitted username doesn't exit
				if (!$results) {
					die('Sorry, that username does not exist!');
				}

				//Fetch our results into an associative array
				$results = mysql_fetch_assoc( $results );
				
				//The registration date of the stored matching user
				$storeg = $results['user_registered'];

				//The hashed password of the stored matching user
				$stopass = $results['user_pass'];

				//Recreate our NONCE used at registration
				$nonce = md5('registration-' . $subname . $storeg . NONCE_SALT);

				//Rehash the submitted password to see if it matches the stored hash
				$subpass = $jdb->hash_password($subpass, $nonce);

				//Check to see if the submitted password matches the stored password
				if ( $subpass == $stopass ) {
					
					//If there's a match, we rehash password to store in a cookie
					$authnonce = md5('cookie-' . $subname . $storeg . AUTH_SALT);
					$authID = $jdb->hash_password($subpass, $authnonce);
					
					//Set our authorization cookie
					setcookie('joombologauth[user]', $subname, 0, '', '', '', true);
					setcookie('joombologauth[authID]', $authID, 0, '', '', '', true);
					
					//Build our redirect
					$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
					$redirect = str_replace('login.php', $redirect, $url);
					
					//Redirect to the home page
					header("Location: $redirect");
					exit;	
				} else {
					return 'invalid';
				}
			} else {
				return 'empty';
			}
		}
		
		function logout() {
			//Expire our auth coookie to log the user out
			$idout = setcookie('joombologauth[authID]', '', -3600, '', '', '', true);
			$userout = setcookie('joombologauth[user]', '', -3600, '', '', '', true);
			
			if ( $idout == true && $userout == true ) {
				return true;
			} else {
				return false;
			}
		}
		
		function checkLogin() {
			global $jdb;
		
			//Grab our authorization cookie array
			$cookie = $_COOKIE['joombologauth'];
			
			//Set our user and authID variables
			$user = $cookie['user'];
			$authID = $cookie['authID'];
			
			/*
			 * If the cookie values are empty, we redirect to login right away;
			 * otherwise, we run the login check.
			 */
			if ( !empty ( $cookie ) ) {
				
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
		
				//The registration date of the stored matching user
				$storeg = $results['user_registered'];

				//The hashed password of the stored matching user
				$stopass = $results['user_pass'];

				//Rehash password to see if it matches the value stored in the cookie
				$authnonce = md5('cookie-' . $user . $storeg . AUTH_SALT);
				$stopass = $jdb->hash_password($stopass, $authnonce);
				
				if ( $stopass == $authID ) {
					$results = true;
				} else {
					$results = false;
				}
			} else {
				//Build our redirect
				$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$redirect = str_replace('admin.php', 'login.php', $url);
				
				//Redirect to the home page
				header("Location: $redirect?msg=login");
				exit;
			}
			
			return $results;
		}
	}
}

//Instantiate our database class
$j = new Joomba;
?>
