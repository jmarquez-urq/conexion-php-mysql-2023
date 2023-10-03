<?php

require_once 'Aeropuerto.php';

class Vuelo
{
    public $id;
    public $origen;
    public $destino;
    public $duracion;
    public $id_usuario;

    /**
     * Método constructor
     *
     * @param int    $id          El id de vuelo que está almacenado en la BD
     * @param int    $duracion    Duración del vulo, en minutos.
     * @param int    $id_usuario  El id del usuario que cargó el vuelo en la BD
     * @param Aeropuerto $origen  El objeto Aeropuerto que corresponde al
     *                            aeropuerto desde donde despega el vuelo.
     * @param Aeropuerto $destino El objeto Aeropuerto que corresponde al
     *                            aeropuerto en donde aterriza el vuelo.
     */
    public function __construct($id, $duracion, $id_usuario, Aeropuerto $origen, Aeropuerto $destino)
    {
        $this->id = $id;
        $this->duracion = $duracion;
        $this->id_usuario = $id_usuario;
        $this->origen = $origen;
        $this->destino = $destino;
    }

    /**
     * Indica si el vuelo corresponde al usuario logueado.
     *
     * @param int $id_usuario_logueado El id del usuario logueado.
     *
     * @return boolean Si el usuario logueado es quien cargó el vuelo, retorna
     *                 true; de lo contrario, retorna false.
     */
    public function es_propio($id_usuario_logueado)
    {
        return $this->id_usuario == $id_usuario_logueado;
    }

    public function __toString()
    {
        $texto = "Vuelo $this->id - Desde $this->origen hasta $this->destino. ";
        $texto.= "Duración: $this->duracion minutos. ";
        return $texto;
    }

}
