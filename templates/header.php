<?php
session_start();
$accountDropDown = "";

if (isset($_SESSION['user_id'])) {
	$shortFirstName = substr($_SESSION['f_name'], 0, 10) . '...';
	$accountDropDown = "
		<a class = 'disabled firstNameDisplay' href = '' >Welcome back $shortFirstName</a>
		<a href = '/671Project/views/logout.php'>Logout</a>
		<a href = '/671Project/views/account.php'>Account</a>
	";
}
else {
	$accountDropDown = '
		<a href = "/671Project/views/login.php">Login</a>
		<a href = "/671Project/views/register.php">Register</a>
	';
}
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
			<a href = "/671Project/views/purchase.php">Purchase</a>
			<div class = "dropDown">
				<a class = "disabled" href = "" >Account</a>
				<div class = "dropDownContent">
					$accountDropDown
				</div>
			</div>
		</div>
		<div class = 'divPage'>
EOD;
?>
