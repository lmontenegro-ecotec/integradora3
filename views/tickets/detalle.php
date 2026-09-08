<?php require __DIR__ . "/../layouts/encabezado.php"; ?>

<section class="seccion">
    <h2 class="titulo-seccion">Ticket <?php echo htmlspecialchars($registro["codigo"]); ?></h2>

    <div class="detalle">
        <h3 class="detalle-titulo"><?php echo htmlspecialchars($registro["titulo"]); ?></h3>

        <div class="detalle-datos">
            <p><strong>Solicitante</strong> <?php echo htmlspecialchars($registro["solicitante"]); ?></p>
            <p><strong>Correo</strong> <?php echo htmlspecialchars($registro["correo_solicitante"]); ?></p>
            <p><strong>Categoría</strong> <?php echo htmlspecialchars($registro["categoria"]); ?></p>
            <p>
                <strong>Prioridad</strong>
                <span class="etiqueta" style="background-color: <?php echo $registro["color"]; ?>">
                    <?php echo htmlspecialchars($registro["prioridad"]); ?>
                </span>
            </p>
            <p><strong>Técnico</strong> <?php echo htmlspecialchars($registro["tecnico"]); ?></p>
            <p><strong>Horas estimadas</strong> <?php echo number_format($registro["horas_estimadas"], 2); ?></p>
            <p>
                <strong>Estado</strong>
                <span class="estado <?php echo claseEstado($registro["estado"]); ?>">
                    <?php echo htmlspecialchars($registro["estado"]); ?>
                </span>
            </p>
            <p><strong>Registrado</strong> <?php echo date("d/m/Y H:i", strtotime($registro["fecha_creacion"])); ?></p>
        </div>

        <h4 class="detalle-subtitulo">Descripción</h4>
        <p class="detalle-descripcion"><?php echo nl2br(htmlspecialchars($registro["descripcion"])); ?></p>
    </div>
</section>

<section class="seccion">
    <h2 class="titulo-seccion">Bitácora del ticket</h2>

    <?php if (count($bitacora) === 0) { ?>
        <p class="aviso aviso-info">Este ticket no tiene movimientos registrados.</p>
    <?php } else { ?>
        <ul class="bitacora">
            <?php foreach ($bitacora as $movimiento) { ?>
                <li class="bitacora-item">
                    <span class="bitacora-fecha"><?php echo date("d/m/Y H:i", strtotime($movimiento["fecha"])); ?></span>
                    <span class="bitacora-estado"><?php echo htmlspecialchars($movimiento["estado"]); ?></span>
                    <p class="bitacora-texto"><?php echo htmlspecialchars($movimiento["comentario"]); ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <p class="acciones-inicio">
        <a class="boton" href="index.php?controlador=ticket&amp;accion=editar&amp;id=<?php echo $registro["id_ticket"]; ?>">Editar ticket</a>
        <a class="boton boton-claro" href="index.php?controlador=ticket&amp;accion=listar">Volver al listado</a>
    </p>    
</section>

<?php require __DIR__ . "/../layouts/pie.php"; ?>