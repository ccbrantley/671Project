<?php
session_start();
$loginResponse = '';
if (isset($_POST['loginSubmit'])) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
	$user = loginUser(array($_POST['userName'], $_POST['password']));
	if ($user !== NULL) {
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['f_name'] = $user['f_name'];
		if ($_SESSION['loginRedirect'] !== NULL) {
			$redirect = $_SESSION['loginRedirect'];
			$_SESSION['loginRedirect'] = NULL;
			header($redirect);
		}
		$loginResponse = '<p class = "successText">';
		$loginResponse .= 'Login was successful!</p>';
	}
	else {
		$loginResponse = '<p class = "failedText">';
		$uniqueUserName = uniqueUserName($_POST['userName']);
		if ($uniqueUserName === NULL) {
			$loginResponse .= 'Login was not successful';
		}
		else if ($uniqueUserName === False) {
			$loginResponse .= 'Please check that your password is correct.';
		}
		else {
			$loginResponse .= 'Please check that your username is correct.';
		}
		$loginResponse .= '</p>';
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
$loginResponse
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
