<?php
$id = $title = $date = $time = $enddate = $endtime = $content = $alert = '';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace("'", "", $data);
  return $data;
}

include_once('account/login.php');
$islogged = false;
if(!empty($_COOKIE['auth-logged'])) {
$islogged = true;
}

$con = new mysqli("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
if (!$con) {
  $alert = 'Kunne ikke laste inn data.';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#222">
    <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#222">
    <title>Rediger Program | Ungkyrkja</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/header-imports.html">
		<link href="css/edit_program.css" rel="stylesheet">
    <style media="screen">
    form{
        width: 100%;
        margin: 0px;
        padding-top: 25px;
        padding-bottom: 15px;
        padding-left: 25px;
        padding-right: 25px;
    }
    #title{
        font-size: 18px;
    }
    textarea{
        resize: vertical;
        margin-bottom: 10px;
    }
    input{
        margin-bottom: 10px;
    }
    .right{
      float:right;
    }
    </style>
  </head>
  <body>
    <!--Import navbar-->
<?php
$site_location = '/edit_program.php';
include 'components/navbar.php';

if(isset($_COOKIE['auth-u']) && isset($_COOKIE['auth'])){
  $auth_u = $_COOKIE['auth-u'];
  $auth = $_COOKIE['auth'];
  $user_query = $con->query("SELECT user, pass, role FROM users WHERE user LIKE '$auth_u'")->fetch_array();
  if($user_query['user'] != $auth_u || $user_query['pass'] != $auth || $user_query['role'] <= 1){
    ?>
    <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <p>Du har ikke tilgang til denne siden.</p>
    </div>
    <?php
    die('');
  }
}
else{
  ?>
  <div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <p>Du er ikke logget inn.</p>
  </div>
  <?php
  die('');
}

//Get values from post
if (isset($_POST['id'])) {
  $id = test_input($_POST['id']);
  $title = test_input($_POST['title']);
  $date = test_input($_POST['date']);
  $time = test_input($_POST['time']);
  $enddate = test_input($_POST['enddate']);
  $endtime = test_input($_POST['endtime']);
  $content = test_input($_POST['content']);

  $date = DateTime::createFromFormat("Y-m-d H:i", $date . " " . $time);
  $enddate = DateTime::createFromFormat("Y-m-d H:i", $enddate . " " . $endtime);

  if(isset($_POST['update'])){
    if($id != ""){
      $sql_query = "UPDATE uk_program SET title='$title', content='$content', date='" . $date->format("Y-m-d H:i:s") . "', enddate='" . $enddate->format("Y-m-d H:i:s") .
      "' WHERE id LIKE '$id'";
      if(mysqli_query($con, $sql_query)){
        header('location: program.php?alert=9002');
      }
      else {
        $alert = 'Kunne ikke oppdatere hendelsen.';
      }
    }
    else{
      $sql_query = "INSERT INTO uk_program (title, content, date, enddate)
      VALUES ('$title', '$content', '" . $date->format("Y-m-d H:i:s") . "', '" . $enddate->format("Y-m-d H:i:s") . "')";
      if($con->query($sql_query)){
        header('location: program.php?alert=9001');
      }
      else {
        $alert = 'Kunne ikke lagre hendelsen.';
      }
    }
  }
  else if(isset($_POST['delete']) && isset($_POST['id'])){
    if($con->query("DELETE FROM uk_program WHERE id LIKE $id")){
      header('location: program.php?alert=9003');
    }
    else{
      $alert = 'Kunne ikke slette hendelsen.';
    }
  }

}

$query = null;

  // Get id of event
if(isset($_GET['id'])){

$id = test_input($_GET['id']);
}
if($id != ""){
  $query = $con->query("SELECT * FROM uk_program WHERE id LIKE '$id'")->fetch_assoc();
}

# Config
setlocale(LC_ALL, "no");

if($query != null){
  $title = $query["title"];
  $content = $query["content"];
  $date = new DateTime($query["date"]);
  $enddate = new DateTime($query["enddate"]);
}

if($alert != ''){
  ?>
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <div class="alert alert-danger">
  <?php
  echo $alert;
  ?>
  </div>
<?php
}
?>
		<!-- Main bit -->

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
					<div class="well">
						<form class="main-form form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<Legend>Tittel:</legend>
							<input type="text" class="form-control" id="title" value="<?php echo $title; ?>" name="title"/>
							<fieldset>
								<legend>Dato og tid:</legend>
								<label for="date" class="control-label">Start dato:</label>
								<input type="date" class="form-control" id="date" name="date" value="<?php if($date!=""){echo $date->format("Y-m-d");} ?>" />
								<label for="time" class="control-label">Start tid: </label>
								<input type="time" class="form-control" id="time" name="time" value="<?php if($date!=""){echo $date->format("H:i");} ?>" />
								<label for="enddate" class="control-label">Slutt dato:</label>
								<input type="date" class="form-control" id="enddate" name="enddate" value="<?php if($enddate!=""){echo $enddate->format("Y-m-d");} ?>" />
								<label for="endtime" class="control-label">Slutt tid:</label>
								<input type="time" class="form-control" id="endtime" name="endtime" value="<?php if($enddate!=""){echo $enddate->format("H:i");}?>" />
							</fieldset>
							<legend>Innhold:</legend>
							<textarea class="form-control" rows="5" id="content" name="content"><?php echo $content; ?></textarea>
							<input type="text" class="form-control hidden" id="id" name="id" value="<?php echo $id; ?>" />
							<button type="submit" name="update" class="btn btn-primary">Lagre</button>
							<a href="program.php"><button type="button" class="btn btn-default">Tilbake</button></a>
              <button type="button" name="delete" data-toggle="modal" data-target="#modalDelete" class="btn btn-danger right">Slett</button>
              <!--modal-->
              <div id="modalDelete" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Slett</h4>
                    </div>
                    <div class="modal-body">
                      <p>Er du sikker? Dette kan ikke gjøres om.</p>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger" type="submit" name="delete">Slett</button>
                      <button class="btn btn-default" type="button" data-dismiss="modal">Lukk</button>
                    </div>
                  </div>
                </div>
              </div>
						</form>
					</div>
				</div>
			</div>
		</div>
    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

  </body>
</html>
