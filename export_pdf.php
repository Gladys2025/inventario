<?php
require('fpdf/fpdf.php');
include "modelo/conexion.php";
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT id_inventario, nombre_producto, descripcion, cantidad, precio FROM inventario";
$resultado = $conexion->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'ID', 1);
$pdf->Cell(50, 10, 'Nombre', 1);
$pdf->Cell(60, 10, 'Descripcion', 1);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(20, 10, 'Precio', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, $fila['id_inventario'], 1);
    $pdf->Cell(50, 10, $fila['nombre_producto'], 1);
    $pdf->Cell(60, 10, $fila['descripcion'], 1);
    $pdf->Cell(20, 10, $fila['cantidad'], 1);
    $pdf->Cell(20, 10, $fila['precio'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_inventario.pdf');
?>
