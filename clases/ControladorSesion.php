<?php

require_once 'clases/RepositorioUsuario.php';
require_once 'clases/Usuario.php';

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

    /**
     * Crea un nuevo usuario y le solicita al repositorio que lo guarde en la
     * BD. Si el RepositorioUsuario responde exitosamente, loguea al usuario
     * en la sesión.
     *
     * @param string $nombre_usuario El nombre de usuario
     * @param string $nombre         El nombre real de la persona usuaria
     * @param string $apellido       El apellido del usuario/a
     * @param string $clave          La contraseña del usuario
     *
     * @return Array Un array cuyo primer valor es true o false, según si fue
     *               exitosa o no la creación del usuario. El segundo valor del
     *               array retornado es un mensaje explicativo.
     */
    function create($nombre_usuario, $nombre, $apellido, $clave)
    {
        $repo = new RepositorioUsuario();
        $usuario = new Usuario($nombre_usuario, $nombre, $apellido);
        $id = $repo->save($usuario, $clave);
        if ($id === false) {
            // No se pudo guardar
            return [ false, "Error al crear el usuario" ];
        } else {
            $usuario->setId($id);
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return [ true, "Usuario creado correctamente" ];
        }
    }

    /**
     * Elimina el usuario. Retorna true si tuvo éxito, false si no.
     *
     * @params Usuario $usuario El objeto usuario a eliminar.
     *
     * @return boolean true si tuvo éxito, false de lo contrario
     */
    function eliminar(Usuario $usuario)
    {
        $repo = new RepositorioUsuario();
        return $repo->eliminar($usuario);

        // O bien:
        // if ($repo->eliminar($usuario)) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
}

