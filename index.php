<?php
include_once('account/login.php');
$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
$islogged = false;
if(!empty($_COOKIE['auth-logged'])) {
$islogged = true;
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
    <title>Ungkyrkja | Heim</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/header-imports.html">
    <style media="screen">
    .divider {
      margin-bottom:20px;
      margin-left: auto;
      margin-right: auto;
      border:0;
      border-bottom:1px solid #e5e5e5;
      max-width: 900px;
    }
    .box {
      margin-top: 15px;
      margin-bottom: 15px;
      background-color: #fff;
      padding:20px;
      border: 1px solid #e3e3e3;
      border-radius: 3px;
    }
    .event-card{
      display: block;
      margin:auto;
      width: 100%;
    }
    .event-card .content p{
      font-size: 16px;
      overflow: hidden;
    }
    .event-card .content i{
      float: left;
      margin-right: 8px;
    }
    .btn-icon{
      border: none;
      background-color: #fff;
    }
    .modal-footer form{
      display: inline-block;
    }
    .maps iframe{
      pointer-events: none;
    }
    </style>
  </head>
  <body>
    <!--Import navbar-->
    <?php
    $site_location = '/index.php';
    include 'components/alert.php';
    ?>

<?php if(empty($_COOKIE['auth-u'])): ?>
	<div class="top-container">
		<div class="menu-anchor">
			<a href="#nav"><img src="img/menu.png" /></a>
		</div>
		<div class="mid-img">
			<img src="img/uk.png" />
		</div>
	</div>
	<div class="main-container" id="nav">
<?php endif; ?>


	<?php include 'components/navbar.php'; ?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" style="max-height:450px;max-width:100%;">
    <?php

      $sqlfront = mysqli_query($con, "SELECT * FROM fremside WHERE active = 0");
      while ($row = mysqli_fetch_array($sqlfront)) {
        echo "<div class='item'>";
        echo "<img src='img/" . htmlentities($row['name']) . "' style='width:100%;'>";
        echo "</div>";
      }

    ?>
    <?php

      $sqlfront1 = mysqli_query($con, "SELECT * FROM fremside WHERE active = 1");
      while ($rows = mysqli_fetch_array($sqlfront1)) {
        echo "<div class='item active'>";
          echo "<img src='img/" . htmlentities($rows['name']) . "' style='width:100%;'>";
        echo "</div>";
      }

    ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="container-fluid" style="background-color:#f3f3f3;padding:50px 0;">
  <div class="container">
    <h1 class="page-header"><strong>Hva er Ungkyrkja?</strong></h1>
    <p style="font-size:16px;">
      Ungkyrkja er en menighet som befinner seg i Bryne kyrkja, her kan du komme å vere med på interessegrupper,<br>
      samlingar og ungdomsgudstenester. Vi har åpen kiosk med brus, snop og chips.<br>
      Vær med på weekends og andre utflukter.
    </p>
  </div>
</div>

<!-- Section 2 -->
<div class="row" style="margin: 100px 0px;">
  <div class="col-sm-6" id="program-next">
    <h1 align="center" style="font-size:32px;">Neste samling</h1>
    <hr width="100%" align="center" class="divider">
    <?php
    $conn = new mysqli('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
    $query = false;
    if($conn){
      $query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
      $role = 0;
      if($islogged){
        $user = $conn->query("SELECT * FROM users WHERE user LIKE " . $_COOKIE['auth-u']);
        if($user){
          $user = $user->fetch_array();
          if($user && $user['user'] == $_COOKIE['auth-u'] && $user['pass'] == $_COOKIE['auth']){
            $role = intval($user['role'], 10);
          }
        }
      }
    }
    else{
      //Connection to the database has failed
    }
    $conn->close();
    if($query){
      while($rows = $query->fetch_array()){
        $id = $rows['id'];
        $title = $rows['title'];
        $content = $rows['content'];
        $date = new DateTime($rows['date']);
        $enddate = new DateTime($rows['enddate']);
        $currentDate = new DateTime();
        if($date >= $currentDate){
          //Create panel with event data
          $dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
      ?>
      <div class="event-card" id="<?php echo $id; ?>">
        <div class="box">
          <h3><?php echo htmlentities($title);?></h3>
          <hr>
          <div class="content">
            <i class="material-icons">event</i>
            <p><?php echo "Veke: " . $date->format("W"); ?></p>
            <i class="material-icons">schedule</i>
            <p>
              <?php
              $dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
              if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
                echo $dateFormatter->format($date) . " - " .$enddate->format("H:i");
              }
              else{
                echo $dateFormatter->format($date) . " - "  .$dateFormatter->format($enddate);
              }
              ?>
            </p>
            <?php if($content != ""){ ?>
              <i class="material-icons">label</i>
              <p><?php echo htmlentities($content);?></p>
              <?php } ?>
            </div>
            <?php if($role > 0){ ?>
              <hr>
              <div class="actions">
                <button class="btn-icon btn-edit"> <i class="material-icons">create</i></button>
                <button class="btn-icon btn-delete"> <i class="material-icons" data-toggle="modal"  data-target="#deleteModal">delete</i></button>
              </div>
              <?php } ?>
        </div>
      </div>
    <?php
          break;
        }
      }
    }
    ?>
  </div>
  <div class="maps col-sm-6">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2070.5722187386423!2d5.643130652691946!3d58.73721329053371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x463a4762f8dea037%3A0x2effe3585aa84cef!2sBrynevegen+9%2C+4340+Bryne!5e0!3m2!1sno!2sno!4v1448825378362" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>

<?php
if($role > 0){
?>
  <div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Slett</h4>
        </div>
        <div class="modal-body">
          <p>Er du sikker? Dette kan ikkje gjerast om på.</p>
        </div>
        <div class="modal-footer">
          <form id="deleteForm" action="edit_program.php" method="post">
            <button id="deleteButton" class="btn btn-danger" type="submit" name="delete">Slett</button>
            <input id="deleteId" hidden type="text" name="id" value="">
          </form>
          <button class="btn btn-default" type="button" data-dismiss="modal">Lukk</button>
        </div>
      </div>
    </div>
  </div>
<?php if(empty($_COOKIE['auth-u'])): ?>
</div>
<?php endif; ?>
<?php
}
?>
    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

    <script>
    var main = function(){
    	$('.event-panel').click(function(){
    		//Highlight the clicked element
    		if($(this).hasClass('panel-primary')){
    			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
    			$('.btn-edit').addClass('hidden');
    		}
    		else{
    			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
    			$(this).removeClass('panel-default').addClass('panel-primary');
    			$('.btn-edit').addClass('hidden');
    			$('.btn-edit', this).removeClass('hidden');
    		}

    		//show the edit button in the clicked element

    	});
    	$('.btn-edit').click(function(){
    		var url = window.location.href;
    		var id = $(this).closest('div[id]').attr('id');
    		url = 'edit_program.php' + "?id=" + id;
    		//Redirect to the edit-program page
    		window.location.assign(url);
    	});
      $('.btn-delete').click(function(){
        var id = $(this).closest('div[id]').attr('id');
        $('#deleteId').attr('value', id);
      })
      $('.maps').click(function () {
        $('.maps iframe').css("pointer-events", "auto");
      });
      $( ".maps" ).mouseleave(function() {
        $('.maps iframe').css("pointer-events", "none");
      });
    }

    $(document).ready(main);
    </script>
    <script type="text/javascript">$('.carousel').carousel({interval: 10000, keyboard:true});</script>
		<script src="js/app.js"></script>
  </body>
</html>
