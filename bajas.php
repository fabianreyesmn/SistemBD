<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <title>Bajas</title>
</head>
<body>
    <!-- Pestañas -->
    <ul class="nav nav-tabs menu">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Altas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="bajas.php">Bajas</a>
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
            <select class="form-select elige" id="inlineFormSelectPref" name="opcion" onchange="this.form.submit()">>
                <option value="0" selected>Elige...</option>
                <option value="1">Producto</option>
                <option value="2">Proveedor</option>
                <option value="3">Proveer</option>
                <option value="4">Empleado</option>
                <option value="5">Cliente</option>
                <option value="6">Facturar</option>
            </select>
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

        //Mostrar los Formularios
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["opcion"])) {
            $opcion = $_POST["opcion"];

            switch ($opcion) {
                case 1: //Producto
                    $sql = "SELECT * FROM producto;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Producto</legend><br><br>

                        <label for="input-id">ID</label>
                        <input type="number" class="input-id" name="IdProducto" required> <br><br>

                        <input type="hidden" name="tabla" value="producto">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                case 2: //Proveedor
                    $sql = "SELECT * FROM proveedor;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Proveedor</legend><br><br>

                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCProveedor" required> <br><br>

                        <input type="hidden" name="tabla" value="proveedor">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                case 3: //Proveer
                    $sql = "SELECT * FROM proveer;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Proveer</legend><br><br>

                        <label for="input-idProducto">ID del Producto</label>
                        <input type="number" class="input-idProducto" name="IdProductoT" required> <br><br>

                        <label for="input-rfcProveedor">RFC del Proveedor</label>
                        <input type="text" class="input-rfcProveedor" name="RFCProveedorT" required> <br><br>

                        <input type="hidden" name="tabla" value="proveer">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                case 4: //Empleado
                    $sql = "SELECT * FROM empleado;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Empleado</legend><br><br>

                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCEmpleado" required> <br><br>

                        <input type="hidden" name="tabla" value="empleado">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                case 5: //Cliente
                    $sql = "SELECT * FROM cliente;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Cliente</legend><br><br>

                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCCliente" required> <br><br>

                        <input type="hidden" name="tabla" value="cliente">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                case 6: //Facturar
                    $sql = "SELECT * FROM facturar;";
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Facturar</legend><br><br>

                        <label for="input-rfcEmpleado">RFC del Empleado</label>
                        <input type="text" class="input-rfcEmpleado" name="RFCEmpleadoT" required> <br><br>

                        <label for="input-rfcCliente">RFC del Cliente</label>
                        <input type="text" class="input-rfcCliente" name="RFCClienteT" required> <br><br>

                        <label for="input-idProducto">ID del Producto</label>
                        <input type="text" class="input-idProducto" name="IdProductoT" required> <br><br>

                        <input type="hidden" name="tabla" value="facturar">
                        <button type="submit" name="submit">Dar de Baja</button><br><br>
                    </form>
                    <?php
                    break;
                default:
                    echo "Error Fatal";
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

        //Dar de Baja
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $tabla = $_POST["tabla"];

            switch ($tabla) {
                case 'producto':
                    $IdProducto = $_POST["IdProducto"];
                    $sql = "DELETE FROM $tabla WHERE IdProducto='$IdProducto';";
                    break;
                case 'proveedor':
                    $RFCProveedor = $_POST["RFCProveedor"];
                    $sql = "DELETE FROM $tabla WHERE RFCProveedor='$RFCProveedor';";
                    break;
                case 'proveer':
                    $IdProductoT = $_POST["IdProductoT"];
                    $RFCProveedorT = $_POST["RFCProveedorT"];
                    $sql = "DELETE FROM $tabla WHERE IdProductoT='$IdProductoT' AND RFCProveedorT='$RFCProveedorT';";
                    break;
                case 'empleado':
                    $RFCEmpleado = $_POST["RFCEmpleado"];
                    $sql = "DELETE FROM $tabla WHERE RFCEmpleado='$RFCEmpleado';";
                    break;
                case 'cliente':
                    $RFCCliente = $_POST["RFCCliente"];
                    $sql = "DELETE FROM $tabla WHERE RFCCliente='$RFCCliente';";
                    break;
                case 'facturar':
                    $RFCEmpleadoT = $_POST["RFCEmpleadoT"];
                    $RFCClienteT = $_POST["RFCClienteT"];
                    $IdProductoT = $_POST["IdProductoT"];
                    $sql = "DELETE FROM $tabla WHERE RFCEmpleadoT='$RFCEmpleadoT' AND RFCClienteT='$RFCClienteT' AND IdProductoT='$IdProductoT';";
                    break;
                default:
                    echo "Error Fatal";
                    break;
            }

            $result = $conn->query($sql);

            if ($conn->affected_rows >= 1) {
                echo "<script>alert('Dado de Baja');</script>";
            } 
            else {
                echo "<script>alert('No se pudo dar de baja');</script>";
            }
        }

        //$conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>