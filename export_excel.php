<?php
require 'vendor/autoload.php';
include 'modelo/conexion.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT id_inventario, nombre_producto, descripcion, cantidad, precio FROM inventario";
$resultado = $conexion->query($sql);

// Crear un nuevo documento Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Descripción');
$sheet->setCellValue('D1', 'Cantidad');
$sheet->setCellValue('E1', 'Precio');

$fila = 2;
while ($row = $resultado->fetch_assoc()) {
    $sheet->setCellValue('A' . $fila, $row['id_inventario']);
    $sheet->setCellValue('B' . $fila, $row['nombre_producto']);
    $sheet->setCellValue('C' . $fila, $row['descripcion']);
    $sheet->setCellValue('D' . $fila, $row['cantidad']);
    $sheet->setCellValue('E' . $fila, $row['precio']);
    $fila++;
}

// Configurar el archivo para descargar
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="reporte_inventario.xlsx"');
$writer->save('php://output');
exit();
?>
