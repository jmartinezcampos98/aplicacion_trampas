SELECT * FROM INSTALACIONES;
SELECT * FROM PUNTOS;
SELECT * FROM IMAGENES;



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
SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente, img.imagen 
FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion
-- WHERE ins.id_instalacion = 'BODEGAS_VEGAMAR_BAJO'
ORDER BY INS.ID_INSTALACION, INS.ID_CLIENTE
;

-- Puntos e imágenes, dada la instalacion

