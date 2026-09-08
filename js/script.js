/* ============================================================
   Mesa de Ayuda - Validaciones del lado del cliente
   Actividad Integradora 3 - Lenin Montenegro
   ============================================================ */


/* ------------------------------------------------------------
   1. VARIABLES
   ------------------------------------------------------------ */

const formularioTicket = document.getElementById("formulario-ticket");
const campoDescripcion = document.getElementById("descripcion");
const contadorDescripcion = document.getElementById("contador-descripcion");
const enlacesEliminar = document.querySelectorAll(".enlace-eliminar");


/* ------------------------------------------------------------
   2. FUNCIONES DE APOYO
   ------------------------------------------------------------ */

/**
 * Muestra un mensaje de error debajo del campo indicado.
 */
function mostrarError(idCampo, mensaje) {
    const campo = document.getElementById(idCampo);
    const contenedorError = document.getElementById("error-" + idCampo);

    campo.classList.add("campo-invalido");
    contenedorError.textContent = mensaje;
}

/**
 * Limpia el error de un campo.
 */
function limpiarError(idCampo) {
    const campo = document.getElementById(idCampo);
    const contenedorError = document.getElementById("error-" + idCampo);

    campo.classList.remove("campo-invalido");
    contenedorError.textContent = "";
}

/**
 * Verifica que el texto tenga formato de correo electrónico.
 */
function esCorreoValido(correo) {
    const patron = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;

    return patron.test(correo);
}


/* ------------------------------------------------------------
   3. VALIDACION DEL FORMULARIO
   ------------------------------------------------------------ */

function validarFormulario(evento) {
    let hayErrores = false;

    const titulo = document.getElementById("titulo").value.trim();
    const solicitante = document.getElementById("solicitante").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const categoria = document.getElementById("categoria").value;
    const prioridad = document.getElementById("prioridad").value;
    const horas = document.getElementById("horas").value.trim();
    const descripcion = document.getElementById("descripcion").value.trim();

    /* Se limpian los errores anteriores */
    limpiarError("titulo");
    limpiarError("solicitante");
    limpiarError("correo");
    limpiarError("categoria");
    limpiarError("prioridad");
    limpiarError("horas");
    limpiarError("descripcion");

    /* Campo vacío y longitud de datos */
    if (titulo === "") {
        mostrarError("titulo", "El título es obligatorio.");
        hayErrores = true;
    } else if (titulo.length < 5) {
        mostrarError("titulo", "El título debe tener al menos 5 caracteres.");
        hayErrores = true;
    }

    /* Campo vacío */
    if (solicitante === "") {
        mostrarError("solicitante", "Indique quién reporta el problema.");
        hayErrores = true;
    }

    /* Correo electrónico */
    if (correo === "") {
        mostrarError("correo", "El correo electrónico es obligatorio.");
        hayErrores = true;
    } else if (esCorreoValido(correo) === false) {
        mostrarError("correo", "Escriba un correo válido, por ejemplo usuario@siglo21.net");
        hayErrores = true;
    }

    /* Valores incorrectos en las listas */
    if (categoria === "") {
        mostrarError("categoria", "Seleccione una categoría.");
        hayErrores = true;
    }

    if (prioridad === "") {
        mostrarError("prioridad", "Seleccione una prioridad.");
        hayErrores = true;
    }

    /* Campo numérico */
    if (horas === "") {
        mostrarError("horas", "Indique las horas estimadas.");
        hayErrores = true;
    } else if (isNaN(horas) === true) {
        mostrarError("horas", "Las horas deben ser un número.");
        hayErrores = true;
    } else if (Number(horas) <= 0 || Number(horas) > 100) {
        mostrarError("horas", "Las horas deben estar entre 0.5 y 100.");
        hayErrores = true;
    }

    /* Longitud de datos */
    if (descripcion === "") {
        mostrarError("descripcion", "La descripción es obligatoria.");
        hayErrores = true;
    } else if (descripcion.length < 10) {
        mostrarError("descripcion", "Describa el problema con al menos 10 caracteres.");
        hayErrores = true;
    }

    /* Si hay errores se detiene el envío al servidor */
    if (hayErrores === true) {
        evento.preventDefault();
    }
}

if (formularioTicket !== null) {
    formularioTicket.addEventListener("submit", validarFormulario);
}


/* ------------------------------------------------------------
   4. CONTADOR DE CARACTERES DE LA DESCRIPCION
   ------------------------------------------------------------ */

function actualizarContador() {
    const cantidad = campoDescripcion.value.length;

    if (cantidad === 1) {
        contadorDescripcion.textContent = "1 caracter";
    } else {
        contadorDescripcion.textContent = cantidad + " caracteres";
    }
}

if (campoDescripcion !== null) {
    campoDescripcion.addEventListener("input", actualizarContador);
    actualizarContador();
}

/* ------------------------------------------------------------
   5. CONFIRMACION ANTES DE ELIMINAR
   ------------------------------------------------------------ */

enlacesEliminar.forEach(function (enlace) {
    enlace.addEventListener("click", function (evento) {
        const codigo = enlace.getAttribute("data-codigo");
        const confirmado = confirm("¿Está seguro de eliminar el ticket " + codigo + "? Esta acción no se puede deshacer.");

        if (confirmado === false) {
            evento.preventDefault();
        }
    });
});