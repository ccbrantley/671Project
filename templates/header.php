<?php
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
				<a class = "disabled accountButton"href = "" >Account</a>
				<div class = "dropDownContent">
					<a href = "/671Project/views/login.php">Login</a>
					<a href = "/671Project/views/register.php">Register</a>
					<a href = "/671Project/views/account.php">Account</a>
				</div>
			</div>
		</div>
EOD;
?>
