<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/DatabaseMap.php';
echo <<<EOD
<div class = "salesData">
	<div class = "loginDiv">
		<div class = "loginBorder">
			<h3>Total Sales</h3>
			<form method = "post" action = "/671Project/admin/views/AdminStats.php">
				<div>
					<p>
					<label for = "startDate">Start Date:</label>
					<input type = "date" id = "startDate" name = "startDate" value = "0000-00-00">
					</p>
					<p>
					<label for = "endDate">End Date:</label>
					<input type = "date" id = "endDate" name = "endDate" value = "0000-00-00">
					</p>
				</div>
				<div>
					<input type = "submit" name = "salesDate" value = "Submit">
				</div>
			</form>
			<div>
			</div>
		</div>
	</div>
	<div class = "salesDisplay">
EOD;
if (isset($_POST['salesDate'])) {
	if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
		$query = "SELECT SUM(price) AS sales FROM PURCHASE WHERE date >= ? AND date <= ?;";
		$result = preparedQuery($query, array($_POST['startDate'], $_POST['endDate']));
		echo "<h3>Sales: \${$result[0]['sales']}</h3>";
	}
	else {
		echo "<h3>Please set date constraints.</h3>";
	}
}
echo <<<EOD
	</div>
</div>
EOD;
echo <<<EOD
<div class = "salesData">
	<div class = "loginDiv">
		<div class = "loginBorder">
			<h3>Best/Worst Sellers</h3>
			<form method = "post" action = "/671Project/admin/views/AdminStats.php">
				<div>
					<p>
						<label for = "desc">Best Sellers</label>
						<input type = "radio" id = "desc" name = "top_3" value = "desc">
						<label for = "asc">Worst Sellers</labeL>
						<input type = "radio" id = "asc" name = "top_3" value = "asc">
					</p>
					<p>
						<label for = "bestBase">By Base System</label>
						<input type = "radio" id = "bestBase" name = "bestSeller" value = "base_id">
					</p>
					<p>
						<label for = "bestMemory">By Memory</label>
						<input type = "radio" id = "bestMemory" name = "bestSeller" value = "memory_id">
					</p>
					<p>
						<label for = "bestStorage">By Storage</label>
						<input type = "radio" id = "bestStorage" name = "bestSeller" value = "storage_id">
					</p>
					<p>
						<label for = "bestOS">By OS</label>
						<input type = "radio" id = "bestOS" name = "bestSeller" value = "os_name">
					</p>
				</div>
				<div>
					<input type = "submit" name = "bestSellerSubmit" value = "Submit">
				</div>
			</form>
		</div>
	</div>
	<div class = "salesDisplay">
EOD;
if (isset($_POST['bestSellerSubmit'])) {
	if (!empty($_POST['bestSeller']) && !empty($_POST['top_3'])) {
		$query = "SELECT COUNT({$_POST['bestSeller']}) AS totalSold, {$_POST['bestSeller']} FROM PURCHASE GROUP BY {$_POST['bestSeller']} ORDER BY totalSold {$_POST['top_3']};";
		$result = regularQuery($query);
		if ($_POST['top_3'] == "asc") {
			$saleType = "Worst";
		}
		else {
			$saleType = "Best";
		}
		echo "<h3>Top 3 $saleType Sellers by {$tables['purchase']['attributes'][$_POST['bestSeller']]}</h3>";
		echo <<<EOD
			<div class = "divTable">
				<div class = "divHeader">
					<div class = "divCell">{$tables['purchase']['attributes'][$_POST['bestSeller']]}</div>
					<div class = "divCell">Total Sold</div>
				</div>
		EOD;
		$counter = 0;
		foreach ($result as $row) {
			echo <<<EOD
				<div class = "divRow">
					<div class = 'divCell'>{$row[$_POST['bestSeller']]}</div>
					<div class = 'divCell'>{$row['totalSold']}</div>
				</div>
			EOD;
			$counter += 1;
			if ($counter === 3) {
				break;
			}
		}
		echo <<<EOD
			</div>
		EOD;
	}
	else {
		echo "<h3>Please set constraints.</h3>";
	}
}
echo <<<EOD
	</div>
</div>
EOD;
echo <<<EOD
<div class = "salesData">
	<div class = "loginDiv">
		<div class = "loginBorder">
			<h3>Items Not Selling</h3>
			<form method = "post" action = "/671Project/admin/views/AdminStats.php">
				<div>
					<p>
						<label for = "bestBase">By Base System</label>
						<input type = "radio" id = "bestBase" name = "noSeller" value = "baseSystem">
					</p>
					<p>
						<label for = "bestMemory">By Memory</label>
						<input type = "radio" id = "bestMemory" name = "noSeller" value = "memory">
					</p>
					<p>
						<label for = "bestStorage">By Storage</label>
						<input type = "radio" id = "bestStorage" name = "noSeller" value = "storage">
					</p>
					<p>
						<label for = "bestOS">By OS</label>
						<input type = "radio" id = "bestOS" name = "noSeller" value = "os">
					</p>
				</div>
				<div>
					<input type = "submit" name = "noSellerSubmit" value = "Submit">
				</div>
			</form>
		</div>
	</div>
	<div class = "salesDisplay">
EOD;
if (isset($_POST['noSellerSubmit'])) {
	if (!empty($_POST['noSeller'])) {
		$keys = $tables[$_POST['noSeller']]['keys'];
		$selectArg = "";
		for ($i = 0; $i < sizeof($keys); $i++) {
			$selectArg .= $keys[$i];
			if (($i + 1) <sizeof($keys)) {
				$selectArg .= ", ";
			}
		}
		$tableName = $tables[$_POST['noSeller']]['tableName'];
		if ($_POST['noSeller'] == "os") {
			$query = "SELECT $selectArg FROM $tableName WHERE $selectArg NOT IN (SELECT os_$selectArg FROM PURCHASE);";
		}
		else {
			$query = "SELECT $selectArg FROM $tableName WHERE $selectArg NOT IN (SELECT $selectArg FROM PURCHASE);";
		}
		echo <<<EOD
			<h3>{$tables[$_POST['noSeller']]['displayName']}</h3>
			<div class = "divTable">
				<div class = "divHeader">
					<div class = "divCell">{$tables[$_POST['noSeller']]['attributes'][$selectArg]}</div>
				</div>
		EOD;
		$result = regularQuery($query);
		foreach ($result as $row) {
			echo <<<EOD
				<div class = "divRow">
					<div class = "divCell">{$row[$selectArg]}</div>
				</div>
			EOD;
		}
		echo <<<EOD
			</div>
		EOD;
	}
	else {
		echo "<h3>Please select constraints.</h3>";
	}
}
echo <<<EOD
	</div>
</div>
EOD;
echo <<<EOD
<div class = "salesData">
	<div class = "loginDiv">
		<div class = "loginBorder">
			<h3>Purchase History</h3>
			<form method = "post" action = "/671Project/admin/views/AdminStats.php">
				<div>
					<p>
					<label for = "startDate">Start Date:</label>
					<input type = "date" id = "startDate" name = "startDate" value = "0000-00-00">
					</p>
					<p>
					<label for = "endDate">End Date:</label>
					<input type = "date" id = "endDate" name = "endDate" value = "0000-00-00">
					</p>
				</div>
				<div>
					<input type = "submit" name = "rangedSalesSubmit" value = "Submit">
				</div>
			</form>
			<div>
			</div>
		</div>
	</div>
EOD;
if (isset($_POST['rangedSalesSubmit'])) {
	if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
		echo <<< EOD
		</div>
		<div class = "divTable">
			<div class = "divHeader">
		EOD;
		foreach($tables['purchase']['attributes'] as $key => $value) {
			echo "<div class = 'divCell'>$key</div>";
		}
		echo "</div>";
		$query = "SELECT * FROM PURCHASE WHERE date >= ? AND date <= ?;";
		$result = preparedQuery($query, array($_POST['startDate'], $_POST['endDate']));
		foreach ($result as $row) {
			echo "<div class = 'divRow'>";
			foreach ($tables['purchase']['attributes'] as $key => $value) {
				echo "<div class = 'divCell'>{$row[$key]}</div>";
			}
			echo "</div>";
		}
		echo "</div>";
	}
	else {
		echo <<<EOD
			<div class = "salesDisplay">
			<h3>Please enter in the constraints.</h3>
			</div>
			</div>
		EOD;
	}
}
else {
	echo "</div>";
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
