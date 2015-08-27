
<?php

$con=mysqli_connect("localhost","root","","blog");


// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: <br>" . mysqli_connect_error();
}
//check that we have a file
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 1.4MB
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);

  if (($ext == "jpg") && ($_FILES["uploaded_file"]["type"] == "image/jpeg") &&
    ($_FILES["uploaded_file"]["size"] < 304858000000)) {
    //Determine the path to which we want to save this file
      $newname = realpath(dirname(__FILE__)). 'bilder/'.$filename;
      $filename = mysqli_real_escape_string($con, $filename);
      $sql = "INSERT INTO bilder (img) VALUES ('$filename')";
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

<html>
	<head>
		<title>Edit profile</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
	</head>

	<body>

		<div style="width: 90%; background: #fff; border: 1px solid #f1f1f1; padding: 20px; margin: 10px auto;">
	        <div align="right" style="float:right;">

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
                        </div>

		</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/nav.js"></script>

	</body>
</html>
<?php #} ?>