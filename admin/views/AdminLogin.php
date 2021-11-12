<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
session_start();
$loginResponse = NULL;
if (isset($_POST['loginSubmit'])) {
	$admin = loginAdmin($_POST['username'], $_POST['password']);
	if ($admin !== NULL) {
		$_SESSION['admin_id'] = $admin['user_id'];
		header("Location: /671Project/admin/Admin.php");
	}
	else {
		$loginResponse = "<p class = 'failedText'>Login was unsuccessful.</p>";
	}
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
echo <<<EOD
<div class = "loginDiv">
	<div class = "loginBorder">
	<h1>Login</h1>
	<form action = "/671Project/admin/views/AdminLogin.php" method = "post">
		<div>
			<p>
				<label for = "username">User Name:</label>
				<input type = "text" id = "username" name = "username" required>
			</p>
			<p>
				<label for = "password">Password:</label>
				<input type = "password" id = "password" name = "password" required>
			</p>
		</div>
		<div>
			<input type = "submit" name = "loginSubmit" value = "Login">
		</div>
	</form>
	</div>
</div>
EOD;
if ($loginResponse) { echo $loginResponse; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
