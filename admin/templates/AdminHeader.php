<?php
session_start();
echo <<<EOD
<!DOCTYPE HTML>
<html>
	<head>
		<title> 671 Project</title>
		<link rel = "stylesheet" type = "text/css" href = "/671Project/style/admin.css">
	</head>
	<body>
EOD;
if (isset($_SESSION['admin_id'])) {
	echo <<<EOD
		<div class = "adminNavigation">
			<a href = "/671Project/admin/views/AdminCreate.php">Create</a>
			<a href = "/671Project/admin/views/AdminRead.php">Read</a>
			<a href = "/671Project/admin/views/AdminUpdate.php">Update</a>
			<a href = "/671Project/admin/views/AdminDelete.php">Delete</a>
			<a href = "/671Project/admin/views/AdminStats.php">Statistics</a>
			<a href = "/671Project/admin/views/AdminProcessPurchase.php">Process Purchase</a>
			<a href = "/671Project/admin/views/AdminLogout.php">Logout</a>
		</div>
	EOD;
}
else {
	if (end(explode("/", $_SERVER['SCRIPT_FILENAME'])) != "AdminLogin.php") {
		header("Location: /671Project/admin/views/AdminLogin.php");
	}
	else {
		echo <<<EOD
			<div class = "adminNavigation">
			</div>
		EOD;
	}
}
echo "<div class = 'lessBlankSpace'></div>";
?>
