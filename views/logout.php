<?php
session_start();
session_unset();
session_destroy();
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo <<<EOD
	<p class = 'successText'>You have been successfully logged out.</p> 
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
