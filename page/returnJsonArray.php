<?php
$dsn = "mysql:host=localhost;dbname=my_flavilla;charset=utf8";
//$dsn = "mysql:host=localhost;dbname=socialStream;charset=utf8";
$result = null;
$msg = null;
$id = filter_input(INPUT_GET, 'id');
//header("Content-type: text/javascript");
/** dati di rete su server **/
/*$conn = mysqli_connect("localhost", "flavilla", "fla63da68au04", "my_flavilla");
$query = "SELECT * FROM myFla1_clientsocials WHERE id = $id";*/
/** dati di localhost su c **/
try {
    $conn = new PDO($dsn, "mediaitaliaweb", "");
    $query = 'SELECT * FROM `clientsocials` WHERE id_long = "'.$id.'";';
    $stm = $conn->prepare($query);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    $stm->closeCursor();
    $stm = null;
    $conn = null;
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
if ($result){
    echo json_encode($result);
} elseif ($msg) {
    echo "il codice $id è fallito con questo messaggio: $msg";
}
