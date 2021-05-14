--------------------------------------------------------------------
-- 
-- TABLAS DE LA BASE DE DATOS
-- 
--------------------------------------------------------------------
SELECT * FROM INSTALACIONES;
SELECT * FROM PUNTOS;
SELECT * FROM IMAGENES;
SELECT * FROM HISTORIAL;

--------------------------------------------------------------------
-- 
-- CONSULTAS PARA LA OBTENCI�N / ACTUALIZACI�N DE DATOS
-- 
--------------------------------------------------------------------
DELETE FROM puntos 
        WHERE id_instalacion = '. $id_instalacion . '

--
INSERT INTO PUNTOS (NUM_PUNTO, ID_INSTALACION, X_COORD, Y_COORD, LUGAR) 
VALUES . "('$num_punto',"
        . "'$id_instalacion',"
        . "'$x_coord',"
        . "'$y_coord',"
        . "'$lugar'")

--
SELECT ins.id_instalacion, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion
WHERE ins.id_instalacion = . "$id_instalacion"

--
SELECT h.id_instalacion, h.num_punto, h.color, p.lugar, p.x_coord, p.y_coord 
FROM historial h 
	LEFT JOIN puntos p ON (h.id_instalacion = p.id_instalacion AND h.num_punto = p.num_punto)
WHERE (H.ID_INSTALACION, H.NUM_PUNTO, H.FECHA) IN (
	SELECT sub.id_instalacion, sub.num_punto, MAX(sub.fecha) FROM historial sub GROUP BY sub.id_instalacion, sub.num_punto
) AND p.id_instalacion = '" . $id_instalacion . "'
ORDER BY p.id_instalacion, p.num_punto


--
SELECT p.id_instalacion, p.num_punto, avg(h.color) as color, p.lugar, p.x_coord, p.y_coord
FROM historial h 
	LEFT JOIN puntos p ON (h.id_instalacion = p.id_instalacion AND h.num_punto = p.num_punto)
WHERE p.id_instalacion = '" . $id_instalacion ."' 
	and h.fecha >= ('" . $despues_de['anyo'] . '-' . $despues_de['mes'] . '-' . $despues_de['dia'] . "') 
	AND h.fecha <= ('" . $antes_de['anyo'] . '-' . $antes_de['mes'] . '-' . $antes_de['dia'] . "')
GROUP BY p.id_instalacion, p.num_punto, p.lugar, p.x_coord, p.y_coord
ORDER BY p.id_instalacion, p.num_punto

--------------------------------------------------------------------
-- 
-- CONSULTAS UTILIZADAS DURANTE EL DESARROLLO 
-- (NO ACTUALIZADAS, NO TODAS SE COMPORTAN COMO SE ESPERAR�A)
-- 
--------------------------------------------------------------------
DELETE FROM PUNTOS WHERE ID_INSTALACION = 'NADA';

INSERT INTO INSTALACIONES (ID_CLIENTE, NOMBRE_CLIENTE, ID_INSTALACION) VALUES ('12345678Z','CARLOS D�AZ', 'BODEGAS_VEGAMAR_PATIO');

UPDATE PUNTOS SET LUGAR = 'RECEPCI�N' WHERE ID_INSTALACION = 'BODEGAS_VEGAMAR_PATIO' AND NUM_PUNTO = 3;

INSERT INTO PUNTOS (ID_INSTALACION, NUM_PUNTO, LUGAR, X_COORD, Y_COORD) VALUES (
    'BODEGAS_VEGAMAR_BAJO',
    3,
    'RESERVA'
    ,60
    ,320
);

UPDATE IMAGENES SET ID_INSTALACION = 'BODEGAS_VEGAMAR_PATIO' WHERE ID_INSTALACION = 'BODEGA_VEGAMAR_PATIO';

INSERT INTO IMAGENES (ID_INSTALACION, IMAGEN) VALUES ('BODEGAS_VEGAMAR_PATIO');

-- UPDATE PUNTOS SET LUGAR = 'ENTRADA' WHERE NUM_PUNTO = 2 AND ID_INSTALACION = 'BODEGA_VEGAMAR_PATIO';


-- Toda la informaci�n, sin im�genes
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord 
FROM instalaciones ins, puntos p 
WHERE ins.id_instalacion = p.id_instalacion
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

-- Toda la informaci�n, incluyendo las imagenes
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion, puntos p
WHERE ins.id_instalacion = p.id_instalacion
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

-- Solo las instalaciones con sus im�genes
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion
-- WHERE ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO'
ORDER BY INS.ID_INSTALACION, INS.ID_CLIENTE
;

-- Solo las instalaciones
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente
FROM instalaciones ins
ORDER BY INS.ID_INSTALACION, INS.ID_CLIENTE
;

-- Puntos, dada la instalacion
SELECT ins.id_instalacion, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord
FROM instalaciones ins, puntos p
WHERE ins.id_instalacion = p.id_instalacion AND ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO'
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

-- Imagen, dada la instalacion
SELECT ins.id_instalacion, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion
WHERE ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO'
;

SELECT * FROM PUNTOS;

INSERT INTO PUNTOS (ID_INSTALACION, COLOR, X_COORD, Y_COORD, NUM_PUNTO, LUGAR) VALUES 
('BODEGAS_VEGAMAR_PATIO','#ff0000',125,70,1,'REFRIGERADOR'),
('BODEGAS_VEGAMAR_PATIO','#ff0000',45,80,2,'CONDENSADOR'),
('BODEGAS_VEGAMAR_PATIO','#008000',74,90,3,'RESERVA'),
('BODEGAS_VEGAMAR_PATIO','#ffff00',254,200,4,'ESCALERAS');

DELETE FROM PUNTOS WHERE COLOR = 'red';


-- solo el �ltimo registro
SELECT ins.id_instalacion, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord
FROM instalaciones ins, puntos p
WHERE ins.id_instalacion = p.id_instalacion AND ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO' AND
    p.fecha = (SELECT MAX(fecha) FROM puntos)
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;


-- una media de todos los registros
SELECT 
    ins.id_instalacion, 
    p.num_punto, 
    AVG(p.x_coord),
    AVG(p.x_coord)
FROM instalaciones ins, puntos p
WHERE ins.id_instalacion = p.id_instalacion AND ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO'
    
GROUP BY ID_INSTALACION, NUM_PUNTO
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

SELECT 0 FROM PUNTOS WHERE COLOR = '#ff0000';
SELECT 0.5 FROM PUNTOS WHERE COLOR = '#ffff00';
SELECT 1 FROM PUNTOS WHERE COLOR = '#008000';

INSERT INTO HISTORIAL (id_instalacion, num_punto, color) VALUES (
'BODEGAS_VEGAMAR_PATIO',
3,
-- '#ffff00'
 '#008000'
-- '#ff0000'
);

/*
$punto["id_instalacion"];
$punto["x_coord"];
$punto["y_coord"];
$punto["color"];
$punto["lugar"];
*/

-- OBTIENE SOLO LOS ULTIMOS PUNTOS
SELECT * FROM HISTORIAL 
WHERE (ID_INSTALACION, NUM_PUNTO, FECHA) IN (SELECT ID_INSTALACION, NUM_PUNTO, MAX(FECHA) FROM HISTORIAL GROUP BY ID_INSTALACION, NUM_PUNTO);

-- OBTIENE SOLO LOS ULTIMOS PUNTOS, JUNTO CON TODA SU CONFIGURACI�N
SELECT H.ID_INSTALACION, H.NUM_PUNTO, H.COLOR, P.LUGAR, P.X_COORD, P.Y_COORD 
FROM HISTORIAL H 
    LEFT JOIN PUNTOS P ON (H.ID_INSTALACION = P.ID_INSTALACION AND H.NUM_PUNTO = P.NUM_PUNTO)
WHERE (H.ID_INSTALACION, H.NUM_PUNTO, H.FECHA) IN (
    SELECT SUB.ID_INSTALACION, SUB.NUM_PUNTO, MAX(SUB.FECHA) FROM HISTORIAL SUB GROUP BY SUB.ID_INSTALACION, SUB.NUM_PUNTO
) -- AND P.ID_INSTALACION = 'BODEGAS_VEGAMAR_BAJO'
ORDER BY P.ID_INSTALACION, P.NUM_PUNTO
;

-- SUBCONSULTA PARA OBTENER AGRUPAR LOS ULTIMOS PUNTOS
SELECT SUB.ID_INSTALACION, SUB.NUM_PUNTO, MAX(SUB.FECHA) FROM HISTORIAL SUB GROUP BY SUB.ID_INSTALACION, SUB.NUM_PUNTO;


-- OBTIENE LA CONFIGURACION Y LA MEDIA DE LOS COLORES
SELECT SUB.ID_INSTALACION, SUB.NUM_PUNTO, AVG(SUB.COLOR)
FROM HISTORIAL SUB 
    -- LEFT JOIN PUNTOS P ON SUB.ID_INSTALACION = P.ID_INSTALACION
GROUP BY SUB.ID_INSTALACION, SUB.NUM_PUNTO;


