<?php

//CONEXION A LA BASE DE DATOS.

$host = "localhost";
$port = "5435"; 
$dbname = "db_prueba";
$user = "postgres";
$password = "113355";

$conex = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conex) {

    die('Error de conexión: ' . pg_last_error());
} else {

    echo 'Conexión Establecida';
}


$usuario = $_POST["email"];
$pass = $_POST["pass"];

//VALIDACION DE DATOS

 if($usuario === "" || $pass === ""){
    die ("Email y Contraseña son obligatorios");
 }else {
    echo ("¡Inicio Exitoso!usuario:  ".$usuario);
    echo ("  Su contraseña es: ".$pass);
}

$sql = "INSERT INTO usuario (correo, contraseña)VALUES('$usuario', '$pass') returning *";


$query = "SELECT correo, contraseña FROM usuario";
$result = pg_query($conex, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
} else {
    while ($row = pg_fetch_assoc($result)) {
        echo "Correo: " . $row['correo'] . "<br>";
        echo "Contraseña: " . $row['contraseña'] . "<br>";
        echo "------------------------<br>";
    }
}

$resultado = pg_query($conex, $sql);

if($resultado){
    echo json_encode($resultado);
}
else{
    "!UPS HA OCURRIDO UN ERROR AL GUARDAR LOS DATOS";
}



