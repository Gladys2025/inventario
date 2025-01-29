<?php
// Conexión a la base de datos
include "modelo/conexion.php";
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los datos del inventario
$sql = "SELECT id_inventario, nombre_producto, descripcion, cantidad, precio FROM inventario";
$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/848656e037.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container col-8 p-4">
        <h2 class="mb-4">Reporte de Inventario</h2>
        <table class="table table-bordered">
            <thead class="table-info">
                <tr>
                    <th scope=col>ID</th>
                    <th scope=col>Nombre</th>
                    <th scope=col>Descripción</th>
                    <th scope=col>Cantidad</th>
                    <th scope=col>Precio</th>
                    <th scope=col></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_inventario']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?></td>
                        <td><?php echo $fila['descripcion']; ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td><?php echo $fila['precio']; ?></td>
                        <td>
                            <a href="" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="reporte.php" class="btn btn-primary">Ver Reporte</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>