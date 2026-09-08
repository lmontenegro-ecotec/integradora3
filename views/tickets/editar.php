<?php require __DIR__ . "/../layouts/encabezado.php"; ?>

<section class="seccion">
    <h2 class="titulo-seccion">Editar ticket <?php echo htmlspecialchars($registro["codigo"]); ?></h2>

    <?php if (count($errores) > 0) { ?>
        <div class="aviso aviso-error">
            <p><strong>El servidor rechazó los cambios:</strong></p>
            <ul>
                <?php foreach ($errores as $error) { ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <form class="formulario" id="formulario-ticket"
          action="index.php?controlador=ticket&amp;accion=actualizar" method="POST" novalidate>

        <input type="hidden" name="id_ticket" value="<?php echo $registro["id_ticket"]; ?>" />

        <div class="campo">
            <label for="titulo">Título del ticket</label>
            <input type="text" id="titulo" name="titulo" maxlength="100"
                   value="<?php echo htmlspecialchars($registro["titulo"]); ?>" />
            <span class="error" id="error-titulo"></span>
        </div>

        <div class="campo-doble">
            <div class="campo">
                <label for="solicitante">Solicitante</label>
                <input type="text" id="solicitante" name="solicitante" maxlength="80"
                       value="<?php echo htmlspecialchars($registro["solicitante"]); ?>" />
                <span class="error" id="error-solicitante"></span>
            </div>

            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" maxlength="100"
                       value="<?php echo htmlspecialchars($registro["correo_solicitante"]); ?>" />
                <span class="error" id="error-correo"></span>
            </div>
        </div>

        <div class="campo-triple">
            <div class="campo">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria">
                    <option value="">Seleccione...</option>
                    <?php foreach ($categorias as $fila) { ?>
                        <option value="<?php echo $fila["id_categoria"]; ?>"
                            <?php echo ($registro["id_categoria"] == $fila["id_categoria"]) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($fila["nombre"]); ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="error" id="error-categoria"></span>
            </div>

            <div class="campo">
                <label for="prioridad">Prioridad</label>
                <select id="prioridad" name="prioridad">
                    <option value="">Seleccione...</option>
                    <?php foreach ($prioridades as $fila) { ?>
                        <option value="<?php echo $fila["id_prioridad"]; ?>"
                            <?php echo ($registro["id_prioridad"] == $fila["id_prioridad"]) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($fila["nombre"]); ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="error" id="error-prioridad"></span>
            </div>

            <div class="campo">
                <label for="horas">Horas estimadas</label>
                <input type="number" id="horas" name="horas" step="0.5" min="0.5" max="100"
                       value="<?php echo htmlspecialchars($registro["horas_estimadas"]); ?>" />
                <span class="error" id="error-horas"></span>
            </div>
        </div>

        <div class="campo-doble">
            <div class="campo">
                <label for="tecnico">Técnico asignado</label>
                <select id="tecnico" name="tecnico">
                    <option value="">Sin asignar</option>
                    <?php foreach ($tecnicos as $fila) { ?>
                        <option value="<?php echo $fila["id_tecnico"]; ?>"
                            <?php echo ($registro["id_tecnico"] == $fila["id_tecnico"]) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($fila["nombre"]); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="campo">
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <?php foreach (["Abierto", "En Proceso", "Resuelto", "Cerrado"] as $opcion) { ?>
                        <option value="<?php echo $opcion; ?>"
                            <?php echo ($registro["estado"] === $opcion) ? "selected" : ""; ?>>
                            <?php echo $opcion; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="campo">
            <label for="descripcion">Descripción del problema</label>
            <textarea id="descripcion" name="descripcion" rows="5"><?php echo htmlspecialchars($registro["descripcion"]); ?></textarea>
            <span class="contador" id="contador-descripcion">0 caracteres</span>
            <span class="error" id="error-descripcion"></span>
        </div>

        <div class="acciones-formulario">
            <button class="boton" type="submit">Guardar cambios</button>
            <a class="boton boton-claro" href="index.php?controlador=ticket&amp;accion=listar">Cancelar</a>
        </div>
    </form>
</section>

<?php require __DIR__ . "/../layouts/pie.php"; ?>