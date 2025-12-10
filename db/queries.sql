SELECT *
FROM tabla
Where condition;
---------------------------------------------------------------------------
--obtener el album con sus canciones.
SELECT a.titulo_album AS "Álbum",
    c.nombre_cancion AS "Canción"
FROM albumes a
    INNER JOIN canciones c ON a.id_album = c.id_album
ORDER BY a.titulo_album,
    c.nombre_cancion;
----------------------------------------------------------------------------
SELECT a.titulo_album AS "Álbum",
    c.nombre_cancion AS "Canción"
FROM albumes a
    INNER JOIN canciones c ON a.id_album = c.id_album
WHERE a.id_album = :id_album
ORDER BY c.nombre_cancion;
SELECT a.titulo_album AS "Álbum",
    ar.pseudonimo_artista AS "Artista",
    c.nombre_cancion AS "Canción"
FROM albumes a
    INNER JOIN artistas ar ON a.id_artista = ar.id_artista
    INNER JOIN canciones c ON a.id_album = c.id_album
WHERE a.id_album = 3
ORDER BY c.nombre_cancion;
--------------------------------------------------------------------------------------
SELECT 
    ar.id_artista,
    ar.pseudonimo_artista,
    ar.nacionalidad_artista,
    ar.biografia_artista,
    ar.estatus_artista,
    g.nombre_genero AS genero_artista,
    al.id_album,
    al.titulo_album,
    al.fecha_lanzamiento_album,
    al.descripcion_album,
    al.imagen_album,
    al.estatus_album,
    c.id_acancion,
    c.nombre_cancion,
    c.fecha_lanzamiento_cancion,
    c.duracion_cancion,
    c.mp3_cancion,
    c.url_cancion,
    c.url_video_cancion,
    c.estatus_cancion
FROM artistas ar
JOIN generos g ON ar.id_genero = g.id_genero
JOIN albumes al ON ar.id_artista = al.id_artista
LEFT JOIN canciones c ON al.id_album = c.id_album
WHERE al.id_album = 7;
