<?php

namespace App\Controllers;

use App\Models\Persona;

class PersonaController {
    
    public function index()
    {
        $persona = new Persona(); //instancia del modelo persona
        $personas = $persona->carlitos();
        require_once __DIR__ . '/../Views/persona.index.php';
    }
}