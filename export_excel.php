<?php
require 'vendor/autoload.php';
include 'modelo/conexion.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Cargar la plantilla de Excel
$spreadsheet = IOFactory::load('modelo/plantilla.xlsx');
$sheet = $spreadsheet->getActiveSheet();

// Obtener datos
$data = json_decode(urldecode($_GET['data']), true);
$fila = 7; // La fila donde inician los datos

foreach ($data as $row) {
    $sheet->setCellValue('B' . $fila, $row['id_inventario']);
    $sheet->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->mergeCells('C' . $fila . ':D' . $fila);
    $sheet->getStyle('C' . $fila . ':D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->setCellValue('C' . $fila, $row['nombre_producto']);
    $sheet->mergeCells('E' . $fila . ':F' . $fila);
    $sheet->getStyle('E' . $fila . ':F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->setCellValue('E' . $fila, $row['descripcion']);
    $sheet->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->setCellValue('G' . $fila, $row['cantidad']);
    $sheet->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->setCellValue('H' . $fila, $row['precio']);
    $fila++;
}

// Configurar encabezados para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_inventario.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();

?>
