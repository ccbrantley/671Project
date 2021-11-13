<?php
session_start();
session_unset();
session_destroy();
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
