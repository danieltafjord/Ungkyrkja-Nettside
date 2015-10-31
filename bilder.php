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
      -webkit-transition: opacity 650ms ease-in-out;
      transition: opacity 650ms ease-in-out;
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
      while($row = mysqli_fetch_array($sql_image, MYSQLI_ASSOC)) :
        echo "<div align='center' class='p-div'>";
          echo "<img class='p-img' src='img/" . $row['img'] . "'>";
          echo "<p style='margin-top:40px;background-color:#f4f4f4;padding:30px;width:90%;font-size:18px;'>" . $row['description'] . "</p>";
        echo "</div>"; ?>
        <div align="center" style="background-color:#f4f4f4;">
        <div id="disqus_thread" style="width:90%;margin-top:50px;padding-top:20px;"></div>
          <script>
              /**
               *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
               *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
               */
              /*
              var disqus_config = function () {
                  this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                  this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
              };
              */
              (function() {  // DON'T EDIT BELOW THIS LINE
                  var d = document, s = d.createElement('script');

                  s.src = '//danieltafjord.disqus.com/embed.js';

                  s.setAttribute('data-timestamp', +new Date());
                  (d.head || d.body).appendChild(s);
              })();
          </script>
          <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
        </div>
        <?php
      endwhile;
    }

    ?>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

    <link rel="import" href="components/main-scripts.html">
    <script id="dsq-count-scr" src="//danieltafjord.disqus.com/count.js" async></script>
  </body>
</html>
