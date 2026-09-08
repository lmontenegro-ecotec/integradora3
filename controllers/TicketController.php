<?php
/**
 * CONTROLADOR: TicketController
 * Recibe las acciones del usuario, valida los datos en el servidor,
 * pide al modelo que trabaje con la base y decide qué vista mostrar.
 */

require_once __DIR__ . "/../models/Ticket.php";
require_once __DIR__ . "/../models/Catalogo.php";

class TicketController
{
    private $ticket;
    private $catalogo;

    public function __construct()
    {
        $this->ticket = new Ticket();
        $this->catalogo = new Catalogo();
    }

    /**
     * Pantalla de inicio con el resumen por estado.
     */
    public function inicio()
    {
        $resumen = $this->ticket->contarPorEstado();
        $ultimos = $this->ticket->listar();

        require __DIR__ . "/../views/inicio.php";
    }
}