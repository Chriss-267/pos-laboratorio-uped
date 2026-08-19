<?php

require 'vendor/autoload.php';

use App\Controllers\ClienteController;

$clienteController = new ClienteController();

$accion = $_GET['accion'] ?? 'index';

if ($accion === 'eliminar' && isset($_GET['id'])) {
    $clienteController->eliminar($_GET['id']);
} else {
    $clienteController->index();
}