<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
$message = NULL;
if (isset($_SESSION['delete_query_result'])) {
	if ($_SESSION['delete_query_result']) {
		$message = "<p class = 'successText'>Entry was successfully deleted.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Entry was not deleted.</p>";
	}
	unset($_SESSION['delete_query_result']);
}
else if (isset($_SESSION['create_query_result'])) {
	if ($_SESSION['create_query_result']) {
		$message = "<p class = 'successText'>Entry was successfully created.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Entry was not created.</p>";
	}
	unset($_SESSION['create_query_result']);
}
else if (isset($_SESSION['update_query_result'])) {
	if ($_SESSION['update_query_result']) {
		$message = "<p class = 'successText'>Entry was successfully updated.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Entry was not updated.</p>";
	}
	unset($_SESSION['update_query_result']);
}
else if (isset($_SESSION['process_purchase_result'])) {
	if ($_SESSION['process_purchase_result']) {
		$message = "<p class = 'successText'>Purchase was successfully processed.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Purchase was not successfully processed.</p>";
	}
	unset($_SESSION['process_purchase_result']);
}
if ($message) { echo $message; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
