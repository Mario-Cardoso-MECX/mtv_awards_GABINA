-- Insertar usuario con rol de Artista
INSERT INTO usuarios (
        estatus_usuario,
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
        'Carlos',
        'Santana',
        'Gómez',
        1,
        'ca.santana@example.com',
        SHA2('password123', 256),
        'carlos_santana.jpg',
        128
    );
-- Insertar artista relacionado con el usuario (usando LAST_INSERT_ID() para id_usuario)
INSERT INTO artistas (
        estatus_artista,
        pseudonimo_artista,
        nacionalidad_artista,
        biografia_artista,
        id_usuario,
        id_genero
    )
VALUES (
        1,
        'El Guitarrista',
        'Mexicana',
        'Reconocido por sus melodías únicas y apasionadas.',
        LAST_INSERT_ID(),
        1
    );
-- Insertar álbumes relacionados con el artista (usando el id_artista insertado anteriormente)
INSERT INTO albumes (
        estatus_album,
        fecha_lanzamiento_album,
        titulo_album,
        descripcion_album,
        imagen_album,
        id_artista,
        id_genero
    )
VALUES (
        1,
        '2023-01-15',
        'Luz y Sombra',
        'Un álbum que explora la dualidad de la vida.',
        'luz_y_sombra.jpg',
        LAST_INSERT_ID(),
        1
    ),
    (
        1,
        '2023-05-20',
        'Ecos del Alma',
        'Melodías que conectan con lo más profundo del ser.',
        'ecos_del_alma.jpg',
        LAST_INSERT_ID(),
        2
    ),
    (
        1,
        '2024-03-10',
        'Sueños de Libertad',
        'Un canto a la esperanza y el cambio.',
        'suenos_de_libertad.jpg',
        LAST_INSERT_ID(),
        1
    );