DROP DATABASE IF EXISTS mtv_awardsgaby;
CREATE DATABASE IF NOT EXISTS mtv_awardsgaby DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mtv_awardsgaby;

-- =========================================================
-- TABLAS
-- =========================================================

CREATE TABLE roles (
    id_rol int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rol VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE generos (
    estatus_genero tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_genero int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_genero varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE albumes (
    estatus_album tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    fecha_lanzamiento_album DATE NOT NULL,
    id_album int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo_album varchar(50) NOT NULL,
    descripcion_album text DEFAULT NULL,
    imagen_album varchar(200) DEFAULT NULL,
    id_artista int(3) NOT NULL,
    id_genero int(3) NOT NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas (id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos (id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE canciones (
    estatus_cancion tinyint(2) NULL DEFAULT 0 COMMENT '0: Deshabilitado, 1: Habilitado',
    id_cancion int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE votaciones (
    fecha_creacion_votacion timestamp NOT NULL DEFAULT current_timestamp(),
    id_votacion int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_artista int(3) NOT NULL,
    id_album int(3) NOT NULL,
    id_nominacion INT NOT NULL,
    id_usuario int(3) NOT NULL,
    ip_votante VARCHAR(45) NULL,
    ua_votante VARCHAR(255) NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas (id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_album) REFERENCES albumes (id_album) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE categorias_nominaciones (
    id_categoria_nominacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_categoria_nominacion TINYINT(1) DEFAULT 1,
    fecha_categoria_nominacion DATE DEFAULT (CURRENT_DATE),
    nombre_categoria_nominacion VARCHAR(120) NOT NULL,
    descripcion_categoria_nominacion TEXT NOT NULL,
    contador_nominacion INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE nominaciones (
    id_nominacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_nominacion DATE DEFAULT (CURRENT_DATE),
    id_categoria_nominacion INT NOT NULL,
    id_album INT NOT NULL,
    id_artista INT NOT NULL,
    CONSTRAINT fk_nominaciones_categorias FOREIGN KEY (id_categoria_nominacion) REFERENCES categorias_nominaciones(id_categoria_nominacion) ON DELETE CASCADE,
    CONSTRAINT fk_nominaciones_albumes FOREIGN KEY (id_album) REFERENCES albumes(id_album) ON DELETE CASCADE,
    CONSTRAINT fk_nominaciones_artistas FOREIGN KEY (id_artista) REFERENCES artistas(id_artista) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS notificaciones (
  id_notificacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_artista INT NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  mensaje TEXT NOT NULL,
  leido TINYINT(1) DEFAULT 0,
  creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_artista) REFERENCES artistas(id_artista) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- INSERTS
-- =========================

INSERT INTO roles (id_rol, rol) VALUES 
(1, 'Administrador'),
(2, 'Artista'),
(3, 'Operador'),
(4, 'Audiencia');

INSERT INTO usuarios (estatus_usuario, nombre_usuario, ap_usuario, am_usuario, sexo_usuario, correo_usuario, password_usuario, imagen_usuario, id_rol) VALUES
(1,'Admin','Sistema','Root',1,'admin@mtvawards.local',SHA2('admon123',256),NULL,1),
(1,'Artista1','Pérez','Gómez',1,'artista1@mtvawards.local',SHA2('artista1',256),NULL,2),
(1,'Artista2','López','Martínez',0,'artista2@mtvawards.local',SHA2('artista2',256),NULL,2),
(1,'Artista3','García','Ruiz',1,'artista3@mtvawards.local',SHA2('artista3',256),NULL,2),
(1,'Artista4','Hernández','Soto',0,'artista4@mtvawards.local',SHA2('artista4',256),NULL,2),
(1,'Artista5','Ramírez','Ortega',1,'artista5@mtvawards.local',SHA2('artista5',256),NULL,2),
(1,'Artista6','Vargas','Cruz',0,'artista6@mtvawards.local',SHA2('artista6',256),NULL,2),
(1,'Artista7','Mendoza','Diaz',1,'artista7@mtvawards.local',SHA2('artista7',256),NULL,2),
(1,'Artista8','Gil','Navarro',0,'artista8@mtvawards.local',SHA2('artista8',256),NULL,2),
(1,'Artista9','Soto','Castillo',1,'artista9@mtvawards.local',SHA2('artista9',256),NULL,2),
(1,'Artista10','Ruiz','Pacheco',0,'artista10@mtvawards.local',SHA2('artista10',256),NULL,2),
(1,'Operador','Sistema','Op',1,'operador@mtvawards.local',SHA2('operador',256),NULL,3),
(1,'Luis','Ramírez','González',1,'luis@mtvawards.local',SHA2('audiencia123',256),NULL,4),
(1,'María','Fernández','López',0,'maria@mtvawards.local',SHA2('audiencia123',256),NULL,4);

INSERT INTO generos (estatus_genero, nombre_genero) VALUES
(1,'Pop'),
(1,'Rock'),
(1,'Hip Hop'),
(1,'Reguetón'),
(1,'Bachata'),
(1,'Corridos'),
(1,'Trap'),
(1,'R&B'),
(1,'Electrónica'),
(1,'Indie');

INSERT INTO artistas (estatus_artista, pseudonimo_artista, nacionalidad_artista, biografia_artista, id_usuario, id_genero) VALUES
(1,'Luna Pop','México','Pop juvenil con toques electrónicos',2,1),
(1,'Stone Drive','USA','Rock alternativo y energía en vivo',3,2),
(1,'MC Flow','Chile','Hip Hop con lírica urbana',4,3),
(1,'Ritmo Calle','Puerto Rico','Reguetón con baile y ritmo',5,4),
(1,'Corazón de Bachata','República Dominicana','Bachata romántica moderna',6,5),
(1,'Sierra Norte','México','Corridos con influencia regional',7,6),
(1,'TrapStar','Colombia','Trap melódico y beats modernos',8,7),
(1,'SoulWave','USA','R&B contemporáneo y vocales suaves',9,8),
(1,'ElectroPulse','Alemania','Electrónica bailable y experimental',10,9),
(1,'IndieSun','Reino Unido','Indie alternativo con guitarras claras',11,10);

INSERT INTO albumes (estatus_album, fecha_lanzamiento_album, titulo_album, descripcion_album, imagen_album, id_artista, id_genero) VALUES
(1,'2020-05-10','Luz de Luna','Debut de Luna Pop','covers/luna_luz.jpg',1,1),
(1,'2018-09-20','Drive Through','Álbum potente de Stone Drive','covers/stone_drive.jpg',2,2),
(1,'2021-03-01','Rap City','Ritmos y rimas de MC Flow','covers/rap_city.jpg',3,3),
(1,'2019-07-15','Ritmo y Calle','Éxitos de baile urbano','covers/ritmo_calle.jpg',4,4),
(1,'2017-02-14','Amor & Acordes','Bachata para corazones','covers/amor_acordes.jpg',5,5),
(1,'2022-11-01','Voces del Pueblo','Corridos contemporáneos','covers/voces_pueblo.jpg',6,6),
(1,'2023-06-30','Trap Nights','Beats y melodías nocturnas','covers/trap_nights.jpg',7,7),
(1,'2016-08-05','Wave','R&B íntimo y moderno','covers/wave.jpg',8,8),
(1,'2024-01-20','Pulse','Pistas electrónicas para pista','covers/pulse.jpg',9,9),
(1,'2015-04-10','Sunny Days','Melodías indie para el alma','covers/sunny_days.jpg',10,10);

INSERT INTO canciones (fecha_lanzamiento_cancion, nombre_cancion, duracion_cancion, mp3_cancion, url_cancion, url_video_cancion, id_album, id_artista, id_genero) VALUES
('2020-05-10', 'Quiero Verte', '00:03:25', NULL, 'https://open.spotify.com/track/example_luna','https://www.youtube.com/watch?v=example_luna',1,1,1),
('2018-09-20', 'Highway Roar', '00:04:02', NULL, 'https://open.spotify.com/track/example_stone','https://www.youtube.com/watch?v=example_stone',2,2,2),
('2021-03-01', 'City Lights', '00:03:45', NULL, 'https://open.spotify.com/track/example_flow','https://www.youtube.com/watch?v=example_flow',3,3,3),
('2019-07-15', 'Baila Conmigo', '00:02:58', NULL, 'https://open.spotify.com/track/example_ritmo','https://www.youtube.com/watch?v=example_ritmo',4,4,4),
('2017-02-14', 'Corazón Sincero', '00:04:12', NULL, 'https://open.spotify.com/track/example_bachata','https://www.youtube.com/watch?v=example_bachata',5,5,5),
('2022-11-01', 'Tierra y Voz', '00:03:55', NULL, 'https://open.spotify.com/track/example_corridos','https://www.youtube.com/watch?v=example_corridos',6,6,6),
('2023-06-30', 'Noche de Oro', '00:03:30', NULL, 'https://open.spotify.com/track/example_trap','https://www.youtube.com/watch?v=example_trap',7,7,7),
('2016-08-05', 'Sweet Whisper', '00:03:20', NULL, 'https://open.spotify.com/track/example_rnb','https://www.youtube.com/watch?v=example_rnb',8,8,8),
('2024-01-20', 'Beat Instinct', '00:05:00', NULL, 'https://open.spotify.com/track/example_elec','https://www.youtube.com/watch?v=example_elec',9,9,9),
('2015-04-10', 'Golden Afternoon', '00:03:10', NULL, 'https://open.spotify.com/track/example_indie','https://www.youtube.com/watch?v=example_indie',10,10,10);

INSERT INTO categorias_nominaciones (nombre_categoria_nominacion, descripcion_categoria_nominacion) VALUES
('Álbum del Año','Mejor álbum del año'),
('Canción del Año','Mejor canción del año'),
('Artista Revelación','Artista nuevo con mayor impacto'),
('Mejor Colaboración','Mejor colaboración entre artistas'),
('Video Musical del Año','Mejor video musical');

INSERT INTO nominaciones (id_categoria_nominacion, id_album, id_artista) VALUES
(1,1,1),
(2,2,2),
(3,3,3),
(4,4,4),
(5,5,5);

INSERT INTO votaciones (id_nominacion, id_artista, id_album, id_usuario) VALUES
(1,1,1,13),
(1,1,1,14),
(1,1,1,12),
(2,2,2,13),
(2,2,2,14),
(3,3,3,13),
(3,3,3,14),
(4,4,4,13),
(4,4,4,14),
(5,5,5,13);