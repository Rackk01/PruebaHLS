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

    case "updateUser":
        // Código a ejecutar si $funcion es igual a "update"
        $usuario = $_POST["email"];
        $pass = $_POST["pass"];
        $newPassword = $_POST["newPass"];
        $repnewPass = $_POST["repNewPass"];
    
        //VALIDACION DE DATOS DE LA BASE DE DATOS
    
        // ...
    
        // REVISAR SI EL CORREO Y LA CONTRASEÑA ESTAN REGISTRADOS EN LA DB.
    
        $query = "SELECT * FROM usuario WHERE correo = '$usuario' AND password = '$pass'";
        $resultado = pg_query($conex, $query);
        $usuario = pg_fetch_assoc($resultado);
    
        // Validar si el ID no está vacío
        if (empty($usuario["id"])) {
            // ID vacío, mostrar mensaje de error
            $resultado = array("success" => false, "badmessage" => "Inicio de sesión fallido. Por favor, verifique su usuario y contraseña.");
            echo json_encode($resultado);
            return;
        }
    
        if (!$resultado) {
            echo ("Error en la consulta: " . pg_last_error());
            return;
        } else {
            $num_rows = pg_num_rows($resultado);
            if ($num_rows > 0) {
                // El correo y contraseña coinciden en la base de datos, realizar la actualización
                $idUsuario = $usuario["id"]; // obtener el valor del ID del usuario;
                $sql = "UPDATE usuario SET password = '$newPassword' WHERE id = '$idUsuario'";
                $resultadoUpdate = pg_query($conex, $sql);
    
                if ($resultadoUpdate) {
                    // Mensaje de actualización fue exitosa.
                    $resultado = array("success" => true, "goodmessage" => "Actualización exitosa.");
                    echo json_encode($resultado);
                } else {
                    // Mensaje de error en la conexión.
                    $resultado = array("success" => false, "messageErrConex" => "Hubo algún error en la actualización.");
                    echo json_encode($resultado);
                    return;
                }
            } else {
                // El correo y contraseña no coinciden en la base de datos
                $resultado = array("success" => false, "message" => "Inicio de sesión fallido. Por favor, verifique su usuario y contraseña.");
                echo json_encode($resultado);
                return;
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





// else {
//     // Insertar el nuevo usuario en la base de datos
//     $sql = "INSERT INTO usuario (password) VALUES ('$pass') returning *";
//     $resultado = pg_query($conex, $sql);

//     if ($resultado) {
//         // Inicio de sesión exitoso
//         $resultado = array("success" => true, "goodmessage" => "Inicio de sesión exitoso. Bienvenido, $usuario.");
//         echo json_encode($resultado);
//     } else {
//         // Error en la conexión
//         $resultado = array("success" => false, "messageErrConex" => "Hubo algún error en la conexión.");
//         echo json_encode($resultado);
//     }
// }