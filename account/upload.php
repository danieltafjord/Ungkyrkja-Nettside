<?php

$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');

$desc = $_POST['desc'];
//Loop through each file
for($i=0; $i<count($_FILES['upload']['name']); $i++) {
  //Get the temp file path
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  //Make sure we have a filepath
  if ($tmpFilePath != ""){
    //Setup our new file path
    $newFilePath = "../bilder/" . $_FILES['upload']['name'][$i];

    //Upload the file into the temp dir
		$check_uniqe = mysqli_query($con, "SELECT * FROM bilder WHERE img='$newFilePath' LIMIT 1");
    if(move_uploaded_file($tmpFilePath, $newFilePath) && !mysqli_fetch_array($check_uniqe,MYSQLI_ASSOC) == true) {
			mysqli_query($con, "INSERT INTO bilder (img, description) VALUES ('$newFilePath', '$desc')");
			header("Location: ../bilder.php");
    } else {
			echo "Upload failed!";
		}
  }
}

?>
