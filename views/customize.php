<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo "<h1>Customizing {$_POST['base_id']}</h1>";
include_once $_SERVER['DOCUMENT_ROOT'] . "/671Project/tools/DBFunctions.php";
$processorId = baseIdToProcessorId($_POST['base_id'])[0]['processor_id'];
echo "<h1>Processor: $processorId</h1>";
$availableMemory = processorToAvailableMemory($processorId);
$availableStorage = processorToAvailableStorage($processorId);
$availableOs = processorToAvailableOS($processorId);
echo "Available Memory";
foreach ($availableMemory as $row) {
	echo "<br>";
	echo $row['memory_id'] . ' ';
	echo $row['size'] . ' ';
	echo $row['price'];
}
echo "<br>";
echo "Available Storage";
foreach ($availableStorage as $row) {
	echo "<br>";
	echo $row['storage_id'] . ' ';
	echo $row['type'] . ' ';
	echo $row['price'];
}
echo "<br>";
echo "Available OS";
foreach ($availableOs as $row) {
	echo "<br>";
	echo $row['name'] . ' ';
	echo $row['price'];
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';                                                                                                                    
?>
