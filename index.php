<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\ClienteController;

// La sesión se usa para los mensajes de un solo uso (flash)
session_start();

$clienteController = new ClienteController();

// Capturamos la acción desde la URL (por defecto 'index')
$accion = $_GET['accion'] ?? 'index';

// Enrutador de acciones
switch ($accion) {
    case 'crear':
        $clienteController->crear();
        break;

    case 'actualizar':
        $id = $_GET['id'] ?? null;
        $clienteController->actualizar($id);
        break;

    case 'eliminar':
        $id = $_GET['id'] ?? null;
        $clienteController->eliminar($id);
        break;

    case 'editar':
        $id = $_GET['id'] ?? null;
        $clienteController->editar($id);
        break;

    case 'index':
    default:
        $clienteController->index();
        break;
}
