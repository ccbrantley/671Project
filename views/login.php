<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
session_start();
$loginResponse = NULL;
if (isset($_POST['loginSubmit'])) {
	$user = loginUser(array($_POST['userName'], $_POST['password']));
	if ($user !== NULL) {
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['f_name'] = $user['f_name'];
		$loginResponse = '<p class = "successText">Login was successful!</p>';
	}
	else {
		$uniqueUserName = uniqueUserName($_POST['userName']);
		if ($uniqueUserName === NULL) {
			$loginResponse = '<p class = "failedText">Login was not successful.</p>';
		}
		else if ($uniqueUserName === False) {
			$loginResponse = '<p class = "failedText">Please check that your password is correct.</p>';
		}
		else {
			$loginResponse = '<p class = "failedText">Please check that your username is correct.</p>';
		}
	}
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo <<<EOD
<h1>Login</h1>
<form class = "standardForm" action = "/671Project/views/login.php" method = "post">
	<div>
		<p>
			<label for = "userName">User Name:</label>
			<input type = "text" id = "userName" name = "userName" required>
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
EOD;
if ($loginResponse) { echo $loginResponse; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
