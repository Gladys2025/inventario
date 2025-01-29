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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Reporte de Inventario</h2>
        
        <!-- Filtros -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="nombre_producto" class="form-control" placeholder="Buscar por nombre">
                </div>
                <div class="col-md-2">
                    <input type="number" name="cantidad" class="form-control" placeholder="Cantidad mínima">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="precio_min" class="form-control" placeholder="Precio mínimo">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="precio_max" class="form-control" placeholder="Precio máximo">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>
        
        <!-- Tabla de inventario -->
        <table class="table table-bordered">
            <thead class="table-info">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
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
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Botones para exportar -->
        <div class="mt-3">
            <a href="export_excel.php" class="btn btn-success">Exportar a Excel</a>
            <a href="export_pdf.php" class="btn btn-danger">Exportar a PDF</a>
        </div>
    </div>
</body>
</html>