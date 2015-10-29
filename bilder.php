<?php
  $con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://i.imgur.com/qm15Oaf.png" sizes="192x192">
    <meta name="theme-color" content="#222">
    <title>Ungkyrkja</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/main-css.html">
  </head>
  <style media="screen">
    .photos {
      line-height: 0;
      -webkit-column-count: 5;
      -webkit-column-gap:   0px;
      -moz-column-count:    5;
      -moz-column-gap:      0px;
      column-count:         5;
      column-gap:           0px;
    }

    .g-img {
      width: 100% !important;
      height: auto !important;
      padding: 5px;
    }
    .p-div {
      margin-top: 100px;
    }
    .p-img {
      max-width: 500px;
    }
    .p-div-com {
      background-color:#eee;
    }
  </style>
  <body>
    <!--Import navbar-->
    <?php include 'components/navbar.php'; ?>

    <!--Content here-->
    <section class="photos" align="center">
      <?php
        $images = mysqli_query($con, "SELECT * FROM bilder");

        # check if img is not set
        if(!isset($_GET['img'])) {
          while($rows = mysqli_fetch_array($images)) {
            #if file exist show image
            if(file_exists('img/' . $rows['img'])) {
              echo "<a href='?img=" . $rows['id'] . "'><img class='g-img' src='img/" . $rows['img'] . "'></a>";
            }
          }
        }
      ?>
    </section>
    <?php

    # Check if img is set
    if (isset($_GET['img'])) {
      $get_image = $_GET['img'];
      $sql_image = mysqli_query($con, "SELECT * FROM bilder WHERE id = {$get_image}");
      while($row = mysqli_fetch_array($sql_image, MYSQLI_ASSOC)) {
        echo "<div align='center' class='p-div'>";
          echo "<img class='p-img' src='img/" . $row['img'] . "'>";
        echo "</div>";
        echo "<div align='center' class='p-div-com'>";
          echo "";
        echo "</div>";
      }
    }

    ?>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

    <link rel="import" href="components/main-scripts.html">
  </body>
</html>
