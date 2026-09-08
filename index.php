<?php
/**
 * PUNTO DE ENTRADA DE LA APLICACIÓN
 * Todas las peticiones pasan por aquí. Este archivo solo decide
 * qué controlador y qué acción se deben ejecutar.
 *
 * Actividad Integradora 3 - Mesa de Ayuda
 * Lenin Montenegro
 */

require_once __DIR__ . "/config/funciones.php";
require_once __DIR__ . "/controllers/TicketController.php";

/* isset() comprueba si el parámetro llegó en la dirección web */
$controlador = isset($_GET["controlador"]) ? $_GET["controlador"] : "ticket";
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "inicio";

// Acciones permitidas del controlador de tickets
$accionesValidas = [
    "inicio",
    "crear",
    "guardar",
    "listar",
    "detalle",
    "editar",
    "actualizar",
    "eliminar"
];

if ($controlador === "ticket" && in_array($accion, $accionesValidas)) {
    $objeto = new TicketController();
    $objeto->$accion();
} else {
    $objeto = new TicketController();
    $objeto->inicio();
}
