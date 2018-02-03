------------------------------
-- Archivo de base de datos --
------------------------------


DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
      id       BIGSERIAL    PRIMARY KEY
    , codigo   NUMERIC(5,0) UNIQUE NOT NULL
    , titulo   VARCHAR(255) UNIQUE NOT NULL
    , num_pags NUMERIC(4,0) CONSTRAINT ck_numeros_positivos CHECK
                                (num_pags > 0)
    , autor    VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS socios CASCADE;

CREATE TABLE socios
(
      id        BIGSERIAL    PRIMARY KEY
    , numero    NUMERIC(5,0) UNIQUE NOT NULL
    , nombre    VARCHAR(255) 
    , direccion VARCHAR(255)
    , telefono  NUMERIC(9,0) CONSTRAINT ck_numeros_positivos CHECK
                                (telefono > 0)
);


DROP TABLE IF EXISTS prestaciones CASCADE;

CREATE TABLE prestaciones
(
      id         BIGSERIAL    PRIMARY KEY
    , libro_id   BIGINT       REFERENCES libros (id) ON DELETE NO ACTION
                                                     ON UPDATE CASCADE
    , socio_id   BIGINT       REFERENCES socios (id) ON DELETE NO ACTION
                                                     ON UPDATE CASCADE
    , create_at  TIMESTAMP(0) DEFAULT    current_timestamp
    , devolucion TIMESTAMP(0) DEFAULT    NULL
);

INSERT INTO libros (codigo, titulo, num_pags, autor)
    VALUES ('10', 'Cincuenta sombras de Gray', 200, 'Maria Estalone'),
            ('20', 'Bajarse al moro', 125, 'Silvestre Manga'),
            ('30', 'Poesias para contar', 400, 'Lucia Obiedo');

INSERT INTO socios (numero, nombre, direccion, telefono)
    VALUES ('100', 'Óscar', 'Su casa', 764567893),
            ('200', 'Casandra', 'Calle Bolsa', 777888999),
            ('300', 'Manuel', 'Carretera Puerto', 789321456);

INSERT INTO prestaciones (libro_id, socio_id, create_at, devolucion)
    VALUES (1, 2, default, null),
            (3, 1, current_timestamp(0) - '4 days'::interval, current_timestamp(0)),
            (3, 3, default, null);
