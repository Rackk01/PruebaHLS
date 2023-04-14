<?php

$usuario = $_POST["usuario"];
$pass = $_POST["pass"];

if($usuario === "" || $pass === ""){
    echo json_encode ("Porfvor completa los campos")
}else {
    echo json_encode ("¡Inicio Exitoso!usuario: <br>".$usuario."<br>contraseña: ".$pass);
}