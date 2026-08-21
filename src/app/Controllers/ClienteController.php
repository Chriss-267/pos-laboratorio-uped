<?php

namespace App\Controllers;

use App\Models\Cliente;

class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
    }

    /**
     * Muestra la vista principal con el listado de clientes.
     */
    public function index()
    {
        $clientes = $this->clienteModel->listarTodos();

        $status = $_GET['status'] ?? null;
        $mensajeError = $_GET['msg'] ?? null;

        require_once __DIR__ . '/../Views/clientes.index.php';
    }

    /**
     * Procesa la creación de un nuevo cliente con validaciones.
     */
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php");
            exit;
        }

        $nombre    = trim($_POST['nombre'] ?? '');
        $correo    = trim($_POST['correo'] ?? '');
        $documento = trim($_POST['documento'] ?? '');
        $telefono  = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');

        // --- VALIDACIONES ---
        $errores = [];

        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (strlen($nombre) < 3) {
            $errores[] = "El nombre debe tener al menos 3 caracteres.";
        }

        if (empty($correo)) {
            $errores[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico proporcionado no es válido.";
        }

        if (empty($documento)) {
            $errores[] = "El número de documento (DUI/NIT) es obligatorio.";
        }

        if (empty($telefono)) {
            $errores[] = "El número de teléfono es obligatorio.";
        }

        // Si existen errores, redirigir con el primer mensaje de error
        if (!empty($errores)) {
            $errorMsg = urlencode($errores[0]);
            header("Location: index.php?status=error&msg={$errorMsg}");
            exit;
        }

        // Crear objeto Cliente
        $nuevoCliente = new Cliente(0, $nombre, $correo, $telefono, $direccion, $documento);

        $resultado = $this->clienteModel->crear($nuevoCliente);

        if ($resultado) {
            header("Location: index.php?status=created");
        } else {
            $errorMsg = urlencode("Ocurrió un problema al registrar el cliente en la base de datos.");
            header("Location: index.php?status=error&msg={$errorMsg}");
        }
        exit;
    }

    /**
     * Procesa la eliminación de un cliente por su ID.
     */
    public function eliminar($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id || $id <= 0) {
            $errorMsg = urlencode("ID de cliente no válido.");
            header("Location: index.php?status=error&msg={$errorMsg}");
            exit;
        }

        $resultado = $this->clienteModel->eliminar($id);

        if ($resultado) {
            header("Location: index.php?status=deleted");
        } else {
            $errorMsg = urlencode("No se pudo eliminar el cliente.");
            header("Location: index.php?status=error&msg={$errorMsg}");
        }
        exit;
    }
}