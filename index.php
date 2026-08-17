<?php
require 'vendor/autoload.php';

use App\Controllers\ClienteController;

$clienteController = new ClienteController();
$clienteController->index();
