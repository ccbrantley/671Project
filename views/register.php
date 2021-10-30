<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
	echo <<<EOD
		<h1>Registration</h1>
		<form class = "registerForm" action = "" method = "post">
			<div>
				<p>
				<label for = "userName">User Name:</label>
				<input type = "text" id = "userName" name = "userName" required>
				</p>

				<p>
				<label for = "password">Password:</label>
				<input type = "password" id = "password" name = "password" required>
				</p>

				<p>
				<label for = "firstName">First Name:</label>
				<input type = "text" id = "firstName" name = "firstName" required>
				</p>

				<p>
				<label for = "lastName">Last Name:</label>
				<input type = "text" id = "lastName" name = "lastName" required>
				</p>

				<p>
				<label for = "streetAddress">Street:</label>
				<input type = "text" id = "streetAddress" name = "streetAddress" required>
				</p>

				<p>
				<label for = "cityAddress">City:</label>
				<input type = "text" id = "cityAddress" name = "cityAddress" required>
				</p>

				<p>
				<label for = "zipAddress">Zip:</label>
				<input type = "text" id = "zipAddress" name = "zipAddress" required>
				</p>

				<p>
				<label for = "stateAddress">State:</label>
				<input type = "text" id = "stateAddress" name = "stateAddress" required>
				</p>

				<p>
				<label for = "countryAddress">Country:</label>
				<input type = "text" id = "countryAddress" name = "countryAddress" required>
				</p>

				<p>
				<label for = "creditCard">Credit Card:</label>
				<input type = "text" id = "creditCard" name = "creditCard" required>
				</p>
			</div>

			<div>
				<input type = "submit" value = "Register">
			</div>
		</form>
	EOD;
?>
