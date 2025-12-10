DROP DATABASE IF EXISTS mtv_awards;
CREATE DATABASE IF NOT EXISTS mtv_awards DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mtv_awards;
--Creacion de tablas
CREATE TABLE roles (
    id_rol int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rol varchar(50) NOT NULL
) ENGINE = InnoDB;
CREATE TABLE usuarios (
    estatus_usuario tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_usuario int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario varchar(50) NOT NULL,
    ap_usuario varchar(50) NOT NULL,
    am_usuario varchar(50) NULL,
    sexo_usuario tinyint(2) NOT NULL COMMENT '0: Femenino, 1: Masculino',
    correo_usuario varchar(50) NULL,
    password_usuario varchar(64) NULL,
    imagen_usuario varchar(200) DEFAULT NULL,
    id_rol int(3) NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES roles (id_rol) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
CREATE TABLE generos (
    estatus_genero tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_genero int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_genero varchar(50) NOT NULL
) ENGINE = InnoDB;
CREATE TABLE artistas (
    estatus_artista tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_artista int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pseudonimo_artista varchar(50) NOT NULL,
    nacionalidad_artista varchar(100) NOT NULL,
    biografia_artista text DEFAULT NULL COMMENT 'El artista aún no ha presentado su biografía',
    id_usuario int(3) NOT NULL,
    id_genero int(3) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos (id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
CREATE TABLE albumes (
    estatus_album tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    fecha_lanzamiento_album DATE NOT NULL,
    id_album int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo_album varchar(50) NOT NULL,
    descripcion_album text DEFAULT NULL COMMENT 'El artista aún no ha presentado su biografía',
    imagen_album varchar(200) DEFAULT NULL,
    id_artista int(3) NOT NULL,
    id_genero int(3) NOT NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas (id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos (id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
CREATE TABLE canciones (
    estatus_cancion tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_acancion int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_cancion varchar(50) NOT NULL,
    fecha_lanzamiento_cancion DATE NULL,
    duracion_cancion TIME NOT NULL,
    mp3_cancion varchar(200) NULL,
    url_cancion varchar(200) DEFAULT NULL,
    url_video_cancion varchar(200) DEFAULT NULL,
    id_artista int(3) NOT NULL,
    id_genero int(3) NOT NULL,
    id_album int(3) NOT NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas (id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos (id_genero) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_album) REFERENCES albumes (id_album) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
CREATE TABLE votaciones (
    fecha_creacion_votacion timestamp NOT NULL DEFAULT current_timestamp(),
    id_votacion int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_artista int(3) NOT NULL,
    id_album int(3) NOT NULL,
    id_usuario int(3) NOT NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas (id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_album) REFERENCES albumes (id_album) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
--
--Insert de datos:
--
INSERT INTO roles (id_rol, rol)
VALUES (128, 'Administrador'),
    (85, 'Artista'),
    (8, 'Operador');
-------------------------------
INSERT INTO usuarios (
        estatus_usuario,
        id_usuario,
        nombre_usuario,
        ap_usuario,
        am_usuario,
        sexo_usuario,
        correo_usuario,
        password_usuario,
        imagen_usuario,
        id_rol
    )
VALUES (
        1,
        NULL,
        'Admon',
        'Admon',
        NULL,
        0,
        'ad@mtvawards.com',
        SHA2("admon123", 0),
        NULL,
        128
    ),
    (
        1,
        NULL,
        'Artista',
        'Artista',
        NULL,
        0,
        'ar@mtvawards.com',
        SHA2("artista", 0),
        NULL,
        85
    ),
    (
        1,
        NULL,
        'Operador',
        'Operador',
        NULL,
        0,
        'op@mtvawards.com',
        SHA2("operador", 0),
        NULL,
        8
    );
-------------------------------
INSERT INTO generos (estatus_genero, nombre_genero)
VALUES (1, 'Rock Alternativo'),
    (1, 'Pop Latino'),
    (0, 'Cumbia');

