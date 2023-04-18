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
    echo $respuesta = array("success" => false, "message" => "Inicio de sesión fallido. Por favor, verifique su usuario y contraseña.");
    die;
    return;
}

// Revisar si el correo existe en la base de datos
$query = "SELECT correo FROM usuario WHERE correo = '$usuario'";
$resultado = pg_query($conex, $query);

if (!$resultado) {
    echo("Error en la consulta: " . pg_last_error());
    return;

} else {
    $num_rows = pg_num_rows($resultado);
    if ($num_rows > 0) {
        // El correo ya existe en la base de datos
        $resultado = array("success" => false, "message" => "El correo ya está registrado.");
        echo json_encode($resultado);
        return;
    } else {

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuario (correo, password) VALUES ('$usuario', '$pass') returning correo";
        $resultado = pg_query($conex, $sql);

        if ($resultado) {
            // Inicio de sesión exitoso
            $resultado = array("success" => true, "goodmessage" => "Inicio de sesión exitoso. Bienvenido, $usuario.");
            echo json_encode($resultado);
        } else {

            // Error en la conexión
            $resultado = array("success" => false, "message" => "Hubo algún error en la conexión.");
            echo json_encode($resultado);
        }
    }
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



