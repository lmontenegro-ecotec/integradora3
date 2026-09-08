<?php require __DIR__ . "/layouts/encabezado.php"; ?>

<section class="seccion">
    <h2 class="titulo-seccion">Resumen general</h2>

    <?php
    // Se arma un arreglo con los cuatro estados para que siempre aparezcan
    $estados = ["Abierto" => 0, "En Proceso" => 0, "Resuelto" => 0, "Cerrado" => 0];

    foreach ($resumen as $fila) {
        $estados[$fila["estado"]] = $fila["total"];
    }
    ?>

    <div class="tablero">
        <?php foreach ($estados as $nombre => $total) { ?>
            <article class="tarjeta-estado estado-<?php echo str_replace(" ", "-", strtolower($nombre)); ?>">
                <p class="tarjeta-numero"><?php echo $total; ?></p>
                <p class="tarjeta-texto"><?php echo $nombre; ?></p>
            </article>
        <?php } ?>
    </div>
</section>

<section class="seccion">
    <h2 class="titulo-seccion">Carga de trabajo</h2>

    <div class="panel-carga">
        <div class="carga-cifras">
            <div class="cifra">
                <span class="cifra-valor"><?php echo $carga["total_tickets"]; ?></span>
                <span class="cifra-texto">Tickets registrados</span>
            </div>

            <div class="cifra">
                <span class="cifra-valor"><?php echo number_format($carga["total_horas"], 2); ?></span>
                <span class="cifra-texto">Horas estimadas</span>
            </div>

            <div class="cifra">
                <span class="cifra-valor"><?php echo number_format($carga["horas_pendientes"], 2); ?></span>
                <span class="cifra-texto">Horas pendientes</span>
            </div>

            <div class="cifra">
                <span class="cifra-valor"><?php echo number_format($carga["promedio_horas"], 2); ?></span>
                <span class="cifra-texto">Promedio por ticket</span>
            </div>
        </div>

        <div class="avance">
            <div class="avance-titulo">
                <span>Avance de atención</span>
                <span><?php echo number_format($carga["porcentaje_avance"], 1); ?>%</span>
            </div>

            <div class="avance-barra">
                <div class="avance-relleno" style="width: <?php echo $carga["porcentaje_avance"]; ?>%"></div>
            </div>

            <?php if ($carga["hay_pendientes"]) { ?>
                <p class="avance-nota">
                    Quedan <?php echo number_format($carga["horas_pendientes"], 2); ?> horas
                    de trabajo por atender.
                </p>
            <?php } else { ?>
                <p class="avance-nota">No hay trabajo pendiente en la mesa de ayuda.</p>
            <?php } ?>
        </div>
    </div>
</section>

<section class="seccion">
    <h2 class="titulo-seccion">Últimos tickets registrados</h2>

    <?php if (count($ultimos) === 0) { ?>
        <p class="aviso aviso-info">Todavía no hay tickets registrados.</p>
    <?php } else { ?>
        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Solicitante</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($ultimos, 0, 5) as $fila) { ?>
                        <tr>
                            <td class="celda-codigo"><?php echo htmlspecialchars($fila["codigo"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["solicitante"]); ?></td>
                            <td>
                                <span class="etiqueta" style="background-color: <?php echo $fila["color"]; ?>">
                                    <?php echo htmlspecialchars($fila["prioridad"]); ?>
                                </span>
                            </td>
                            <td>
                                <span class="estado <?php echo claseEstado($fila["estado"]); ?>">
                                    <?php echo htmlspecialchars($fila["estado"]); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <p class="acciones-inicio">
            <a class="boton" href="index.php?controlador=ticket&amp;accion=crear">Registrar un ticket</a>
            <a class="boton boton-claro" href="index.php?controlador=ticket&amp;accion=listar">Ver todos</a>
        </p>
    <?php } ?>
</section>

<?php require __DIR__ . "/layouts/pie.php"; ?>