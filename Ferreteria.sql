CREATE DATABASE ferreteria;
USE ferreteria;

CREATE TABLE producto(IdProducto INT PRIMARY KEY, nombreProd varchar(20) NOT NULL, descripcion varchar(40) NOT NULL, precio INT NOT NULL, existencias INT NOT NULL);
CREATE TABLE proveedor(RFCProveedor VARCHAR(15) PRIMARY KEY, nombreP VARCHAR(15) NOT NULL, apellidoPP VARCHAR(15) NOT NULL, apellidoMP VARCHAR(15) NOT NULL);
CREATE TABLE proveer(IdProductoT INT, RFCProveedorT VARCHAR(15), FOREIGN KEY (IdProductoT) REFERENCES producto(IdProducto), FOREIGN KEY (RFCProveedorT) REFERENCES proveedor(RFCProveedor) );

CREATE TABLE empleado(RFCEmpleado VARCHAR(15) PRIMARY KEY, nombreE VARCHAR(15) NOT NULL, apellidoPE VARCHAR(15) NOT NULL, apellidoME VARCHAR(15) NOT NULL);
CREATE TABLE cliente(RFCCliente VARCHAR(15) PRIMARY KEY, nombreCliente VARCHAR(15) NOT NULL, apellidoPC VARCHAR(15) NOT NULL, apellidoMC VARCHAR(15) NOT NULL, direccion VARCHAR(40) NOT NULL, telefono BIGINT NOT NULL, correo VARCHAR(50) NOT NULL);
CREATE TABLE facturar(RFCEmpleadoT VARCHAR(15), RFCClienteT VARCHAR(15), IdProductoT INT, total INT NOT NULL, fecha INT NOT NULL, numArticulos INT NOT NULL, FOREIGN KEY (RFCEmpleadoT) REFERENCES empleado(RFCEmpleado), FOREIGN KEY (RFCClienteT) REFERENCES cliente(RFCCliente), FOREIGN KEY (IdProductoT) REFERENCES producto(IdProducto));

INSERT INTO producto VALUES (1, "Clavo", "Clavo Para Concreto 2 1/2IN Negro", 3, 100),
							(2, "Tornillo", "Tornillo Hexagonal 8X0.6CM Plata", 4, 80),
							(3, "Tuerca", "Tuerca de Seguridad Plata 3/8IN Plata", 3, 80),
                            (4, "Taquete", "Taquete de Plástico 5/16IN Gris", 2, 90),
                            (5, "Martillo", "Martillo de Bola de 32 Onzas", 389, 80),
                            (6, "Desarmador", "Desarmador Punta Gabinete", 139, 25),
                            (7, "Broca", "Broca para Vidrio 1/8IN", 112, 30),
                            (8, "Taladro", "Taladro Inalámbrico 20v", 1199, 5),
                            (9, "Clavija", "Clavija Industrial 125v", 19, 35),
                            (10, "Lija", "Lija de Agua 80", 15, 40),
                            (11, "Candado", "Candado Laminado de 38MM", 155, 15);
DELETE FROM producto WHERE IdProducto=11;
UPDATE producto SET precio=159 WHERE IdProducto=6;
                            
INSERT INTO proveedor VALUES ("URP0509031H0", "Alejandro", "Urbina", "Pérez"),
							 ("ROS9065920H2", "Javier", "Rosales", "Sánchez"),
                             ("TED0604239H3", "Patricio", "Tenorio", "Díaz");
DELETE FROM proveedor WHERE RFCProveedor="ROS9065920H2";
UPDATE proveedor SET apellidoMP="Díaz de León" WHERE RFCProveedor="TED0604239H3";
                             
INSERT INTO proveer VALUES (1, "URP0509031H0"),
						   (2, "URP0509031H0"),
						   (3, "URP0509031H0"),
						   (4, "URP0509031H0"),
						   (5, "TED0604239H3"),
						   (6, "TED0604239H3"),
                           (7, "URP0509031H0"),
						   (8, "TED0604239H3"),
						   (9, "URP0509031H0"),
						   (10, "URP0509031H0");
DELETE FROM proveer WHERE IdProductoT=10;
UPDATE proveer SET RFCProveedorT="URP0509031H0" WHERE IdProductoT=8;

INSERT INTO empleado VALUES ("RERJ0305105H0", "José", "Reyes", "Rico"),
							("GUMJ0312255H7", "Juan", "Guerrero", "Medina"),
                            ("BEGL9303231H2", "Adolfo", "Bernal", "Guevara");
DELETE FROM empleado WHERE RFCEmpleado="GUMJ0312255H7";
UPDATE empleado SET nombreE="José Luis" WHERE RFCEmpleado="RERJ0305105H0";

INSERT INTO cliente VALUES ("DCVH6805018H9", "Hernesto", "De la Cruz", "Villa", "Hidalgo #248 Fracc. Miradores", "4495739563", "hernesto68@gmail.com"),
						   ("HED67432234H7", "Ramón", "Hernández", "Dávila", "Morelos #345 Fracc. Vistas", "4496793451", "ramon_76@gmail.com"),
                           ("DACB7305094H8", "Brandón", "Arenal", "Campos", "Héroes #410 Fracc. Villas", "4496486512", "arenal_campos73@gmail.com");
DELETE FROM cliente WHERE RFCCliente="HED67432234H7";
UPDATE cliente SET nombreCliente="Brandón Ismael", apellidoMC="Del Arenal" WHERE RFCCliente="DACB7305094H8";

INSERT INTO facturar VALUES ("RERJ0305105H0", "DCVH6805018H9", 3, 45, 21112023, 15),
                            ("BEGL9303231H2", "DACB7305094H8", 10, 90, 22112023, 6),
                            ("BEGL9303231H2", "DCVH6805018H9", 1, 21, 22112023, 7),
                            ("RERJ0305105H0", "DACB7305094H8", 4, 20, 23112023, 10),
                            ("BEGL9303231H2", "DACB7305094H8", 8, 11199, 24112023, 1);
DELETE FROM facturar WHERE RFCEmpleadoT="RERJ0305105H0" AND RFCClienteT="DCVH6805018H9" AND IdProductoT=3;
UPDATE facturar SET total=1199 WHERE RFCEmpleadoT="BEGL9303231H2" AND RFCClienteT="DACB7305094H8" AND IdProductoT=8;





SELECT * FROM producto ORDER BY precio DESC;
SELECT RFCProveedor, nombreP FROM proveedor ORDER BY nombreP ASC;

SELECT a.nombreE, b.nombreCliente, c.descripcion FROM empleado AS a, cliente AS b, producto AS c, facturar AS e 
		WHERE a.RFCEmpleado=e.RFCEmpleadoT AND b.RFCCliente=e.RFCClienteT AND c.IdProducto=e.IdProductoT;
SELECT b.nombreCliente FROM cliente AS b, facturar AS e WHERE b.RFCCliente=e.RFCClienteT AND e.total>1000;

SELECT nombreCliente, correo FROM cliente;
SELECT pr.RFCProveedor, pr.nombreP AS nombreProveedor, SUM(prod.existencias) AS totalExistencias FROM Proveer p
		JOIN Proveedor pr ON p.RFCProveedorT = pr.RFCProveedor JOIN Producto prod ON p.IdProductoT = prod.IdProducto
		GROUP BY pr.RFCProveedor HAVING totalExistencias > 100 ORDER BY totalExistencias DESC;

SELECT descripcion, precio FROM producto;
SELECT nombreE, apellidoPE FROM empleado;
SELECT nombreProd, descripcion FROM producto WHERE IdProducto=3;
SELECT * FROM cliente ORDER BY apellidoPC ASC;


SELECT f.RFCClienteT, c.nombreCliente, COUNT(*) AS cantidadCompras FROM Facturar as f, Cliente as c
		WHERE c.RFCCliente = f.RFCClienteT GROUP BY f.RFCClienteT HAVING cantidadCompras > 1;
        
SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, SUM(f.total) AS totalVentas
		FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
		GROUP BY F.RFCEmpleadoT HAVING totalVentas > 500 ORDER BY totalVentas DESC;
        
SELECT pr.RFCProveedor, pr.nombreP AS nombreProveedor, SUM(p.existencias) AS existenciasTotales
		FROM Proveer as pv, Proveedor as pr, Producto as p
		WHERE pv.RFCProveedorT = pr.RFCProveedor AND pv.IdProductoT = p.IdProducto
		GROUP BY pr.RFCProveedor HAVING existenciasTotales > 50 ORDER BY existenciasTotales ASC;

SELECT f.RFCClienteT, c.nombreCliente, SUM(f.numArticulos) AS totalArticulos
		FROM Facturar as f, Cliente as c WHERE f.RFCClienteT = c.RFCCliente
		GROUP BY f.RFCClienteT HAVING totalArticulos > 10 ORDER BY totalArticulos DESC;

SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, SUM(f.total) AS totalVentas
		FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
		GROUP BY f.RFCEmpleadoT HAVING totalVentas > 1000 ORDER BY totalVentas DESC;
        
SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, COUNT(*) AS cantidadTransacciones, SUM(f.total) AS totalVentas
		FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
		GROUP BY f.RFCEmpleadoT HAVING totalVentas < 1000 AND cantidadTransacciones < 3 ORDER BY totalVentas DESC;

SELECT f.RFCClienteT, c.nombreCliente, COUNT(*) AS cantidadCompras, SUM(f.numArticulos) AS totalArticulosComprados
		FROM Facturar as f, Cliente as c, Producto as p
		WHERE f.RFCClienteT = c.RFCCliente AND f.IdProductoT = p.IdProducto AND p.precio >= 15
		GROUP BY f.RFCClienteT HAVING totalArticulosComprados > 5 ORDER BY totalArticulosComprados DESC;
        
SELECT RFCProveedorT, COUNT(IdProductoT) AS CantidadProductos
		FROM Proveer GROUP BY RFCProveedorT;

SELECT b.RFCCliente, b.apellidoPC, c.nombreProd, e.total FROM cliente AS b, producto AS c, facturar AS e
		WHERE b.RFCCliente=e.RFCClienteT AND c.IdProducto=e.IdProductoT ORDER BY b.apellidoPC ASC;
        
SELECT RFCClienteT, SUM(total) AS TotalCompras FROM Facturar GROUP BY RFCClienteT;

SELECT a.RFCEmpleado, a.nombreE, e.numArticulos FROM empleado AS a, facturar AS e 
		WHERE a.RFCEmpleado=e.RFCEmpleadoT ORDER BY e.numArticulos ASC;

SELECT b.nombreCliente, b.apellidoPC, b.correo, e.numArticulos FROM cliente AS b, facturar AS e
		WHERE b.RFCCliente=e.RFCClienteT;
