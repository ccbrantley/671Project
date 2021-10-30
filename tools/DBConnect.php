<?PHP
function getPDO() {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/671homework3/config/credentials.php";
  try {
     $pdo = new PDO($dsn, $userName, $password, $options);
  }
  catch (PDOException $ex) {
    return NULL;
  }
  return $pdo;
}
?>
