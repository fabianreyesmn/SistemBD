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
            <a class="nav-link" href="index.php">Altas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="bajas.php">Bajas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cambios.php">Cambios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="sencillas.php">Consultas Sencillas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="agrupadas.php">Consultas con Campos agrupados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="multitablas.php">Consultas Multitabla</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="having.php">Consultas con Having</a>
        </li>
    </ul>

    <!-- Form -->
    <form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="col-12">
            <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
            <select class="form-select elige" id="inlineFormSelectPref" name="opcion">
                <option value="0" selected>Elige...</option>
                <option value="1">Encontrar a los empleados que han realizado ventas por un total superior a $1000</option>
                <option value="2">Encontrar a los empleados que han realizado ventas por un total inferior a $1000 y han realizado más de 2 transacciones</option>
                <option value="3">Encontrar a los clientes que han realizado compras de productos con un precio mayor o igual a $15 y con una cantidad total de artículos superior a 5</option>
                <option value="4">Obtener la cantidad total de productos por proveedor</option>
                <option value="5">Obtener el total de compras realizadas por cada cliente</option>
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
                    $sql = "SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, SUM(f.total) AS totalVentas
                        FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
                        GROUP BY f.RFCEmpleadoT HAVING totalVentas > 1000 ORDER BY totalVentas DESC;";
                    break;
                case 2:
                    $sql = "SELECT f.RFCEmpleadoT, e.nombreE AS nombreEmpleado, COUNT(*) AS cantidadTransacciones, SUM(f.total) AS totalVentas
                        FROM Facturar as f, Empleado as e WHERE f.RFCEmpleadoT = e.RFCEmpleado
                        GROUP BY f.RFCEmpleadoT HAVING totalVentas < 1000 AND cantidadTransacciones < 3 ORDER BY totalVentas DESC;";
                    break;
                case 3:
                    $sql = "SELECT f.RFCClienteT, c.nombreCliente, COUNT(*) AS cantidadCompras, SUM(f.numArticulos) AS totalArticulosComprados
                        FROM Facturar as f, Cliente as c, Producto as p
                        WHERE f.RFCClienteT = c.RFCCliente AND f.IdProductoT = p.IdProducto AND p.precio >= 15
                        GROUP BY f.RFCClienteT HAVING totalArticulosComprados > 5 ORDER BY totalArticulosComprados DESC;";
                    break;
                case 4:
                    $sql = "SELECT RFCProveedorT, COUNT(IdProductoT) AS CantidadProductos
                        FROM Proveer GROUP BY RFCProveedorT;";
                    break;
                case 5:
                    $sql = "SELECT RFCClienteT, SUM(total) AS TotalCompras FROM Facturar GROUP BY RFCClienteT;";
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