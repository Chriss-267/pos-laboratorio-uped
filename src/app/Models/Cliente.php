<?php


namespace App\Models;

use App\Config\Database;
use PDO;

class Cliente {
    
    //atributos de cliente
    private $id;
    private $nombre;
    private $correo;
    private $contraseña;

    //contructor de la clase cliente
    public function __construct($id = 0, $nombre = '', $correo = '', $contraseña = '') {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }
    
    //getters y setters de cliente
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

    // metodo para crear un cliente conectado a la base con prepare y luego ejecutar la consulta
    public function crearCliente(string $nombre, string $correo, string $contraseña) {
       $conexion = new Database();
       $conexion->getConnection()->prepare("INSERT INTO clientes (nombre, correo, contraseña) VALUES (:nombre, :correo, :contrasena)")->execute([
           ':nombre' => $nombre,
           ':correo' => $correo,
           ':contrasena' => $contraseña
       ]);
    }

    //metodo para obtener todos los clientes con prepare y luego ejecutar la consulta
    public function listarCliente() {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare("SELECT * FROM clientes");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }


}