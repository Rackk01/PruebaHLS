<?php
session_start();
//Conexion a la base de datos.

$funcion = $_POST["funcion"];

if (!isset($funcion)) {
    echo ('Error: La función no está especificada');
    die;
    return;
}
//CONEXION A LA BASE DE DATOS.
$host = "localhost";
$port = "5435";
$dbname = "db_prueba";
$user = "postgres";
$password = "113355";

// Validar si la función no está vacía
if (isset($funcion) && !empty($funcion)) {

    $conex = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conex) {
        die('Error de conexión: ' . pg_last_error());
    } else {
        // echo 'Conexión Establecida';
    }
} else {
    // Manejar caso cuando la función está vacía
    die('Error: La función no está especificada');
}


// Switch con el inicio de sesion y sus respectivos mensajes.

switch ($funcion) {

    case "loginUser":
        // Código a ejecutar si $variable es igual a valor1
        $usuario = $_POST["email"];
        $pass = $_POST["pass"];


        //VALIDACION DE DATOS DE LA BASE DE DATOS

        if (trim($usuario) === "" && trim($pass) === "") {
            // Inicio de sesión fallido
            echo $respuesta = array("success" => false, "badmessage" => "Inicio de sesión fallido. Por favor, verifique su usuario y contraseña.");
            echo json_encode($respuesta);
            die;
            return;
        }

        // REVISAR SI EL CORREO ESTA REGISTRADO EN LA DB.


        $query = "SELECT * FROM usuario WHERE correo = '$usuario' AND password = '$pass'";
        $resultado = pg_query($conex, $query);
        $num_rows = pg_num_rows($resultado);
    
        if ($num_rows > 0) {
            // El correo ya existe en la base de datos
            $resultado = array("success" => false, "message" => "Ese usuario ya está registrado.");
            echo json_encode($resultado);
            return;
        } else {

            //  Si no existe en la DB, insertar el nuevo usuario en la base de datos.
            $sql = "INSERT INTO usuario (correo, password) VALUES ('$usuario', '$pass') returning correo";
            $resultado = pg_query($conex, $sql);

            if ($resultado) {
                // Inicio de sesión exitoso
                $resultado = array("success" => true, "goodmessage" => "Inicio de sesión exitoso. Bienvenido, $usuario.");
                echo json_encode($resultado);
            } else {
                // Error en la conexión
                $resultado = array("success" => false, "messageErrConex" => "Hubo algún error en la conexión.");
                echo json_encode($resultado);
            }
        }
        break;

    case "":
        // Código a ejecutar si $variable es igual a valor3
        break;
        // ... más casos
    default:
        // Código a ejecutar si ninguno de los casos anteriores se cumple
        break;
}
