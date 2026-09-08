# Mesa de Ayuda — Aplicación Web con PHP, MySQL y MVC

Actividad Integradora 3 · Lenin Montenegro

Sistema web para el registro y seguimiento de tickets de soporte técnico,
desarrollado con **HTML, CSS, JavaScript, PHP y MySQL**, aplicando el patrón
**MVC (Modelo - Vista - Controlador)**.

---

## Descripción

La aplicación permite registrar las incidencias que reportan los usuarios de una
empresa, asignarlas a un técnico, darles seguimiento hasta su cierre y consultarlas
mediante búsquedas y filtros.

Cada ticket recibe automáticamente un código correlativo (`TK-2026-0001`) y mantiene
una bitácora con todos sus movimientos.

## Flujo de la aplicación

```
Vista  →  Controlador  →  Modelo  →  Base de datos
```

1. La **vista** presenta el formulario y envía los datos por POST.
2. El **controlador** recibe la petición, valida los datos y decide qué hacer.
3. El **modelo** ejecuta la sentencia SQL contra MySQL.
4. El controlador carga la vista que muestra el resultado.

## Estructura del proyecto

```
integradora3/
├── index.php                      ← punto de entrada único (enrutador)
├── config/
│   ├── conexion.php               ← conexión PDO a MySQL
│   └── funciones.php              ← funciones de apoyo para las vistas
├── controllers/
│   └── TicketController.php       ← recibe acciones y coordina
├── models/
│   ├── Ticket.php                 ← INSERT, SELECT, UPDATE, DELETE de tickets
│   ├── Catalogo.php               ← consulta categorías, prioridades y técnicos
│   └── Seguimiento.php            ← bitácora de cada ticket
├── views/
│   ├── layouts/
│   │   ├── encabezado.php
│   │   └── pie.php
│   ├── inicio.php                 ← tablero de resumen
│   └── tickets/
│       ├── crear.php              ← formulario de registro
│       ├── listar.php             ← tabla de consulta
│       ├── detalle.php            ← ficha del ticket y bitácora
│       └── editar.php             ← formulario de modificación
├── css/
│   └── estilos.css                ← CSS propio con Flexbox y Grid
├── js/
│   └── script.js                  ← validaciones del formulario
└── sql/
    └── integradora.sql            ← script de la base de datos
```

## Base de datos

Nombre: **integradora**

| Tabla | Función |
|---|---|
| `tickets` | Tabla principal del sistema |
| `categorias` | Catálogo: Hardware, Software, Redes, Accesos, Correo |
| `prioridades` | Catálogo: Baja, Media, Alta, Crítica |
| `tecnicos` | Personal que atiende los tickets |
| `seguimientos` | Bitácora de movimientos de cada ticket |
| `secuencias` | Apoyo para generar el código correlativo |

La tabla `tickets` se relaciona con los catálogos mediante llaves foráneas.
Un **trigger** (`tr_ticket_codigo`) asigna el código del ticket antes de cada
inserción, sin que la aplicación tenga que calcularlo.

## Validaciones con JavaScript

El archivo `js/script.js` valida el formulario antes de enviarlo al servidor:

| Tipo de validación | Campo |
|---|---|
| Campos vacíos | Todos los obligatorios |
| Longitud de datos | Título (mínimo 5) y descripción (mínimo 10) |
| Campos numéricos | Horas estimadas |
| Valores incorrectos | Horas fuera del rango 0.5 a 100 |
| Correo electrónico | Correo del solicitante |

Los campos con error se marcan en rojo y muestran el mensaje debajo.

El controlador **repite todas las validaciones en PHP**, porque un usuario puede
desactivar JavaScript. El servidor nunca confía en el navegador.

## Elementos de PHP aplicados

| Elemento | Dónde se utiliza |
|---|---|
| Variables y concatenación | Todos los archivos |
| Tipos: cadena, entero, decimal y booleano | `resumenCarga()` en `models/Ticket.php` |
| Operadores aritméticos `+ - * /` | Cálculo de la carga de trabajo |
| Operadores de comparación `=== !== > < <=` | Validaciones del controlador |
| Condicional `if / else` | Validaciones y vistas |
| `switch` | Función `claseEstado()` en `config/funciones.php` |
| `foreach` | Recorrido de resultados en las vistas |
| `while` con `fetch()` | Recorrido fila por fila en `resumenCarga()` |
| `isset()` | Lectura de `$_POST` y `$_GET` |
| `echo` | Salida de datos en las vistas |
| `$_POST` | Recepción del formulario |
| `$_GET` | Enrutador, búsqueda y filtros |
| Funciones | Modelos, controlador y funciones de apoyo |

### Cálculo de la carga de trabajo

El método `resumenCarga()` del modelo recorre los tickets con un ciclo `while`
y calcula:

- **Suma:** total de horas estimadas de todos los tickets.
- **Resta:** horas pendientes = total de horas − horas ya cerradas.
- **División:** promedio de horas por ticket.
- **Multiplicación:** porcentaje de avance = (horas cerradas ÷ total) × 100.

El resultado se muestra en el tablero de inicio con una barra de progreso.

## Funcionalidades

- Registro de tickets con formulario validado.
- Consulta en tabla HTML con todos los datos relacionados.
- Búsqueda por código, título o solicitante.
- Filtro por estado.
- Edición de tickets y cambio de estado.
- Eliminación con confirmación previa.
- Ficha de detalle con la bitácora completa del ticket.
- Tablero de inicio con el conteo por estado.

## Requisitos

- XAMPP (Apache + MySQL + PHP 7.4 o superior)
- Navegador web moderno

## Instalación

1. Copiar la carpeta `integradora3` dentro de `C:\xampp\htdocs\`.

2. Iniciar **Apache** y **MySQL** desde el panel de XAMPP.

3. Abrir phpMyAdmin en `http://localhost/phpmyadmin`.

4. Ir a la pestaña **Importar**, seleccionar el archivo `sql/integradora.sql`
   y pulsar **Continuar**. El script crea la base de datos, las tablas, el trigger
   y los datos de ejemplo.

5. Abrir en el navegador:

   ```
   http://localhost/integradora3/
   ```

La conexión está configurada en `config/conexion.php` con usuario `root` y sin
contraseña, que es la configuración por defecto de XAMPP. Si su servidor usa otros
datos, solo debe modificarse ese archivo.

## Tecnologías utilizadas

- **HTML5** con etiquetas semánticas.
- **CSS3** propio con variables en `:root`, Flexbox y Grid.
- **JavaScript** para las validaciones del lado del cliente.
- **PHP 8** con PDO y sentencias preparadas.
- **MySQL** con llaves foráneas y un trigger.
- **Git y GitHub** para el control de versiones.

## Seguridad aplicada

- Todas las consultas usan **sentencias preparadas** de PDO, lo que evita
  inyección SQL.
- Toda la información que se imprime en pantalla pasa por `htmlspecialchars()`,
  lo que evita la inyección de código HTML.
- El enrutador de `index.php` solo acepta acciones de una lista blanca.

## Autor

Lenin Montenegro — Tecnólogo en Desarrollo de Software
GitHub: [lmontenegro-ecotec](https://github.com/lmontenegro-ecotec)