<?php

namespace App\Models;

use App\Config\Database;
use App\Interfaces\ClienteInterface;
use PDO;

class Cliente extends Persona implements ClienteInterface
{
    private $documento;

    public function __construct($id = 0, $nombre = '', $correo = '', $telefono = '', $direccion = '', $documento = '')
    {
        parent::__construct($id, $nombre, $correo, $telefono, $direccion);
        $this->documento = $documento;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = trim($documento);
    }

    /**
     * Obtiene la lista completa de clientes ordenados por ID descendente.
     */
    public function listarTodos(): array
    {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare("SELECT * FROM clientes ORDER BY id DESC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Inserta un nuevo cliente en la base de datos.
     */
    public function crear(Cliente $cliente): bool
    {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare(
            "INSERT INTO clientes (nombre, correo, telefono, direccion, documento) 
             VALUES (:nombre, :correo, :telefono, :direccion, :documento)"
        );

        return $stmt->execute([
            ':nombre'    => $cliente->getNombre(),
            ':correo'    => $cliente->getCorreo(),
            ':telefono'  => $cliente->getTelefono(),
            ':direccion' => $cliente->getDireccion(),
            ':documento' => $cliente->getDocumento()
        ]);
    }

    /**
     * Elimina un cliente según su ID.
     */
    public function eliminar(int $id): bool
    {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare("DELETE FROM clientes WHERE id = :id");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}