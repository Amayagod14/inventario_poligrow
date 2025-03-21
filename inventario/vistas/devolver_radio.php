<?php
require '../db.php';
require '../PHPWord/src/PhpWord/Autoloader.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

\PhpOffice\PhpWord\Autoloader::register();

if (!isset($_GET['serial'])) {
    die("Error: No se ha proporcionado el serial del dispositivo.");
}

$serial = $_GET['serial'];

$query = "
    SELECT e.cedula, e.nombre, e.cargo, e.area, e.sub_area, 
           r.serial, r.marca, r.placa_activos_fijos, r.dispositivo, r.referencia, r.estado_entrega, r.fecha_entrega, r.fecha_compra, r.observaciones
    FROM radios r
    LEFT JOIN empleados e ON r.cedula = e.cedula
    WHERE r.serial = :serial
";
$stmt = $pdo->prepare($query);
$stmt->execute([':serial' => $serial]);
$radio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$radio) {
    die("Error: No se encontraron datos para el serial proporcionado.");
}

$phpWord = new PhpWord();
$section = $phpWord->addSection();

$phpWord->addFontStyle('titulo', ['bold' => true, 'size' => 16, 'name' => 'Arial']);
$phpWord->addFontStyle('subtitulo', ['bold' => true, 'size' => 12, 'name' => 'Arial']);
$phpWord->addFontStyle('normal', ['size' => 11, 'name' => 'Arial']);
$phpWord->addParagraphStyle('centrado', ['alignment' => Jc::CENTER]);
$phpWord->addTableStyle('EstiloTabla', [
    'borderSize' => 6, 
    'borderColor' => '0070C0',
    'cellMargin' => 80,
]);

$header = $section->addHeader();
$header->addImage('../img/encabezado.png', [
    'width' => 450,
    'height' => 40,
    'alignment' => Jc::CENTER
]);

$section->addText("ACTA DE DEVOLUCIÓN DE HERRAMIENTAS, EQUIPOS Y/O MATERIALES DE TRABAJO", 'titulo', 'centrado');
$section->addText("Fecha de devolución: " . date("d/m/Y"), 'normal');
$section->addTextBreak(1);

$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(3000)->addText("ITEM", 'subtitulo');
$table->addCell(7000)->addText("Descripción", 'subtitulo');

$table->addRow();
$table->addCell(3000)->addText("Marca:", 'normal');
$table->addCell(7000)->addText($radio['marca'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Dispositivo:", 'normal');
$table->addCell(7000)->addText($radio['dispositivo'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Serial:", 'normal');
$table->addCell(7000)->addText($radio['serial'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Placa Activos Fijos:", 'normal');
$table->addCell(7000)->addText($radio['placa_activos_fijos'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Referencia:", 'normal');
$table->addCell(7000)->addText($radio['referencia'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Estado de Entrega:", 'normal');
$table->addCell(7000)->addText($radio['estado_entrega'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Fecha de compra:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($radio['fecha_compra'])), 'normal');

$table->addRow();
$table->addCell(3000)->addText("Fecha de devolución:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($radio['fecha_entrega'])), 'normal');

$section->addTextBreak(1);

foreach ($condiciones as $condicion) {
    $section->addText("->  " . $condicion, 'normal');
}

$section->addTextBreak(1);
$section->addText("Se firma en la ciudad de Mapiripán el día " . date("d/m/Y") . " en dos ejemplares del mismo tenor.", 'normal', 'centrado');
$section->addTextBreak(2);

$section->addText("ENTREGA:", 'subtitulo', ['alignment' => Jc::LEFT]);
$section->addTextBreak(1);
$section->addText("_________________________________", 'normal', ['alignment' => Jc::LEFT]);
$section->addText("Nombre: MAURICIO DEVIA\nDEPARTAMENTO DE SISTEMAS", 'normal', ['alignment' => Jc::LEFT]);

$section->addTextBreak(2);

$section->addText("RECIBE- RESPONSABLE:", 'subtitulo', ['alignment' => Jc::LEFT]);
$section->addTextBreak(1);
$section->addText("_________________________________", 'normal', ['alignment' => Jc::LEFT]);
$section->addText("Nombre: " . $radio['nombre'] . "\nCargo: " . $radio['cargo'], 'normal', ['alignment' => Jc::LEFT]);

$footer = $section->addFooter();
$footer->addImage('../img/pie.png', [
    'width' => 450,
    'height' => 60,
    'alignment' => Jc::CENTER
]);

$fileName = "Acta_Devolucion_Radio_" . $radio['nombre'] . "_" . $radio['cedula'] . "_" . ".docx";
$path = "../actas/" . $fileName;
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($path);

header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Length: " . filesize($path));
readfile($path);

unlink($path);
exit;
?>
