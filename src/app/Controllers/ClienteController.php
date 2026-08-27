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
     * Si se recibe un ID por GET, el formulario se abre en modo edición.
     */
    public function index()
    {
        $clientes = $this->clienteModel->listarTodos();

        // Cliente en edición (opcional)
        $clienteEditar = null;
        $idEditar = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if ($idEditar) {
            $clienteEditar = $this->clienteModel->buscarPorId($idEditar);

            if (!$clienteEditar) {
                $this->guardarMensaje('error', 'El cliente que intentas editar no existe.');
                $this->redirigir();
            }
        }

        // Los mensajes se leen una sola vez y se eliminan de la sesión,
        // así no se repite la alerta al recargar la página.
        $mensaje = $this->obtenerMensaje();
        $status = $mensaje['status'] ?? null;
        $mensajeError = $mensaje['msg'] ?? null;

        require_once __DIR__ . '/../Views/clientes.index.php';
    }

    /**
     * Procesa la creación de un nuevo cliente con validaciones.
     */
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir();
        }

        $datos = $this->obtenerDatosFormulario($_POST);
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $this->guardarMensaje('error', $errores[0]);
            $this->redirigir();
        }

        //numero de telefono debe ser solo numeros sin espacios ni guiones ni nada
        $datos['telefono'] = preg_replace('/[^0-9]/', '', $datos['telefono']);

        $nuevoCliente = new Cliente(
            0,
            $datos['nombre'],
            $datos['correo'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['documento']
        );

        if ($this->clienteModel->crear($nuevoCliente)) {
            $this->guardarMensaje('created');
        } else {
            $this->guardarMensaje('error', 'Ocurrió un problema al registrar el cliente en la base de datos.');
        }

        $this->redirigir();
    }

    /**
     * Procesa la actualización de un cliente existente (método PUT).
     */
    public function actualizar($id)
    {
        if (!$this->esPut()) {
            $this->redirigir();
        }

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id || $id <= 0) {
            $this->guardarMensaje('error', 'ID de cliente no válido.');
            $this->redirigir();
        }

        if (!$this->clienteModel->buscarPorId($id)) {
            $this->guardarMensaje('error', 'El cliente que intentas actualizar no existe.');
            $this->redirigir();
        }

        $datos = $this->obtenerDatosFormulario($this->leerCuerpoPeticion());
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $this->guardarMensaje('error', $errores[0]);
            $this->redirigir("index.php?id={$id}");
        }

        $cliente = new Cliente(
            $id,
            $datos['nombre'],
            $datos['correo'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['documento']
        );

        if ($this->clienteModel->actualizar($cliente)) {
            $this->guardarMensaje('updated');
            $this->redirigir();
        }

        $this->guardarMensaje('error', 'Ocurrió un problema al actualizar el cliente en la base de datos.');
        $this->redirigir("index.php?id={$id}");
    }

    /**
     * Procesa la eliminación de un cliente por su ID.
     */
    public function eliminar($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id || $id <= 0) {
            $this->guardarMensaje('error', 'ID de cliente no válido.');
            $this->redirigir();
        }

        if ($this->clienteModel->eliminar($id)) {
            $this->guardarMensaje('deleted');
        } else {
            $this->guardarMensaje('error', 'No se pudo eliminar el cliente.');
        }

        $this->redirigir();
    }

    /**
     * Normaliza los datos recibidos del formulario.
     */
    private function obtenerDatosFormulario(array $origen): array
    {
        return [
            'nombre'    => trim($origen['nombre'] ?? ''),
            'correo'    => trim($origen['correo'] ?? ''),
            'documento' => trim($origen['documento'] ?? ''),
            'telefono'  => trim($origen['telefono'] ?? ''),
            'direccion' => trim($origen['direccion'] ?? '')
        ];
    }

    /**
     * Valida los datos de un cliente y devuelve la lista de errores.
     */
    private function validar(array $datos): array
    {
        $errores = [];

        if (empty($datos['nombre'])) {
            $errores[] = "El nombre es obligatorio.";
        } elseif (strlen($datos['nombre']) < 3) {
            $errores[] = "El nombre debe tener al menos 3 caracteres.";
        }

        if (empty($datos['correo'])) {
            $errores[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico proporcionado no es válido.";
        }

        if (empty($datos['documento'])) {
            $errores[] = "El número de documento (DUI/NIT) es obligatorio.";
        }

        if (empty($datos['telefono'])) {
            $errores[] = "El número de teléfono es obligatorio.";
        }

        return $errores;
    }

    /**
     * Determina si la petición actual es un PUT, ya sea nativo
     * o simulado desde un formulario HTML con el campo _method.
     */
    private function esPut(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            return true;
        }

        return $_SERVER['REQUEST_METHOD'] === 'POST'
            && strtoupper($_POST['_method'] ?? '') === 'PUT';
    }

    /**
     * Devuelve los datos enviados en la petición. En un PUT nativo los
     * parámetros no llegan a $_POST, hay que leerlos del cuerpo.
     */
    private function leerCuerpoPeticion(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }

        $datos = [];
        parse_str(file_get_contents('php://input'), $datos);

        return $datos;
    }

    /**
     * Guarda un mensaje de un solo uso en la sesión.
     */
    private function guardarMensaje(string $status, string $msg = null)
    {
        $_SESSION['flash'] = [
            'status' => $status,
            'msg'    => $msg
        ];
    }

    /**
     * Lee y elimina el mensaje almacenado en la sesión.
     */
    private function obtenerMensaje(): array
    {
        $mensaje = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);

        return $mensaje;
    }

    /**
     * Redirige y detiene la ejecución.
     */
    private function redirigir(string $destino = 'index.php')
    {
        header("Location: {$destino}");
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
