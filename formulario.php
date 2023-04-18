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
    // echo 'Conexión Establecida';
}


$usuario = $_POST["email"];
$pass = $_POST["pass"];

//VALIDACION DE DATOS DE LA BASE DE DATOS

if (trim($usuario) === "" && trim($pass) === "") {
    // Inicio de sesión fallido
    echo $response = array("success" => false, "message" => "Inicio de sesión fallido. Por favor, verifique su usuario y contraseña.");
    die;
    return;
}

$sql = "INSERT INTO usuario (email, password)VALUES('$usuario', '$pass') returning email";

$resultado = pg_query($conex, $sql);
if ($resultado) {
    // echo json_encode($resultado);
    // $response = array("success" => false, "message" => "Hubo algún error en la conexión.", "resultado" => '');

    // SELECT

    echo json_encode($response);
    // $response = array("success"  => true, "message" => "Inicio de sesión exitoso. Bienvenido, $usuario.");
} else {
    $response = array("success" => false, "message" => "Hubo algún error en la conexión.");
    echo json_encode($response);
}



// $query = "SELECT correo, password FROM usuario";
// $result = pg_query($conex, $query);

// if (!$result) {
//     die("Error en la consulta: " . pg_last_error());
// } else {
//     while ($row = pg_fetch_assoc($result)) {
//         echo "Correo: " . $row['correo'] . "<br>";
//         echo "Contraseña: " . $row['contraseña'] . "<br>";
//     }
// }



