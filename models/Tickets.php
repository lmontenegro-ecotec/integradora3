<?php
/**
 * MODELO: Ticket
 * Única responsabilidad: comunicarse con la base de datos.
 * No imprime HTML ni recibe datos del navegador.
 */

require_once __DIR__ . "/../config/conexion.php";

class Ticket
{

    /**
     * Devuelve los tickets con el nombre de sus catálogos.
     * Si se envía un texto de búsqueda filtra por código, título o solicitante.
     */
    public function listar($busqueda = "", $estado = "")
    {
        $conexion = Conexion::obtener();

        $sql = "SELECT  t.id_ticket, t.codigo, t.titulo, t.solicitante,
                        t.horas_estimadas, t.estado, t.fecha_creacion,
                        c.nombre AS categoria,
                        p.nombre AS prioridad, p.color,
                        IFNULL(e.nombre, 'Sin asignar') AS tecnico
                FROM    tickets t
                        INNER JOIN categorias  c ON t.id_categoria = c.id_categoria
                        INNER JOIN prioridades p ON t.id_prioridad = p.id_prioridad
                        LEFT  JOIN tecnicos    e ON t.id_tecnico   = e.id_tecnico
                WHERE   1 = 1";

        $parametros = [];

        if ($busqueda !== "") {
            $sql .= " AND (t.codigo LIKE :busqueda
                        OR t.titulo LIKE :busqueda
                        OR t.solicitante LIKE :busqueda)";
            $parametros[":busqueda"] = "%" . $busqueda . "%";
        }

        if ($estado !== "") {
            $sql .= " AND t.estado = :estado";
            $parametros[":estado"] = $estado;
        }

        $sql .= " ORDER BY t.fecha_creacion DESC";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute($parametros);

        return $sentencia->fetchAll();
    }

    /**
     * Cuenta cuántos tickets hay en cada estado (para el tablero).
     */
    public function contarPorEstado()
    {
        $conexion = Conexion::obtener();

        $sql = "SELECT estado, COUNT(*) AS total
                FROM   tickets
                GROUP BY estado";

        return $conexion->query($sql)->fetchAll();
    }

    /**
     * Inserta un ticket nuevo y devuelve el id generado.
     * El código (TK-2026-0001) lo asigna un trigger de MySQL.
     */
    public function insertar($datos)
    {
        $conexion = Conexion::obtener();

        $sql = "INSERT INTO tickets
                    (titulo, descripcion, solicitante, correo_solicitante,
                     id_categoria, id_prioridad, id_tecnico, horas_estimadas)
                VALUES
                    (:titulo, :descripcion, :solicitante, :correo,
                     :categoria, :prioridad, :tecnico, :horas)";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([
            ":titulo"      => $datos["titulo"],
            ":descripcion" => $datos["descripcion"],
            ":solicitante" => $datos["solicitante"],
            ":correo"      => $datos["correo"],
            ":categoria"   => $datos["categoria"],
            ":prioridad"   => $datos["prioridad"],
            ":tecnico"     => $datos["tecnico"] !== "" ? $datos["tecnico"] : null,
            ":horas"       => $datos["horas"]
        ]);

        return $conexion->lastInsertId();
    }    

    /**
     * Devuelve un ticket por su id.
     */
    public function obtenerPorId($id)
    {
        $conexion = Conexion::obtener();

        $sql = "SELECT  t.*,
                        c.nombre AS categoria,
                        p.nombre AS prioridad, p.color,
                        IFNULL(e.nombre, 'Sin asignar') AS tecnico
                FROM    tickets t
                        INNER JOIN categorias  c ON t.id_categoria = c.id_categoria
                        INNER JOIN prioridades p ON t.id_prioridad = p.id_prioridad
                        LEFT  JOIN tecnicos    e ON t.id_tecnico   = e.id_tecnico
                WHERE   t.id_ticket = :id";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([":id" => $id]);

        return $sentencia->fetch();
    }

}