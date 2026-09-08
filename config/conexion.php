<?php
/**
 * Conexión a la base de datos MySQL.
 * Este archivo es independiente: si cambian los datos del servidor
 * solo se modifica aquí y toda la aplicación queda actualizada.
 */

class Conexion
{
    private static $servidor = "localhost";
    private static $baseDatos = "integradora";
    private static $usuario = "root";
    private static $clave = "";
    private static $conexion = null;

    /**
     * Devuelve siempre la misma conexión PDO.
     */
    public static function obtener()
    {
        if (self::$conexion === null) {
            $cadena = "mysql:host=" . self::$servidor . ";dbname=" . self::$baseDatos . ";charset=utf8mb4";

            try {
                self::$conexion = new PDO($cadena, self::$usuario, self::$clave);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                die("Error de conexión con la base de datos: " . $error->getMessage());
            }
        }

        return self::$conexion;
    }
}
