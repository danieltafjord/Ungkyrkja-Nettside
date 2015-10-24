<?php
  $con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f57c00">
    <link rel="icon" href="img/uk_logo.png" sizes="192x192">
    <title>Ungkyrkja</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/main-css.html">
  </head>
  <style media="screen">
    .photos {
      /* Prevent vertical gaps */
      line-height: 0;

      -webkit-column-count: 5;
      -webkit-column-gap:   0px;
      -moz-column-count:    5;
      -moz-column-gap:      0px;
      column-count:         5;
      column-gap:           0px;
    }

    .photos img {
      /* Just in case there are inline attributes */
      width: 100% !important;
      height: auto !important;
      padding: 5px;
    }
  </style>
  <body>
    <!--Import navbar-->
    <?php include 'components/navbar.php'; ?>
    <!--Content here-->
    <section class="photos">
      <?php
        $images = mysqli_query($con, "SELECT * FROM bilder");
        while($rows = mysqli_fetch_array($images)) {
          echo "<a href='?img=" . $rows['id'] . "'><img src='img/" . $rows['img'] . "'></a>";
        }
      ?>
    </section>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

    <link rel="import" href="components/main-scripts.html">
  </body>
</html>
