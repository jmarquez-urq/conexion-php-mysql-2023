<?php

class Usuario
{
    protected $id;
    protected $nombre_usuario;
    protected $nombre;
    protected $apellido;

    public function __construct($id, $nombre_usuario, $nombre, $apellido)
    {
        $this->id = $id;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function getNombreApellido()
    {
        return "$this->nombre $this->apellido";
    }
}

