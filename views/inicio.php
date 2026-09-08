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
                            <td><?php echo htmlspecialchars($fila["estado"]); ?></td>
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