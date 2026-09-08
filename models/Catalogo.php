<?php
/**
 * MODELO: Catalogo
 * Consulta las tablas de apoyo que alimentan las listas desplegables.
 */

require_once __DIR__ . "/../config/conexion.php";

class Catalogo
{
    public function categorias()
    {
        $conexion = Conexion::obtener();

        return $conexion->query("SELECT id_categoria, nombre
                                 FROM   categorias
                                 ORDER BY nombre")->fetchAll();
    }

    public function prioridades()
    {
        $conexion = Conexion::obtener();

        return $conexion->query("SELECT id_prioridad, nombre, color
                                 FROM   prioridades
                                 ORDER BY id_prioridad")->fetchAll();
    }

    public function tecnicos()
    {
        $conexion = Conexion::obtener();

        return $conexion->query("SELECT id_tecnico, nombre
                                 FROM   tecnicos
                                 ORDER BY nombre")->fetchAll();
    }
}
