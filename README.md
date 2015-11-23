# Ungkyrkja-Nettside

# TODO

John Ingve:
- Fix login and register in /account (change setcookie path for /account)

Daniel:
- Style index
- Add reqirements for registrations

# Using error class

<p>Add this</p>
```PHP
use Project\Error\error;
include('error.php');
```
```PHP
error::report('File name', 'Error message', 'Error type', 'IP', 'date');
```
<p>Example:</p>
```PHP
error::report($_SERVER['PHP_SELF'], 'Could not connect to database', 'Fatal', $_SERVER['REMOTE_ADDR'], date('Y-m-d h:i:sa'));
```
