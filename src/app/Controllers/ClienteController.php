<?php

namespace App\Controllers;

use App\Models\Cliente;

class ClienteController {
    
    public function index()
    {
        $cliente = new Cliente(); //instancia del modelo cliente
        $cliente = $cliente->listarCliente();
        require_once __DIR__ . '/../Views/clientes.index.php';
    }
}