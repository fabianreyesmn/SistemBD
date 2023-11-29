<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <title>Altas</title>
</head>
<body>
    <!-- Pestañas -->
    <ul class="nav nav-tabs menu">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Altas</a>
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
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Producto</legend><br><br>

                        <label for="input-id">ID</label>
                        <input type="number" class="input-id" name="IdProducto" required> <br><br>

                        <label for="input-nombre">Nombre</label>
                        <input type="text" class="input-nombre" name="nombreProd" required> <br><br>

                        <label for="input-descripcion">Descripción</label>
                        <input type="text" class="input-descripcion" name="descripcion" required> <br><br>

                        <label for="input-precio">Precio</label>
                        <input type="number" class="input-precio" name="precio" required> <br><br>

                        <label for="input-existencias">Existencias</label>
                        <input type="number" class="input-existencias" name="existencias" required> <br><br>

                        <input type="hidden" name="tabla" value="producto">
                        <button type="submit" name="submit">Dar de Alta</button><br><br><br>
                    <?php
                    break;
                case 2: //Proveedor
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Proveedor</legend><br><br>

                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCProveedor" required> <br><br>

                        <label for="input-nombre">Nombre</label>
                        <input type="text" class="input-nombre" name="nombreP" required> <br><br>

                        <label for="input-apellidoPaterno">Apellido Paterno</label>
                        <input type="text" class="input-apellidoPaterno" name="apellidoPP" required> <br><br>

                        <label for="input-apellidoMaterno">Apellido Materno</label>
                        <input type="text" class="input-apellidoMaterno" name="apellidoMP" required> <br><br>

                        <input type="hidden" name="tabla" value="proveedor">
                        <button type="submit" name="submit">Dar de Alta</button>
                    <?php
                    break;
                case 3: //Proveer
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Proveer</legend><br><br>

                        <label for="input-idProducto">ID del Producto</label>
                        <input type="number" class="input-idProducto" name="IdProductoT" required> <br><br>

                        <label for="input-rfcProveedor">RFC del Proveedor</label>
                        <input type="text" class="input-rfcProveedor" name="RFCProveedorT" required> <br><br>

                        <input type="hidden" name="tabla" value="proveer">
                        <button type="submit" name="submit">Dar de Alta</button>
                    <?php 
                    break;
                case 4: //Empleado
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Empleado</legend><br><br>
                        
                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCEmpleado" required> <br><br>

                        <label for="input-nombre">Nombre</label>
                        <input type="text" class="input-nombre" name="nombreE" required> <br><br>

                        <label for="input-apellidoPaterno">Apellido Paterno</label>
                        <input type="text" class="input-apellidoPaterno" name="apellidoPE" required> <br><br>

                        <label for="input-apellidoMaterno">Apellido Materno</label>
                        <input type="text" class="input-apellidoMaterno" name="apellidoME" required> <br><br>

                        <input type="hidden" name="tabla" value="empleado">
                        <button type="submit" name="submit">Dar de Alta</button>
                    <?php 
                    break;
                case 5: //Cliente
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Cliente</legend><br><br>

                        <label for="input-rfc">RFC</label>
                        <input type="text" class="input-rfc" name="RFCCliente" required> <br><br>

                        <label for="input-nombre">Nombre</label>
                        <input type="text" class="input-nombre" name="nombreCliente" required> <br><br>

                        <label for="input-apellidoPaterno">Apellido Paterno</label>
                        <input type="text" class="input-apellidoPaterno" name="apellidoPC" required> <br><br>

                        <label for="input-apellidoMaterno">Apellido Materno</label>
                        <input type="text" class="input-apellidoMaterno" name="apellidoMC" required> <br><br>

                        <label for="input-direccion">Dirección</label>
                        <input type="text" class="input-direccion" name="direccion" required> <br><br>

                        <label for="input-telefono">Teléfono</label>
                        <input type="number" class="input-telefono" name="telefono" required> <br><br>

                        <label for="input-correo">Correo</label>
                        <input type="email" class="input-correo" name="correo" required> <br><br>

                        <input type="hidden" name="tabla" value="cliente">
                        <button type="submit" name="submit">Dar de Alta</button><br><br><br>
                    <?php 
                    break;
                case 6: //Facturar
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <legend>Facturar</legend><br><br>

                        <label for="input-rfcEmpleado">RFC del Empleado</label>
                        <input type="text" class="input-rfcEmpleado" name="RFCEmpleadoT" required> <br><br>

                        <label for="input-rfcCliente">RFC del Cliente</label>
                        <input type="text" class="input-rfcCliente" name="RFCClienteT" required> <br><br>

                        <label for="input-idProducto">ID del Producto</label>
                        <input type="number" class="input-idProducto" name="IdProductoT" required> <br><br>

                        <label for="input-total">Total</label>
                        <input type="number" class="input-total" name="total" required> <br><br>

                        <label for="input-fecha">Fecha</label>
                        <input type="number" class="input-fecha" name="fecha" required> <br><br>

                        <label for="input-numeroArticulos">Número de Artículos</label>
                        <input type="number" class="input-numeroArticulos" name="numArticulos" required> <br><br>

                        <input type="hidden" name="tabla" value="facturar">
                        <button type="submit" name="submit">Dar de Alta</button><br><br><br>
                    <?php 
                    break;
                default:
                    break;
            }
        }

        //Dar de Alta
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $tabla = $_POST["tabla"];

            switch ($tabla) {
                case 'producto':
                    $IdProducto = $_POST["IdProducto"];
                    $nombreProd = $_POST["nombreProd"];
                    $descripcion = $_POST["descripcion"];
                    $precio = $_POST["precio"];
                    $existencias = $_POST["existencias"];
                    $sql = "INSERT INTO $tabla (IdProducto, nombreProd, descripcion, precio, existencias) VALUES ('$IdProducto', '$nombreProd', '$descripcion', '$precio', '$existencias');";             
                    break;
                case 'proveedor':
                    $RFCProveedor = $_POST["RFCProveedor"];
                    $nombreP = $_POST["nombreP"];
                    $apellidoPP = $_POST["nombrePP"];
                    $apellidoMP = $_POST["nombreMP"];
                    $sql = "INSERT INTO $tabla (RFCProveedor, nombreP, apellidoPP, apellidoMP) VALUES ('$RFCProveedor', '$nombreP', '$apellidoPP', '$apellidoMP');";
                    break;
                case 'proveer':
                    $IdProductoT = $_POST["IdProductoT"];
                    $RFCProveedorT = $_POST["RFCProveedorT"];
                    $sql = "INSERT INTO $tabla (IdProductoT, RFCProveedorT) VALUES ('$IdProductoT', '$RFCProveedorT');";
                    break;
                case 'empleado':
                    $RFCEmpleado = $_POST["RFCEmpleado"];
                    $nombreE = $_POST["nombreE"];
                    $apellidoPE = $_POST["apellidoPE"];
                    $apellidoME = $_POST["apellidoME"];
                    $sql = "INSERT INTO $tabla (RFCEmpleado, nombreE, apellidoPE, apellidoME) VALUES ('$RFCEmpleado', '$nombreE', '$apellidoPE', '$apellidoME');";
                    break;
                case 'cliente':
                    $RFCCliente = $_POST["RFCCliente"];
                    $nombreCliente = $_POST["nombreCliente"];
                    $apellidoPC = $_POST["apellidoPC"];
                    $apellidoMC = $_POST["apellidoMC"];
                    $direccion = $_POST["direccion"];
                    $telefono = $_POST["telefono"];
                    $correo = $_POST["correo"];
                    $sql = "INSERT INTO $tabla (RFCCliente, nombreCliente, apellidoPC, apellidoMC, direccion, telefono, correo) VALUES ('$RFCCliente', '$nombreCliente', '$apellidoPC', '$apellidoMC', '$direccion', '$telefono', '$correo');";
                    break;
                case 'facturar':
                    $RFCEmpleadoT = $_POST["RFCEmpleadoT"];
                    $RFCClienteT = $_POST["RFCClienteT"];
                    $IdProductoT = $_POST["IdProductoT"];
                    $total = $_POST["total"];
                    $fecha = $_POST["fecha"];
                    $numArticulos = $_POST["numArticulos"];
                    $sql = "INSERT INTO $tabla (RFCEmpleadoT, RFCClienteT, IdProductoT, total, fecha, numArticulos) VALUES ('$RFCEmpleadoT', '$RFCClienteT', '$IdProductoT', '$total', '$fecha', '$numArticulos');";
                    break;
                default:
                    echo "Error Fatal";
                    break;
            }

            $result = $conn->query($sql);

            if ($conn->affected_rows >= 1) {
                echo "<script>alert('Dado de Alta');</script>";
            } 
            else {
                echo "<script>alert('No se pudo dar de alta');</script>";
            }
        }

        //$conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>