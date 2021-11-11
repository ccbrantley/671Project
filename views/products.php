<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
function productTableDisplay ($_arguments) {
	echo <<<EOD
	<form class = 'formTable' action = '/671Project/views/customize.php' method = 'post'><div class = "divHeader">
		<div class = "divHeader">
			<div class = "divCell">Processor</div>
			<div class = "divCell">Memory</div>
			<div class = "divCell">Storage</div>
			<div class = "divCell">OS</div>
			<div class = "divCell">Specifications</div>
			<div class = "divCell">Price</div>
			<div class = "divCell"><input type = 'submit' name = 'customize' value = 'Customize'></div>
		</div>
	EOD;
	foreach ($_arguments as $row) {
		$weight = intval($row['weight']);
		echo <<<EOD
		<div class = "divRow">
			<div class = 'divCell'>{$row['processor_name']}</div>
			<div class = 'divCell'>{$row['memory_size']} gb </div>
			<div class = 'divCell'><ul>
				<li>{$row['storage_size']} gb</li>
				<li>{$row['storage_type']}</li>
			</ul></div>
			<div class = 'divCell'>{$row['operating_system']}</div>
			<div class = 'divCell'><ul>
				<li>$weight grams</li>
				<li>{$row['size']} inches</li>
				<li>{$row['type']}</li>
			</ul></div>
			<div class = 'divCell'>{$row['price']}</div>
			<div class = 'divCell'><input type = 'radio' name = 'base_id' value = '{$row['base_id']}'></div>
		</div>
		EOD;
	}
	echo "</form>";
}
echo <<<EOD
<div class = "productAndSearchDiv">
	<div class = "searchBar">
		<form class = "standardForm searchForm" action = "" method = "get">
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
if (!isset($_GET['search'])) {
	productTableDisplay(getBaseProducts());
}
else {
	productTableDisplay(searchBaseProducts());
}
echo <<<EOD
	</div>
</div>
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
