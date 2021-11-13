<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
if (isset($_SESSION['purchaseStatus'])) {
	if ($_SESSION['purchaseStatus']) {
		echo "<p class = 'successText pPadding'>Item purchased successfully.</p>";
	}
	else {
		echo "<p class = 'failedText pPadding'>Unable to purchase item.</p>";
	}
	unset($_SESSION['purchaseStatus']);
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
