<?php
/**
 * MODELO: Seguimiento
 * Guarda y consulta la bitácora de cada ticket.
 */

require_once __DIR__ . "/../config/conexion.php";

class Seguimiento
{
    /**
     * Agrega un comentario a la bitácora del ticket.
     */
    public function insertar($idTicket, $comentario, $estado)
    {
        $conexion = Conexion::obtener();

        $sql = "INSERT INTO seguimientos (id_ticket, comentario, estado)
                VALUES (:ticket, :comentario, :estado)";

        $sentencia = $conexion->prepare($sql);

        return $sentencia->execute([
            ":ticket"     => $idTicket,
            ":comentario" => $comentario,
            ":estado"     => $estado
        ]);
    }
}