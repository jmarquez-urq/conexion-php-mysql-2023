<?php

require_once 'clases/RepositorioUsuario.php';

class ControladorSesion
{
    /**
     * Verifica el login de usuario.
     *
     * @param string $nombre_usuario El nombre de usuario
     * @param string $clave          La contraseña del usuario
     *
     * @return Array El primer valor del array es true o false, según si el
     *               login fue exitoso o no. El segundo elemento del array es
     *               un mensaje que explica el motivo del éxito o fracaso.
     */
    public function login($nombre_usuario, $clave)
    {
        $repo = new RepositorioUsuario();
        $usuario = $repo->login($nombre_usuario, $clave);

        if ($usuario === false) {
            // Falló el login
            return [ false, "Error de credenciales" ];
        } else {
            // Login correcto, $usuario tiene un objeto de tipo Usuario, cuyos
            // datos obtuvo de la BD.

            // Iniciamos la sesión, y guardamos el objeto Usuario como variable
            // de sesión, para que esté disponible al cambiar de página:
            session_start();
            $_SESSION['usuario'] = serialize($usuario);

            return [true, "Usuario correctamente autenticado"];
        }


    }

}
