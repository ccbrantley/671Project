<?PHP
$tables = [
"customer" =>
	[
	"displayName" => "Customers",
	"tableName" => "CUSTOMER",
	"attributes" =>
		[
		'user_id' => "User ID",
		'username' => "Username",
		'password' => "Password",
		'f_name' => "First Name",
		'l_name' => "Last Name",
		'street' => "Street",
		'city' => "City",
		'zip' => "Zip",
		'state' => "State",
		'country' => "Country",
		'credit_card' => "Credit Card",
		],
	"keys" =>
		[
		'user_id',
		],
	],
"wishList" =>
	[
	"displayName" => "Wish Lists",
	"tableName" => "WISHLIST",
	"attributes" => 
		[
		'wishlist_id' => "Wishlist ID",
		'user_id' => "User ID",
		'base_id' => "Base ID",
		'memory_id' => "Memory ID",
		'storage_id' => "Storage ID",
		'os_name' => "OS Name",
		],
	"keys" =>
		[
		'wishlist_id',
		],
	],
"purchase" =>
	[
	"displayName" => "Purchases",
	"tableName" => "PURCHASE",
	"attributes" =>
		[
		'purchase_id' => "Purchase ID",
		'user_id' => "User ID",
		'base_id' => "Base ID",
		'memory_id' => "Memory ID",
		'storage_id' => "Storage ID",
		'os_name' => "OS Name",
		'price' => "Price",
		'status' => "Order Status",
		'date' => "Purchase Date",
		],
	"keys" =>
		[
		'purchase_id',
		],
	],
"baseSystem" =>
	[
	"displayName" => "Base Systems",
	"tableName" => "BASE_SYSTEM",
	"attributes" =>
		[
		'base_id' => "Base ID",
		'processor_id' => "Processor ID",
		'memory_id' => "Memory ID",
		'storage_id' => "Storage ID",
		'os_name' => "OS Name",
		'weight' => "Weight",
		'size' => "Size",
		'price' => "Price",
		'type' => "Product Type",
		],
	"keys" =>
		[
		'base_id',
		],
	],
"storage" =>
	[
	"displayName" => "Storage",
	"tableName" => "STORAGE",
	"attributes" =>
		[
		'storage_id' => "ID",
		'size' => "Size",
		'qty' => "Quantity",
		'price' => "Price",
		'type' => "Storage Type",
		],
	"keys" =>
		[
		'storage_id',
		],
	],
"os" =>
	[
	"displayName" => "Operating Systems",
	"tableName" => "O_SYSTEM",
	"attributes" =>
		[
		'name' => "Name",
		'price' => "Price",
		],
	"keys" =>
		[
		'name',
		],
	],
"memory" =>
	[
	"displayName" => "Memory",
	"tableName" => "MEMORY",
	"attributes" =>
		[
		'memory_id' => "ID",
		'size' => "Size",
		'qty' => "Quantity",
		'price' => "Price",
		],
	"keys" =>
		[
		'memory_id',
		],
	],
"processor" =>
	[
	"displayName" => "Processors",
	"tableName" => "PROCESSOR",
	"attributes" =>
		[
		'processor_id' => "ID",
		'name' => "Name",
		'qty' => "Quantity",
		'price' => "Price",
		],
	"keys" =>
		[
		'processor_id',
		],
	],
"processorStorage" =>
	[
	"displayName" => "Processor-Storage",
	"tableName" => "PROCESSOR_STORAGE",
	"attributes" =>
		[
		'processor_id' => "Processor ID",
		'storage_id' => "Storage ID",
		],
	"keys" =>
		[
		'processor_id',
		'storage_id',
		],
	],
"processorOs" =>
	[
	"displayName" => "Processor-OS",
	"tableName" => "PROCESSOR_O_SYSTEM",
	"attributes" =>
		[
		'processor_id' => "Processor ID",
		'os_name' => "OS Name",
		],
	"keys" =>
		[
		'processor_id',
		'os_name',
		],
	],
"processorMemory" =>
	[
	"displayName" => "Processor-Memory",
	"tableName" => "PROCESSOR_MEMORY",
	"attributes" =>
		[
		'processor_id' => "Processor ID",
		'memory_id' => "Memory ID",
		],
	"keys" =>
		[
		'processor_id',
		'memory_id',
		],
	],
];
?>
