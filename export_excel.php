<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_GET['data'])) {
    die("No hay datos para exportar.");
}

// Decodificar los datos JSON
$data = json_decode(urldecode($_GET['data']), true);
if (!$data) {
    die("Error al procesar los datos.");
}

// Crear un nuevo documento Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Descripción');
$sheet->setCellValue('D1', 'Cantidad');
$sheet->setCellValue('E1', 'Precio');

// Llenar los datos
$fila = 2;
foreach ($data as $row) {
    $sheet->setCellValue('A' . $fila, $row['id_inventario']);
    $sheet->setCellValue('B' . $fila, $row['nombre_producto']);
    $sheet->setCellValue('C' . $fila, $row['descripcion']);
    $sheet->setCellValue('D' . $fila, $row['cantidad']);
    $sheet->setCellValue('E' . $fila, $row['precio']);
    $fila++;
}

// Configurar el archivo para descargar
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_inventario.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
