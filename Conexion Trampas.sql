SELECT * FROM INSTALACIONES;
SELECT * FROM PUNTOS;
SELECT * FROM IMAGENES;

DELETE FROM PUNTOS WHERE ID_INSTALACION = 'NADA';

INSERT INTO INSTALACIONES (ID_CLIENTE, NOMBRE_CLIENTE, ID_INSTALACION) VALUES ('12345678Z','CARLOS DÍAZ', 'BODEGAS_VEGAMAR_PATIO');


INSERT INTO PUNTOS (ID_INSTALACION, NUM_PUNTO, LUGAR, COLOR, X_COORD, Y_COORD) VALUES (
    'BODEGA_VEGAMAR_PATIO',
    2,
    'REFRIGERADOR',
    '#008000'
    ,60
    ,320
);

UPDATE IMAGENES SET ID_INSTALACION = 'BODEGAS_VEGAMAR_PATIO' WHERE ID_INSTALACION = 'BODEGA_VEGAMAR_PATIO';

INSERT INTO IMAGENES (ID_INSTALACION, IMAGEN) VALUES ('BODEGAS_VEGAMAR_PATIO');

-- UPDATE PUNTOS SET LUGAR = 'ENTRADA' WHERE NUM_PUNTO = 2 AND ID_INSTALACION = 'BODEGA_VEGAMAR_PATIO';


-- Toda la información, sin imágenes
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord 
FROM instalaciones ins, puntos p 
WHERE ins.id_instalacion = p.id_instalacion
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

-- Toda la información, incluyendo las imagenes
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion, puntos p
WHERE ins.id_instalacion = p.id_instalacion
ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO
;

-- Solo las instalaciones con sus imágenes
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
