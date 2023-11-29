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
            <a class="nav-link" href="agrupadas.php">Consultas con Campos agrupados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="multitablas.php">Consultas Multitabla</a>
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
                <option value="1">Mostrar el nombre del empleado, el nombre del cliente y la descripción del producto de las facturas</option>
                <option value="2">Mostrar el RFC del Cliente, apellido paterno del cliente en orden alfabético, nombre del producto, y total de la factura</option>
                <option value="3">Mostrar el RFC y nombre de los empleados, con el número de artículos que han vendido en cada factura</option>
                <option value="4">Mostrar el nombre, apellido paterno, y correo del cliente, junto con el total de artículos que compró</option>
                <option value="5">Mostrar los clientes que han facturado mayor a $1,000</option>
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
                    $sql = "SELECT a.nombreE, b.nombreCliente, c.descripcion FROM empleado AS a, cliente AS b, producto AS c, facturar AS e 
                        WHERE a.RFCEmpleado=e.RFCEmpleadoT AND b.RFCCliente=e.RFCClienteT AND c.IdProducto=e.IdProductoT;";
                    break;
                case 2:
                    $sql = "SELECT b.RFCCliente, b.apellidoPC, c.nombreProd, e.total FROM cliente AS b, producto AS c, facturar AS e
                        WHERE b.RFCCliente=e.RFCClienteT AND c.IdProducto=e.IdProductoT ORDER BY b.apellidoPC ASC;";
                    break;
                case 3:
                    $sql = "SELECT a.RFCEmpleado, a.nombreE, e.numArticulos FROM empleado AS a, facturar AS e 
                        WHERE a.RFCEmpleado=e.RFCEmpleadoT ORDER BY e.numArticulos ASC;";
                    break;
                case 4:
                    $sql = "SELECT b.nombreCliente, b.apellidoPC, b.correo, e.numArticulos FROM cliente AS b, facturar AS e
                        WHERE b.RFCCliente=e.RFCClienteT;";
                    break;
                case 5:
                    $sql = "SELECT b.nombreCliente FROM cliente AS b, facturar AS e WHERE b.RFCCliente=e.RFCClienteT AND e.total>1000;";
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