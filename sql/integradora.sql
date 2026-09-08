-- ============================================================
-- Actividad Integradora 3 - Mesa de Ayuda
-- Base de datos: integradora
-- Autor: Lenin Montenegro
-- ============================================================

-- Se declara el juego de caracteres para que las tildes y la ñ
-- se guarden correctamente al importar este archivo.
SET NAMES utf8mb4;

DROP DATABASE IF EXISTS integradora;
CREATE DATABASE integradora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE integradora;

-- ------------------------------------------------------------
-- Tabla de catálogo: categorías del ticket
-- ------------------------------------------------------------
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(50) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla de catálogo: prioridades
-- ------------------------------------------------------------
CREATE TABLE prioridades (
    id_prioridad INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(20) NOT NULL,
    color        VARCHAR(7)  NOT NULL
);

-- ------------------------------------------------------------
-- Tabla de catálogo: técnicos que atienden los tickets
-- ------------------------------------------------------------
CREATE TABLE tecnicos (
    id_tecnico INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(80)  NOT NULL,
    correo     VARCHAR(100) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla principal: tickets
-- ------------------------------------------------------------
CREATE TABLE tickets (
    id_ticket           INT AUTO_INCREMENT PRIMARY KEY,
    codigo              VARCHAR(20)  NOT NULL,
    titulo              VARCHAR(100) NOT NULL,
    descripcion         TEXT         NOT NULL,
    solicitante         VARCHAR(80)  NOT NULL,
    correo_solicitante  VARCHAR(100) NOT NULL,
    id_categoria        INT          NOT NULL,
    id_prioridad        INT          NOT NULL,
    id_tecnico          INT          NULL,
    horas_estimadas     DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    estado              ENUM('Abierto','En Proceso','Resuelto','Cerrado') NOT NULL DEFAULT 'Abierto',
    fecha_creacion      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ticket_categoria FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    CONSTRAINT fk_ticket_prioridad FOREIGN KEY (id_prioridad) REFERENCES prioridades(id_prioridad),
    CONSTRAINT fk_ticket_tecnico   FOREIGN KEY (id_tecnico)   REFERENCES tecnicos(id_tecnico)
);

-- ------------------------------------------------------------
-- Bitácora de cada ticket
-- ------------------------------------------------------------
CREATE TABLE seguimientos (
    id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_ticket      INT          NOT NULL,
    comentario     VARCHAR(255) NOT NULL,
    estado         VARCHAR(20)  NOT NULL,
    fecha          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_seguimiento_ticket FOREIGN KEY (id_ticket)
        REFERENCES tickets(id_ticket) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Secuencia para generar el código del ticket
-- ------------------------------------------------------------
CREATE TABLE secuencias (
    nombre VARCHAR(20) PRIMARY KEY,
    valor  INT NOT NULL DEFAULT 0
);

INSERT INTO secuencias (nombre, valor) VALUES ('ticket', 0);

-- ------------------------------------------------------------
-- Trigger: asigna automáticamente un código tipo TK-2026-0001
-- ------------------------------------------------------------
DELIMITER $$

CREATE TRIGGER tr_ticket_codigo
BEFORE INSERT ON tickets
FOR EACH ROW
BEGIN
    DECLARE siguiente INT;

    UPDATE secuencias SET valor = valor + 1 WHERE nombre = 'ticket';
    SELECT valor INTO siguiente FROM secuencias WHERE nombre = 'ticket';

    SET NEW.codigo = CONCAT('TK-', YEAR(CURDATE()), '-', LPAD(siguiente, 4, '0'));
END$$

DELIMITER ;

-- ------------------------------------------------------------
-- Datos iniciales de los catálogos
-- ------------------------------------------------------------
INSERT INTO categorias (nombre) VALUES
    ('Hardware'),
    ('Software'),
    ('Redes'),
    ('Accesos y Contraseñas'),
    ('Correo Electrónico');

INSERT INTO prioridades (nombre, color) VALUES
    ('Baja',     '#059669'),
    ('Media',    '#2563eb'),
    ('Alta',     '#d97706'),
    ('Crítica',  '#dc2626');

INSERT INTO tecnicos (nombre, correo) VALUES
    ('Lenin Montenegro', 'lmontenegro@siglo21.net'),
    ('Andrea Vera',      'avera@siglo21.net'),
    ('Carlos Zambrano',  'czambrano@siglo21.net');

-- ------------------------------------------------------------
-- Tickets de ejemplo
-- ------------------------------------------------------------
INSERT INTO tickets (titulo, descripcion, solicitante, correo_solicitante, id_categoria, id_prioridad, id_tecnico, horas_estimadas, estado) VALUES
    ('La impresora de contabilidad no responde', 'El equipo aparece en línea pero no imprime ningún documento desde ayer.', 'María Salazar', 'msalazar@siglo21.net', 1, 3, 1, 2.00, 'En Proceso'),
    ('Solicitud de acceso al sistema de inventario', 'Se requiere crear usuario para el nuevo asistente de bodega.', 'Jorge Piedra', 'jpiedra@siglo21.net', 4, 2, 2, 1.00, 'Abierto'),
    ('Correo institucional rebota los envíos', 'Los mensajes enviados a clientes externos regresan con error de entrega.', 'Ana Cedeño', 'acedeno@siglo21.net', 5, 4, 1, 3.50, 'Resuelto');

INSERT INTO seguimientos (id_ticket, comentario, estado) VALUES
    (1, 'Ticket registrado en el sistema.', 'Abierto'),
    (1, 'Se revisó la cola de impresión y se reinició el spooler.', 'En Proceso'),
    (2, 'Ticket registrado en el sistema.', 'Abierto'),
    (3, 'Ticket registrado en el sistema.', 'Abierto'),
    (3, 'Se corrigió el registro SPF del dominio.', 'Resuelto');
