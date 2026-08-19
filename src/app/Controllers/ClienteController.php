<?php

namespace App\Controllers;

use App\Models\Cliente;

class ClienteController {
    
    public function index()
    {
        $clienteModel = new Cliente(); //instancia del modelo cliente
        
        //verificamos si los parametros vienen presentes en la url via get
        if(isset($_GET['nombre']) && isset($_GET['correo']) && isset($_GET['contraseña'])){
            $nombre = $_GET['nombre'];
            $correo = $_GET['correo'];
            $contraseña = $_GET['contraseña'];
            
            //si los campos no estan vacios , ejecutamos la insercion
            if(!empty($nombre) && !empty($correo) && !empty($contraseña)){
                $clienteModel->crearCliente($nombre, $correo, $contraseña);
                 
                //limpiamos la url para no repetir la insercion al recargar
                header("Location: index.php");
                exit;
            }
        }
        //consulta de todos los clientes en la bd
        $clientes = $clienteModel->listarCliente();

        //pasamos los datos a la vista
        require_once __DIR__ . '/../Views/clientes.index.php';
    }

    public function eliminar($id)
    {
        $cliente = new Cliente();

        $cliente->eliminarCliente($id);

        header("Location: index.php");
        exit;
    }
}