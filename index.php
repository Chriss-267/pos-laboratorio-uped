<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\ClienteController;

$clienteController = new ClienteController();

// Capturamos la acción desde la URL (por defecto 'index')
$accion = $_GET['accion'] ?? 'index';

// Enrutador de acciones
switch ($accion) {
    case 'crear':
        $clienteController->crear();
        break;

    case 'eliminar':
        $id = $_GET['id'] ?? null;
        $clienteController->eliminar($id);
        break;

    case 'index':
    default:
        $clienteController->index();
        break;
}