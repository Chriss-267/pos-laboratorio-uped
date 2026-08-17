<?php
require 'vendor/autoload.php';

use App\Controllers\PersonaController;

$personaController = new PersonaController();
$personaController->index();
