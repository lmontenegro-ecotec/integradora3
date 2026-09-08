<?php require __DIR__ . "/../layouts/encabezado.php"; ?>

<section class="seccion">
    <h2 class="titulo-seccion">Registrar nuevo ticket</h2>

    <?php if (count($errores) > 0) { ?>
        <div class="aviso aviso-error">
            <p><strong>El servidor rechazó el registro:</strong></p>
            <ul>
                <?php foreach ($errores as $error) { ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <form class="formulario" id="formulario-ticket"
          action="index.php?controlador=ticket&amp;accion=guardar" method="POST" novalidate>

        <div class="campo">
            <label for="titulo">Título del ticket</label>
            <input type="text" id="titulo" name="titulo" maxlength="100"
                   placeholder="Resuma el problema en una línea"
                   value="<?php echo htmlspecialchars($valores["titulo"] ?? ""); ?>" />
            <span class="error" id="error-titulo"></span>            
        </div>

        <div class="campo-doble">
            <div class="campo">
                <label for="solicitante">Solicitante</label>
                <input type="text" id="solicitante" name="solicitante" maxlength="80"
                       placeholder="Nombre de quien reporta"
                       value="<?php echo htmlspecialchars($valores["solicitante"] ?? ""); ?>" />
                <span class="error" id="error-solicitante"></span>
            </div>

            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" maxlength="100"
                       placeholder="usuario@siglo21.net"
                       value="<?php echo htmlspecialchars($valores["correo"] ?? ""); ?>" />
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
                            <?php echo (($valores["categoria"] ?? "") == $fila["id_categoria"]) ? "selected" : ""; ?>>
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
                            <?php echo (($valores["prioridad"] ?? "") == $fila["id_prioridad"]) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($fila["nombre"]); ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="error" id="error-prioridad"></span>
            </div>

            <div class="campo">
                <label for="horas">Horas estimadas</label>
                <input type="number" id="horas" name="horas" step="0.5" min="0.5" max="100"
                       placeholder="2.5"
                       value="<?php echo htmlspecialchars($valores["horas"] ?? ""); ?>" />
                <span class="error" id="error-horas"></span>       
            </div>
        </div>

        <div class="campo">
            <label for="tecnico">Técnico asignado <span class="opcional">(opcional)</span></label>
            <select id="tecnico" name="tecnico">
                <option value="">Sin asignar</option>
                <?php foreach ($tecnicos as $fila) { ?>
                    <option value="<?php echo $fila["id_tecnico"]; ?>"
                        <?php echo (($valores["tecnico"] ?? "") == $fila["id_tecnico"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($fila["nombre"]); ?>
                    </option>
                <?php } ?>
            </select>

        </div>

        <div class="campo">
            <label for="descripcion">Descripción del problema</label>
            <textarea id="descripcion" name="descripcion" rows="5"
                      placeholder="Detalle qué ocurre, desde cuándo y qué se ha intentado"><?php echo htmlspecialchars($valores["descripcion"] ?? ""); ?></textarea>
            <span class="contador" id="contador-descripcion">0 caracteres</span>                      
            <span class="error" id="error-descripcion"></span>                      
        </div>

        <button class="boton boton-completo" type="submit">Guardar ticket</button>
    </form>
</section>

<?php require __DIR__ . "/../layouts/pie.php"; ?>