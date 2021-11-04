<?php
function productTableDisplay ($_arguments) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
	$actionPage = '/671Project/views/customize.php';
	$table .= "<form class = 'formTable' action = '$actionPage' method = 'post'>";
	$table .= '<div class = "divHeader">';
	$table .= '<div class = "divCell">Processor</div>';
	$table .= '<div class = "divCell">Memory</div>';
	$table .= '<div class = "divCell">Storage</div>';
	$table .= '<div class = "divCell">OS</div>';
	$table .= '<div class = "divCell">Specifications</div>';
	$table .= '<div class = "divCell">Price</div>';
	$table .= '<div class = "divCell">';
	$table .= "<input type = 'submit' name = 'customize' value = 'Customize'>";
	$table .= '</div>';
	$table .= "</div>";
	foreach ($_arguments as $row) {
		$table .= '<div class = "divRow">';
		$table .= "<div class = 'divCell'>{$row['processor_name']}</div>";
		$table .= "<div class = 'divCell'>{$row['memory_size']} gb </div>";
		$table .= "<div class = 'divCell'><ul>";
		$table .= "<li>{$row['storage_size']} gb</li>";
		$table .= "<li>{$row['storage_type']}</li>";
		$table .= "</ul></div>";
		$table .= "<div class = 'divCell'>{$row['operating_system']}</div>";
		$table .= "<div class = 'divCell'><ul>";
		$table .= "<li>". intval($row['weight']) . " grams</li>";
		$table .= "<li>" . $row['size'] . " inches</li>";
		$table .= "<li>{$row['type']}</li>";
		$table .= "</ul></div>";
		$table .= "<div class = 'divCell'>\${$row['price']}</div>";
		$table .= "<div class = 'divCell'>";
		$table .= "<input type = 'radio' name = 'base_id' value = '{$row['base_id']}'>";
		$table .= "</div>";
		$table .= '</div>';
	}
	$table .= "</form>";
	return $table;
}
function baseProductTableDisplay () {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
	return productTableDisplay(getBaseProducts());
}
function searchBaseProductTableDisplay () {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
	return productTableDisplay(searchBaseProducts());
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo <<<EOD
<div class = "productAndSearchDiv">
	<div class = "searchBar">
		<form class = "standardForm searchForm" action = "" method = "post">
			<div class = "searchBarDiv">
				<p>
					<label for "maxPrice">Max Price:</label>
					<input id = "maxPrice" name = "maxPrice" type = "text" pattern = "[0-9]*">
				</p>
				<p>
					<label for "maxWeight">Max Weight (grams):</label>
					<input id = "maxWeight" name = "maxWeight" type = "text" pattern = "[0-9]*">
				</p>
				<p>
					<label for "size">Size (in):</label>
					<input id = "size" name = "size" type = "number" min = "6">
				</p>
					<label for "laptop">Laptops:</label>
					<input id = "laptops" name = "laptops" type = "checkbox">
				<p>
				</p>
					<label for "tablet">Tablets:</label>
					<input id = "tablets" name = "tablets" type = "checkbox">
				<p>
				</p>
				<p>
					<label for "hybrid">Hybrid:</label>
					<input id = "hybrid" name = "hybrid" type = "checkbox">
				</p>
			</div>
			<div>
				<input type = "submit" name = 'search' value = "Search">
			</div>
		</form>
	</div>
	<div class = "productDisplay">
EOD;
if (!isset($_POST['search'])) {
	echo baseProductTableDisplay();
}
else {
	echo searchBaseProductTableDisplay();
}
echo <<<EOD
	</div>
</div>
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
