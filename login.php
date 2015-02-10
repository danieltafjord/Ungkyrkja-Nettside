<?php
    require_once('load.php');
    if ( $_GET['action'] == 'logout' ) {
        $loggedout = $j->logout();
    }
    $logged = $j->login('indexa.php');
?>
<html>
    <head>
        <title>Login</title>
        <style type="text/css">
            body { background: #f9f9f9;}
        </style>

        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>

        <div style="width: 1200px; background: #fff; padding: 30px; margin: 20px auto;">
            <?php if ( $logged == 'invalid' ) : ?>
                <p style="background: #D03B3B; padding: 10px 13px;font-size:15px;">
                    Brukernavn og passord kombinasjonen var ugyldig, prøv igjen.
                </p>
            <?php endif; ?>
            <?php if ( $_GET['reg'] == 'true' ) : ?>
                <p style="background: #4DD03B; padding: 10px 13px;font-size:15px;">
                    Registrert! logg på under.
                </p>
            <?php endif; ?>
            <?php if ( $_GET['action'] == 'logout' ) : ?>
                <?php if ( $loggedout == true ) : ?>
                    <p style="background: #4DD03B; padding: 10px 13px;font-size:15px;">
                       Logget ut.
                    </p>
                <?php else: ?>
                    <p style="background: #D03B3B; padding: 10px 13px;font-size:15px;">
                        Feil: Vi klarte ikke å logge deg ut, Prøv igjen.
                    </p>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( $_GET['msg'] == 'login' ) : ?>
                <p style="background: #D03B3B; padding: 10px 13px;font-size:15px;">
                        Du må logge på for å se denne siden, logg på under.
                    </p>
            <?php endif; ?>

            <h3>Login</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="width:162px;">
                <label>Brukernavn:</label><input type="text" name="username" /><br>
                <label>Passord:</label><input type="password" name="password" />
                <input type="submit" value="Login" style="margin-top:8px;background-color:#fff;border:1px solid #f1f1f1;float:right;" />
            </form>
        </div>
    </body>
</html>