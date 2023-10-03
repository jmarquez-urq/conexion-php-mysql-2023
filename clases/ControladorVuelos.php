<?php
require_once 'RepositorioVuelos.php';
require_once 'Vuelo.php';

class ControladorVuelos
{
    public $id_usuario;

    /**
     * Método constructor: Recibe el id del usuario logueado e instancia un
     * repositorio.
     *
     * @param id $id_usuario El id del usuario logueado
     */
    public function __construct($id_usuario)
    {
        $this->id_usuario = $id_usuario;
        $this->rv = new RepositorioVuelos();
    }

    /**
     * Retorna la lista de vuelos que satisfacen el filtro recibido. Si el
     * filtro es null, retornará todos los vuelos.
     *
     * @param string $filtro El código del aeropuerto de destino.
     *
     * @return Array Un array en el que cada uno de sus elementos es un objeto
     *               de la clase Vuelo. Contendrá todos los vuelos en los que el
     *               código del aeropuerto de destino sea $filtro. Si $filtro
     *               es null, el array contendrá todos los vuelos.
     */
    public function listar($filtro = null)
    {
        return $this->rv->get_all($filtro);
    }

    /**
     * Si el vuelo es propio, retorna código HTML para mostrar los enlaces que
     * permitirán modificar los datos de un vuelo, y eliminar el vuelo. Si el
     * vuelo *no* es propio, retorna la cadena vacía.
     *
     * @param Vuelo $vuelo El objeto vuelo cuyos enlaces queremos obtener.
     *
     * @return string El código HTML para ver los enlaces modificar y eliminar,
     *                en el caso de que el vuelo sea propio. Si el vuelo no es
     *                propio, retornará un string vacío.
     */
    public function mostrar_enlaces(Vuelo $vuelo)
    {
        if ($vuelo->es_propio($this->id_usuario)) {
            $modificar = "<a href='modificar_vuelo.php?id=$vuelo->id'>Modificar datos</a>";
            $eliminar = "<a href='eliminar_vuelo.php?id=$vuelo->id'>Eliminar vuelo</a>";
            return "$modificar - $eliminar";
        } else {
            return '';
        }
    }
}
