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

    /**
     * Devuelve la bitácora completa de un ticket, del más reciente al más antiguo.
     */
    public function listarPorTicket($idTicket)
    {
        $conexion = Conexion::obtener();

        $sql = "SELECT comentario, estado, fecha
                FROM   seguimientos
                WHERE  id_ticket = :ticket
                ORDER BY fecha DESC, id_seguimiento DESC";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([":ticket" => $idTicket]);

        return $sentencia->fetchAll();
    }    
}