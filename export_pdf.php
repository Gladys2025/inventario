<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['data'])) {
    die("No hay datos para exportar.");
}

// Decodificar los datos JSON
$data = json_decode(urldecode($_GET['data']), true);
if (!$data) {
    die("Error al procesar los datos.");
}

// Cargar la plantilla HTML
$template = file_get_contents('modelo/plantilla.html');

// Generar las filas de la tabla dinámicamente
$dataRows = '';
foreach ($data as $row) {
    $dataRows .= '<tr>
                    <td>' . $row['id_inventario'] . '</td>
                    <td>' . htmlspecialchars($row['nombre_producto']) . '</td>
                    <td>' . htmlspecialchars($row['descripcion']) . '</td>
                    <td>' . $row['cantidad'] . '</td>
                    <td>' . $row['precio'] . '</td>
                  </tr>';
}

// Reemplazar el marcador {{DATA_ROWS}} por las filas generadas
$html = str_replace('{{DATA_ROWS}}', $dataRows, $template);

// Configurar Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Descargar el archivo PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reporte_inventario.pdf"');
echo $dompdf->output();
exit();
?>
