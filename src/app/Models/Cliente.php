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
     * Busca un cliente por su ID.
     */
    public function buscarPorId(int $id)
    {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare("SELECT * FROM clientes WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);

        $cliente = $stmt->fetch(PDO::FETCH_OBJ);

        return $cliente ?: null;
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
     * Actualiza los datos de un cliente existente.
     */
    public function actualizar(Cliente $cliente): bool
    {
        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare(
            "UPDATE clientes 
                SET nombre = :nombre, 
                    correo = :correo, 
                    telefono = :telefono, 
                    direccion = :direccion, 
                    documento = :documento 
              WHERE id = :id"
        );

        return $stmt->execute([
            ':nombre'    => $cliente->getNombre(),
            ':correo'    => $cliente->getCorreo(),
            ':telefono'  => $cliente->getTelefono(),
            ':direccion' => $cliente->getDireccion(),
            ':documento' => $cliente->getDocumento(),
            ':id'        => $cliente->getId()
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

    /**
     * Actualiza PARCIALMENTE un cliente (semántica PATCH).
     *
     * Solo modifica las columnas presentes en $campos; el resto de la fila
     * permanece intacta. El SET se construye dinámicamente a partir de las
     * claves recibidas.
     *
     * @param int   $id     ID del cliente a actualizar.
     * @param array $campos Arreglo asociativo columna => valor, solo con lo que cambió.
     */
    public function editar(int $id, array $campos): bool
    {
        if (empty($campos)) {
            return false;
        }

        // Construimos el "SET" dinámicamente solo con los campos recibidos.
        // Nota: las claves de $campos provienen de una lista blanca en el
        // controlador, por eso es seguro usarlas como nombres de columna.
        $asignaciones = [];
        $parametros   = [];

        foreach ($campos as $columna => $valor) {
            $asignaciones[] = "{$columna} = :{$columna}";
            $parametros[":{$columna}"] = $valor;
        }
        $parametros[':id'] = $id;

        $sql = "UPDATE clientes SET " . implode(', ', $asignaciones) . " WHERE id = :id";

        $conexion = new Database();
        $stmt = $conexion->getConnection()->prepare($sql);

        return $stmt->execute($parametros);
    }
}