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
            <a class="nav-link active" aria-current="page" href="sencillas.php">Consultas Sencillas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="agrupadas.php">Consultas con Campos agrupados</a>
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
                <option value="1">Mostrar todos los productos ordenados por precio de mayor a menor</option>
                <option value="2">Mostrar el RFC, y el nombre por orden alfabético de los proveedores</option>
                <option value="3">Mostrar a los empleados por su nombre y apellido paterno</option>
                <option value="4">Mostrar el nombre y correo de los clientes</option>
                <option value="5">Mostrar todos los productos con su descripción y el precio</option>
                <option value="6">Mostrar el nombre y descripción del producto con Id=3</option>
                <option value="7">Mostrar los datos de los clientes por orden alfabético del apellido paterno</option>
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
                    $sql = "SELECT * FROM producto ORDER BY precio DESC;";
                    break;
                case 2:
                    $sql = "SELECT RFCProveedor, nombreP FROM proveedor ORDER BY nombreP ASC;";
                    break;
                case 3:
                    $sql = "SELECT nombreE, apellidoPE FROM empleado;";
                    break;
                case 4:
                    $sql = "SELECT nombreCliente, correo FROM cliente;";
                    break;
                case 5:
                    $sql = "SELECT descripcion, precio FROM producto;";
                    break;
                case 6:
                    $sql = "SELECT nombreProd, descripcion FROM producto WHERE IdProducto=3;";
                    break;
                case 7:
                    $sql = "SELECT * FROM cliente ORDER BY apellidoPC ASC;";
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