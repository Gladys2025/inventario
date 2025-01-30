<?php
require 'vendor/autoload.php';
include 'modelo/conexion.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Inicializar variables de filtro
$nombre_producto = isset($_GET['nombre_producto']) ? trim($_GET['nombre_producto']) : '';
$cantidad = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
$precio_min = isset($_GET['precio_min']) ? floatval($_GET['precio_min']) : 0;
$precio_max = isset($_GET['precio_max']) ? floatval($_GET['precio_max']) : 0;

// Construir la consulta con filtros
$sql = "SELECT id_inventario, nombre_producto, descripcion, cantidad, precio FROM inventario WHERE 1=1";
if (!empty($nombre_producto)) {
    $sql .= " AND nombre_producto LIKE '%$nombre_producto%'";
}
if ($cantidad > 0) {
    $sql .= " AND cantidad >= $cantidad";
}
if ($precio_min > 0) {
    $sql .= " AND precio >= $precio_min";
}
if ($precio_max > 0) {
    $sql .= " AND precio <= $precio_max";
}

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
                    <input type="text" name="nombre_producto" class="form-control" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($nombre_producto); ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="cantidad" class="form-control" placeholder="Cantidad mínima" value="<?php echo $cantidad; ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="precio_min" class="form-control" placeholder="Precio mínimo" value="<?php echo $precio_min; ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="precio_max" class="form-control" placeholder="Precio máximo" value="<?php echo $precio_max; ?>">
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
                <?php $data = [];
                while ($fila = $resultado->fetch_assoc()): 
                    $data[] = $fila; ?>
                    <tr>
                        <td><?php echo $fila['id_inventario']; ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre_producto']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td><?php echo $fila['precio']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Botones para exportar -->
        <div class="mt-3">
            <a href="export_excel.php?data=<?php echo urlencode(json_encode($data)); ?>" class="btn btn-success">Exportar a Excel</a>
            <a href="export_pdf.php?data=<?php echo urlencode(json_encode($data)); ?>" class="btn btn-danger">Exportar a PDF</a>
        </div>
    </div>
</body>
</html>
