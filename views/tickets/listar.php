<?php require __DIR__ . "/../layouts/encabezado.php"; ?>

<section class="seccion">
    <h2 class="titulo-seccion">Consulta de tickets</h2>

    <?php if ($mensaje === "creado") { ?>
        <p class="aviso aviso-exito">El ticket se registró correctamente.</p>
    <?php } ?>

    <!--Busqueda y filtro-->
    <form class="barra-busqueda" action="index.php" method="GET">
        <input type="hidden" name="controlador" value="ticket" />
        <input type="hidden" name="accion" value="listar" />

        <input type="text" name="busqueda" placeholder="Buscar por código, título o solicitante"
               value="<?php echo htmlspecialchars($busqueda); ?>" />

        <select name="estado">
            <option value="">Todos los estados</option>
            <?php foreach (["Abierto", "En Proceso", "Resuelto", "Cerrado"] as $opcion) { ?>
                <option value="<?php echo $opcion; ?>" <?php echo ($estado === $opcion) ? "selected" : ""; ?>>
                    <?php echo $opcion; ?>
                </option>
            <?php } ?>
        </select>

        <button class="boton" type="submit">Buscar</button>
        <a class="boton boton-claro" href="index.php?controlador=ticket&amp;accion=listar">Limpiar</a>
    </form>

    <?php if (count($tickets) === 0) { ?>
        <p class="aviso aviso-info">No se encontraron tickets con los criterios indicados.</p>
    <?php } else { ?>
        <p class="resultado-conteo"><?php echo count($tickets); ?> ticket(s) encontrado(s)</p>

        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Solicitante</th>
                        <th>Categoría</th>
                        <th>Prioridad</th>
                        <th>Técnico</th>
                        <th>Horas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $fila) { ?>
                        <tr>
                            <td class="celda-codigo"><?php echo htmlspecialchars($fila["codigo"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["solicitante"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["categoria"]); ?></td>
                            <td>
                                <span class="etiqueta" style="background-color: <?php echo $fila["color"]; ?>">
                                    <?php echo htmlspecialchars($fila["prioridad"]); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($fila["tecnico"]); ?></td>
                            <td class="celda-numero"><?php echo number_format($fila["horas_estimadas"], 2); ?></td>
                            <td><?php echo htmlspecialchars($fila["estado"]); ?></td>
                            <td class="celda-acciones">
                                <a class="enlace-accion"
                                   href="index.php?controlador=ticket&amp;accion=detalle&amp;id=<?php echo $fila["id_ticket"]; ?>">Ver</a>
                            </td>                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</section>

<?php require __DIR__ . "/../layouts/pie.php"; ?>