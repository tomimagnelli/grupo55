<?php
 $db_host="localhost";
 $db_user="grupo55";
 $db_pass="ahT0aShiiw";
 $db_base="grupo55";
 $cn = new PDO("mysql:dbname=$db_base;host=$db_host",$db_user,$db_pass);
 $query = "SELECT * FROM categoria";
 $sentencia = $cn->prepare("INSERT INTO categoria (nombre) VALUES (:nombre)");
$sentencia->bindParam(':nombre', $name);
// insertar una fila
$name = 'cereales';
$sentencia->execute();
 $result=$cn->query($query)->fetchAll();;

foreach( $result as $row ) {
    echo $row['id'];
    echo $row['nombre'];
}

?>
