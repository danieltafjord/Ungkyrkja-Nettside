<?php
    require_once('load.php');
    $j->register('login.php');
?>

<html>
    <head>
        <title>Registrer</title>
        <style type="text/css">
            body { background: #f9f9f9;}
        </style>

        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>

    <body>

        <div style="width: 1200px; background: #fff; padding: 30px; margin: 20px auto;">
            <h3>Registrer</h3>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table>
                    <tr>
                        <td>Navn:</td>
                        <td><input type="text" name="name" /></td>
                    </tr>
                    <tr>
                        <td>Brukernavn:</td>
                        <td><input type="text" name="username" /></td>
                    </tr>
                    <tr>
                        <td>Passord:</td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="email" /></td>
                    </tr>
                    <input type="hidden" name="date" value="<?php echo time(); ?>" />
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Register" /></td>
                    </tr>
                </table>
            </form>
            <p>Har bruker? <a href="login.php">Log inn her</a></p>
        </div>
    </body>
</html>