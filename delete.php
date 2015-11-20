<?php
$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');

// Check user
if(isset($_COOKIE['auth-u']) && isset($_COOKIE['auth'])){
  $auth_u = $_COOKIE['auth-u'];
  $auth = $_COOKIE['auth'];

  $user = $con->query("SELECT user, pass, role FROM users WHERE user LIKE $auth_u")->fetch_array();

  if($auth_u != $user['user'] || $auth != $user['pass'] || $user['role'] < 1){
    die('User not authorized!');
  }
}
else{
  die('User not logged in!')
}

# Delete images from fremside
if(isset($_POST['submit-fremside'])){
  if(!empty($_POST['fremside'])){
    $fremside = $_POST['fremside'];
    // Loop to store and display values of individual checked checkbox.
    foreach($_POST['fremside'] as $selected){
      $fremside_implode = implode($fremside);
      mysqli_query($con, "DELETE FROM fremside WHERE id = '$fremside_implode'");
      header('Location: account/index.php');
    }
  }
}
if(isset($_POST['submit-bilder'])){
  if(!empty($_POST['bilder'])){
    $fremside = $_POST['bilder'];
    // Loop to store and display values of individual checked checkbox.
    foreach($_POST['bilder'] as $selected){
      $fremside_implode = implode($fremside);
      mysqli_query($con, "DELETE FROM bilder WHERE id = '$fremside_implode'");
      header('Location: account/index.php');
    }
  }
}
?>
