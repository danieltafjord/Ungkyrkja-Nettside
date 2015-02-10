<?php 

function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<form method="post" action="" name="nums" align="center">
	<input type="submit" name="submit" class="button" value="GENERATE">
</form>

<?php
	if (isset($_POST['submit'])) {
		echo generateRandomString();
	}
?>