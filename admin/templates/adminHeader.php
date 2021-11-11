<?php
session_start();
echo <<<EOD
<!DOCTYPE HTML>
<html>
	<head>
		<title>671 Project</title>
		<link rel = "stylesheet" type = "text/css" href = "/671Project/style/style.css">
	</head>
	<body>
		<div class = "mainNavigation">
			<a href = "/671Project/index.php">Home</a>
			<a href = "/671Project/views/products.php">Products</a>
			<div class = "dropDown">
				<a class = "disabled" href = "" >Account</a>
				<div class = "dropDownContent">
EOD;
if (isset($_SESSION['user_id'])) {
	$displayName = $_SESSION['f_name'];
	if (strlen($displayName) > 10) { $displayName = substr($displayName, 0, 10) . '...'; }
	echo <<<EOD
		<a class = 'disabled firstNameDisplay' href = '' >Welcome back $displayName.</a>
		<a href = '/671Project/views/logout.php'>Logout</a>
		<a href = '/671Project/views/account.php'>Account</a>
	EOD;
}
else {
	echo <<<EOD
		<a href = "/671Project/views/login.php">Login</a>
		<a href = "/671Project/views/register.php">Register</a>
	EOD;
}
echo <<<EOD
				</div>
			</div>
		</div>
		<div class = 'divPage'>
EOD;
?>
