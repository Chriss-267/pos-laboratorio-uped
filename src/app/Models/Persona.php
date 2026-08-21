<?php

namespace App\Models;

abstract class Persona
{
    protected $id;
    protected $nombre;
    protected $correo;
    protected $telefono;
    protected $direccion;

    public function __construct($id = 0, $nombre = '', $correo = '', $telefono = '', $direccion = '')
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = trim($nombre);
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = trim($correo);
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = trim($telefono);
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = trim($direccion);
    }
}
