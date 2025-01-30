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

// Crear el contenido HTML del PDF
$html = '<h2>Reporte de Inventario</h2>';
$html .= '<table border="1" width="100%" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>';

foreach ($data as $row) {
    $html .= '<tr>
                <td>' . $row['id_inventario'] . '</td>
                <td>' . htmlspecialchars($row['nombre_producto']) . '</td>
                <td>' . htmlspecialchars($row['descripcion']) . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>' . $row['precio'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

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