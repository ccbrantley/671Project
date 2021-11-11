<?PHP
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
$resultMessage = NULL;
if (!empty($_SESSION['purchase_status'])) {
	if (($_SESSION['purchase_status'])) {
		$resultMessage = "<p class = 'successText pPadding'>Item successfuly purchased.</p>";
	}
	else {
		$resultMessage = "<p class = 'failedText pPadding'>Unable to purchase the item.</p>";
	}
	unset($_SESSION['purchase_status']);
}
else if (!empty($_SESSION['wishlist_status'])) {
	if ($_SESSION['wishlist_status']) {
		$resultMessage = "<p class = 'successText pPadding'>Item successfuly added to your wishlist.</p>";
	}
	else {
		$resultMessage = "<p class = 'failedText pPadding'>Unable to add the item to your wishlist.</p>";
	}
	unset($_SESSION['wishlist_status']);
}
if ($resultMessage) { echo $resultMessage; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
