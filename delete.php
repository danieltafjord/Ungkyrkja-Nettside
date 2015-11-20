<?php
$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');

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
