<?php
/**
 * Funciones de apoyo para las vistas.
 * Se cargan una sola vez desde index.php.
 */

/**
 * Devuelve la clase CSS que corresponde al estado de un ticket.
 * Se usa un switch porque los estados son valores fijos y conocidos.
 */
function claseEstado($estado)
{
    $clase = "";

    switch ($estado) {
        case "Abierto":
            $clase = "estado-abierto";
            break;

        case "En Proceso":
            $clase = "estado-en-proceso";
            break;

        case "Resuelto":
            $clase = "estado-resuelto";
            break;

        case "Cerrado":
            $clase = "estado-cerrado";
            break;

        default:
            $clase = "estado-cerrado";
            break;
    }

    return $clase;
}

/**
 * Devuelve el valor de una posición del arreglo o un valor por defecto.
 * Se usa isset() para comprobar que la variable exista antes de leerla.
 */
function valor($arreglo, $clave, $porDefecto = "")
{
    if (isset($arreglo[$clave])) {
        return $arreglo[$clave];
    }

    return $porDefecto;
}