<?php

namespace App\Interfaces;

use App\Models\Cliente;

interface ClienteInterface
{
    /**
     * Obtiene la lista completa de clientes.
     * @return array
     */
    public function listarTodos(): array;

    /**
     * Crea un nuevo cliente en el sistema.
     * @param Cliente $cliente
     * @return bool
     */
    public function crear(Cliente $cliente): bool;

    /**
     * Elimina un cliente por su ID.
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id): bool;
}
