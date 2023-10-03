<?php

class Aeropuerto
{
    public $nombre;
    public $codigo;
    public $pais;

    public function __construct($nombre, $codigo, $pais)
    {
        $this->nombre = $nombre;
        $this->codigo = $codigo;
        $this->pais = $pais;
    }

    public function __toString()
    {
        return $this->nombre . " (" . $this->codigo . ") - " . $this->pais;
    }
}
