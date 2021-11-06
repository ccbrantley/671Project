<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo "<h1>Purchase</h1>";
echo "Chosen base id: " . $_SESSION['chosen_base_id'] . "<br>";
echo "Chosen memory id: " . $_SESSION['chosen_memory_id'] . "<br>";
echo "Chosen storage id: " . $_SESSION['chosen_storage_id'] . "<br>";
echo "Chosen os name: " . $_SESSION['chosen_os_name'] . "<br>";
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
