<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
if (!$_SESSION) {
	echo "<p class = 'failedText pPadding'>Unable to purchase item.</p>";
}
else {
	echo "<p class = 'successText pPadding'>Item purchased successfully.</p>";
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
