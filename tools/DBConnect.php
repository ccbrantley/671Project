<?PHP
function getPDO() {
  include $_SERVER['DOCUMENT_ROOT'] . "/671Project/config/credentials.php";
  try {
     $pdo = new PDO($dsn, $userName, $password, $options);
  }
  catch (PDOException $ex) {
    return NULL;
  }
  return $pdo;
}
?>
