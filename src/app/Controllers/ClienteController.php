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

    /**
     * Actualiza PARCIALMENTE un cliente mediante una petición PATCH real.
     *
     * A diferencia de POST, en PATCH PHP no llena $_POST automáticamente, así
     * que leemos el cuerpo crudo con php://input. Solo se actualizan los campos
     * que el cliente realmente envió (los que cambiaron); el resto de la fila
     * permanece intacto. Responde en JSON para que el frontend (fetch) lo maneje.
     */
    public function editar($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        // 1) La petición DEBE ser un PATCH real.
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método no permitido. Se requiere PATCH.']);
            return;
        }

        // 2) Validamos el ID recibido por la URL.
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id || $id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de cliente no válido.']);
            return;
        }

        // 3) Leemos el cuerpo de la petición PATCH (PHP no llena $_POST aquí).
        parse_str(file_get_contents('php://input'), $entrada);

        // 4) De todo lo recibido, tomamos SOLO los campos permitidos que vinieron.
        $permitidos = ['nombre', 'correo', 'telefono', 'direccion', 'documento'];
        $cambios = [];
        foreach ($permitidos as $campo) {
            if (array_key_exists($campo, $entrada)) {
                $cambios[$campo] = trim($entrada[$campo]);
            }
        }

        // Si no llegó ningún campo, no hay nada que actualizar.
        if (empty($cambios)) {
            echo json_encode(['success' => false, 'message' => 'No se recibió ningún cambio.']);
            return;
        }

        // 5) Validamos ÚNICAMENTE los campos enviados (actualización parcial).
        $errores = [];

        if (isset($cambios['nombre'])) {
            if ($cambios['nombre'] === '') {
                $errores[] = "El nombre no puede quedar vacío.";
            } elseif (strlen($cambios['nombre']) < 3) {
                $errores[] = "El nombre debe tener al menos 3 caracteres.";
            }
        }
        if (isset($cambios['correo'])) {
            if ($cambios['correo'] === '') {
                $errores[] = "El correo no puede quedar vacío.";
            } elseif (!filter_var($cambios['correo'], FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El correo electrónico proporcionado no es válido.";
            }
        }
        if (isset($cambios['documento']) && $cambios['documento'] === '') {
            $errores[] = "El número de documento (DUI/NIT) no puede quedar vacío.";
        }
        if (isset($cambios['telefono']) && $cambios['telefono'] === '') {
            $errores[] = "El número de teléfono no puede quedar vacío.";
        }

        if (!empty($errores)) {
            echo json_encode(['success' => false, 'message' => $errores[0]]);
            return;
        }

        // 6) Actualización parcial en la base de datos.
        $resultado = $this->clienteModel->editar($id, $cambios);

        if ($resultado) {
            echo json_encode([
                'success' => true,
                'message' => 'Se actualizó ' . count($cambios) . ' campo(s) correctamente.'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el cliente.']);
        }
    }
}