<?php

// clase padre persona entidad
namespace App\Models;

use App\Config\Database;
use PDO;

class Persona {
    
    //atributos de persona
    private $id;
    private $nombre;
    private $correo;
    private $contraseña;

    //contructor de la clase persona
    public function __construct($id = 0, $nombre = '', $correo = '', $contraseña = '') {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }
    
    //getters y setters de persona
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getContraseña() {
        return $this->contraseña;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    // metodo para crear una persona conectado a la base con prepare y luego ejecutar la consulta
    public function crearPersona(string $nombre, string $correo, string $contraseña) {
       $conexion = new Database();
       $conexion->getConnection()->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (:nombre, :correo, :contraseña)")->execute([
           ':nombre' => $nombre,
           ':correo' => $correo,
           ':contraseña' => $contraseña
       ]);
    }

    //metodo para obtener todas las personas con prepare y luego ejecutar la consulta
    public function carlitos() {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare("SELECT * FROM usuarios");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }


}