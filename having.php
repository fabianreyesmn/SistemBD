<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <title>Consultas</title>
</head>
<body>
    <!-- Pestañas -->
    <ul class="nav nav-tabs menu">
        <li class="nav-item">
            <a class="nav-link" href="sencillas.php">Sencillas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="agrupadas.php">Campos agrupados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="multitablas.php">Multitabla</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="having.php">Having</a>
        </li>
    </ul>

    <!-- Form -->
    <form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="col-12">
            <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
            <select class="form-select elige" id="inlineFormSelectPref" name="opcion">
                <option value="0" selected>Elige...</option>
                <option value="1">Encontrar a los clientes que han realizado más de 1 compra</option>
                <option value="2">Obtener los proveedores cuyos productos tienen un total acumulado de existencias superior a 100</option>
                <option value="3">Encontrar a los empleados cuya suma total de ventas es superior a $500</option>
                <option value="4">Encontrar a los proveedores que suministran productos cuya existencia total es inferior a 50 unidades</option>
                <option value="5">Encontrar a los clientes que han realizado compras con una cantidad total de artículos superior a 10</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="submit">Consultar</button>
        </div>
    </form><br><br>

    <?php
        $servername = "localhost:3308";
        $username = "root";
        $password = "120803_Fr!";
        $dbname = "ferreteria";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $opcion = $_POST["opcion"];

            switch ($opcion) {
                case 1:
                    $sql = "SELECT f.RFCClienteT, c.nombreCliente, COUNT(*) AS cantidadCompras FROM Facturar as f, Cliente as c
                        WHERE c.RFCCliente = f.RFCClienteT GROUP BY f.RFCClienteT HAVING cantidadCompras > 1;";
                    break;
                case 2:
                    $sql = "SELECT pr.RFCProveedor, pr.nombreP AS nombreProveedor, SUM(prod.existencias) AS totalExistencias FROM Proveer p
                        JOIN Proveedor pr ON p.RFCProveedorT = pr.RFCProveedor JOIN Producto prod ON p.IdProductoT = prod.IdProducto
                        GROUP BY pr.RFCProveedor HAVING totalExistencias > 100 ORDER BY totalExistencias DESC;";
                    break;
                case 3:
                    $sql = "SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, SUM(f.total) AS totalVentas
                        FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
                        GROUP BY F.RFCEmpleadoT HAVING totalVentas > 500 ORDER BY totalVentas DESC;";
                    break;
                case 4:
                    $sql = "SELECT pr.RFCProveedor, pr.nombreP AS nombreProveedor, SUM(p.existencias) AS existenciasTotales
                        FROM Proveer as pv, Proveedor as pr, Producto as p
                        WHERE pv.RFCProveedorT = pr.RFCProveedor AND pv.IdProductoT = p.IdProducto
                        GROUP BY pr.RFCProveedor HAVING existenciasTotales > 50 ORDER BY existenciasTotales ASC;";
                    break;
                case 5:
                    $sql = "SELECT f.RFCClienteT, c.nombreCliente, SUM(f.numArticulos) AS totalArticulos
                        FROM Facturar as f, Cliente as c WHERE f.RFCClienteT = c.RFCCliente
                        GROUP BY f.RFCClienteT HAVING totalArticulos > 10 ORDER BY totalArticulos DESC;";
                    break;
                default:
                    $sql = "SELECT * FROM facturar";
                    break;
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-hover'>";
        
                echo "<tr>";
                $fieldinfo = $result->fetch_fields();
                foreach ($fieldinfo as $field) {
                    echo "<th>" . $field->name . "</th>";
                }
                echo "</tr>";
        
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron resultados.";
            }
            echo "<br><br>";
        }

        $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>