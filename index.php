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
		<link href="css/index.css" rel="stylesheet">
    <!--Element imports-->
    <link rel="import" href="bower_components/iron-icons/iron-icons.html">
    <link rel="import" href="bower_components/iron-icon/iron-icon.html">
    <link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
    <link rel="import" href="bower_components/paper-card/paper-card.html">
  </head>
  <body>
    <!--Import navbar-->
    <?php
    $site_location = '/index.php';
    include 'components/navbar.php';
    ?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" style="max-height:450px;max-width:100%;">
    <?php

      $sqlfront = mysqli_query($con, "SELECT * FROM fremside WHERE active = 0");
      while ($row = mysqli_fetch_array($sqlfront)) {
        echo "<div class='item'>";
        echo "<img src='img/" . $row['name'] . "' style='width:100%;'>";
        echo "</div>";
      }

    ?>
    <?php

      $sqlfront1 = mysqli_query($con, "SELECT * FROM fremside WHERE active = 1");
      while ($rows = mysqli_fetch_array($sqlfront1)) {
        echo "<div class='item active'>";
          echo "<img src='img/" . $rows['name'] . "' style='width:100%;'>";
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

<!-- Section 2 -->
<div class="container-fluid" style="margin: 100px 0px;" id="program-next">

  <h1 align="center" style="font-size:32px;">Neste samling</h1>
  <hr width="100%" align="center" class="divider">
  <?php
  $conn = new mysqli("localhost", "root", "", "blog");
  $query = false;
  if($conn){
    $query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
    $role = 0;
    if($islogged){
      $user = $conn->query("SELECT * FROM users WHERE user LIKE " . $_COOKIE['auth-u'])->fetch_array();
      if($user && $user['user'] == $_COOKIE['auth-u'] && $user['pass'] == $_COOKIE['auth']){
        $role = intval($user['role'], 10);
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
      <paper-card heading="<?php echo $title;?>">
        <div class="card-content">
          <iron-icon icon="event"></iron-icon>
          <p><?php echo "Veke: " . $date->format("W"); ?></p>
          <iron-icon icon="schedule"></iron-icon>
          <p><?php
            $dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
            if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
              echo $dateFormatter->format($date) . " - " .$enddate->format("H:i");
            }
            else{
              echo $dateFormatter->format($date) . " - " .$dateFormatter->format($enddate);
            }
            ?></p>
            <?php if($content != ""){ ?>
            <iron-icon icon="label"></iron-icon>
            <p><?php echo $content;?></p>
            <?php } ?>
        </div>
        <?php if($role > 0){ ?>
        <div class="card-actions">
          <paper-icon-button class="btn-edit" icon="create"></paper-icon-button>
        </div>
        <?php } ?>
      </paper-card>
    </div>
  <?php
        break;
      }
    }
  }
  ?>
</div>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

		<script src="js/program.js"></script>
    <script type="text/javascript">$('.carousel').carousel({interval: 10000, keyboard:true});</script>
  </body>
</html>
