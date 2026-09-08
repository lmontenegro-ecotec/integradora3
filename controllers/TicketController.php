<?php
/**
 * CONTROLADOR: TicketController
 * Recibe las acciones del usuario, valida los datos en el servidor,
 * pide al modelo que trabaje con la base y decide qué vista mostrar.
 */

require_once __DIR__ . "/../models/Ticket.php";
require_once __DIR__ . "/../models/Catalogo.php";
require_once __DIR__ . "/../models/Seguimiento.php";

class TicketController
{
    private $ticket;
    private $catalogo;
    private $seguimiento;

    public function __construct()
    {
        $this->ticket = new Ticket();
        $this->catalogo = new Catalogo();
        $this->seguimiento = new Seguimiento();
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

        /**
     * Muestra el formulario de registro.
     */
    public function crear()
    {
        $categorias = $this->catalogo->categorias();
        $prioridades = $this->catalogo->prioridades();
        $tecnicos = $this->catalogo->tecnicos();
        $valores = [];
        $errores = [];        

        require __DIR__ . "/../views/tickets/crear.php";
    }
    /**
     * Recibe los datos del formulario, los valida y los envía al modelo.
     */
    public function guardar()
    {
        $valores = [
            "titulo"      => trim((isset($_POST["titulo"]) ? $_POST["titulo"] : "")),
            "descripcion" => trim((isset($_POST["descripcion"]) ? $_POST["descripcion"] : "")),
            "solicitante" => trim((isset($_POST["solicitante"]) ? $_POST["solicitante"] : "")),
            "correo"      => trim((isset($_POST["correo"]) ? $_POST["correo"] : "")),
            "categoria"   => isset($_POST["categoria"]) ? $_POST["categoria"] : "",
            "prioridad"   => isset($_POST["prioridad"]) ? $_POST["prioridad"] : "",
            "tecnico"     => isset($_POST["tecnico"]) ? $_POST["tecnico"] : "",
            "horas"       => isset($_POST["horas"]) ? $_POST["horas"] : ""
        ];

        $errores = $this->validar($valores);

        if (count($errores) > 0) {
            $categorias = $this->catalogo->categorias();
            $prioridades = $this->catalogo->prioridades();
            $tecnicos = $this->catalogo->tecnicos();

            require __DIR__ . "/../views/tickets/crear.php";
            return;
        }

        $idTicket = $this->ticket->insertar($valores);
        $this->seguimiento->insertar($idTicket, "Ticket registrado en el sistema.", "Abierto");

        header("Location: index.php?controlador=ticket&accion=listar&mensaje=creado");        
        exit;
    }

    /**
     * Validación del lado del servidor.
     * El servidor nunca confía en lo que envía el navegador.
     */
    private function validar($valores)
    {
        $errores = [];

        if ($valores["titulo"] === "") {
            $errores[] = "El título del ticket es obligatorio.";
        } elseif (strlen($valores["titulo"]) < 5 || strlen($valores["titulo"]) > 100) {
            $errores[] = "El título debe tener entre 5 y 100 caracteres.";
        }

        if ($valores["descripcion"] === "") {
            $errores[] = "La descripción es obligatoria.";
        } elseif (strlen($valores["descripcion"]) < 10) {
            $errores[] = "La descripción debe tener al menos 10 caracteres.";
        }

        if ($valores["solicitante"] === "") {
            $errores[] = "El nombre del solicitante es obligatorio.";
        }

        if ($valores["correo"] === "") {
            $errores[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($valores["correo"], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no tiene un formato válido.";
        }

        if ($valores["categoria"] === "") {
            $errores[] = "Debe seleccionar una categoría.";
        }

        if ($valores["prioridad"] === "") {
            $errores[] = "Debe seleccionar una prioridad.";
        }

        if ($valores["horas"] === "") {
            $errores[] = "Las horas estimadas son obligatorias.";
        } elseif (!is_numeric($valores["horas"])) {
            $errores[] = "Las horas estimadas deben ser un valor numérico.";
        } elseif ($valores["horas"] <= 0 || $valores["horas"] > 100) {
            $errores[] = "Las horas estimadas deben estar entre 0.5 y 100.";
        }

        return $errores;
    }

    /**
     * Muestra la tabla de tickets con búsqueda y filtro por estado.
     */
    public function listar()
    {
        $busqueda = trim((isset($_GET["busqueda"]) ? $_GET["busqueda"] : ""));
        $estado = isset($_GET["estado"]) ? $_GET["estado"] : "";
        $tickets = $this->ticket->listar($busqueda, $estado);
        $mensaje = isset($_GET["mensaje"]) ? $_GET["mensaje"] : "";

        require __DIR__ . "/../views/tickets/listar.php";
    }

    /**
     * Muestra el detalle de un ticket junto con su bitácora.
     */
    public function detalle()
    {
        $registro = $this->ticket->obtenerPorId(isset($_GET["id"]) ? $_GET["id"] : 0);

        if (!$registro) {
            header("Location: index.php?controlador=ticket&accion=listar");
            exit;
        }

        $bitacora = $this->seguimiento->listarPorTicket($registro["id_ticket"]);

        require __DIR__ . "/../views/tickets/detalle.php";
    }                 
}