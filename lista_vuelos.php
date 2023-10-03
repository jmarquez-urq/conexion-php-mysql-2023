<?php

require_once 'clases/Usuario.php';
require_once 'clases/ControladorVuelos.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = unserialize($_SESSION['usuario']);
} else {
    // Si el usuario no está logueado, lo redirigimos a la pantalla de login:
    header('Location: index.php');
}

$cv = new ControladorVuelos($usuario->getId());

$filtro = null;
$titulo = "Todos los vuelos";

if (!empty($_POST['filtro'])) {
    // Si se recibió un filtro por post:
    $filtro = $_POST['filtro'];
    $titulo = "Vuelos que aterrizan en $filtro";
}

// Invocamos el método listar del controlador. Si el filtro es null, recibiremos
// un array con todos los vuelos que haya en la BD.
$vuelos = $cv->listar($filtro);

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Vuelos</title>
    </head>
    <body>
        <h1><?php echo $titulo; ?></h1>
        <form action="lista_vuelos.php" method="post">
            <label for="filtro">Filtrar por destino:</label>
            <input name="filtro">
            <input type="submit" value="Filtrar">
        </form>

        <ul>
            <?php
                foreach ($vuelos as $v) {
                    // Recorremos la lista de vuelos y los mostramos como items
                    // de una lista:
                    echo "<li>" . $v . ' - ' . $cv->mostrar_enlaces($v) . "</li>";
                }
            ?>
        </ul>
    </body>
</html>
