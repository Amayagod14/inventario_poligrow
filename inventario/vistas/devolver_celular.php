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
           c.serial, c.imei, c.marca, c.modelo, c.fecha_entrega, c.fecha_compra
    FROM celulares c
    LEFT JOIN empleados e ON c.cedula = e.cedula
    WHERE c.serial = :serial
";
$stmt = $pdo->prepare($query);
$stmt->execute([':serial' => $serial]);
$celular = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$celular) {
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

$section->addText("ACTA DE DEVOLUCION DE HERRAMIENTAS, EQUIPOS Y/O MATERIALES DE TRABAJO", 'titulo', 'centrado');
$section->addText("FECHA DE DEVOLUCION: " . date("d/m/Y"), 'normal', );
$section->addTextBreak(1);

$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(3000)->addText("ITEM", 'subtitulo');
$table->addCell(7000)->addText("Descripción", 'subtitulo');

$table->addRow();
$table->addCell(3000)->addText("Marca:", 'normal');
$table->addCell(7000)->addText($celular['marca'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Modelo:", 'normal');
$table->addCell(7000)->addText($celular['modelo'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Serial:", 'normal');
$table->addCell(7000)->addText($celular['serial'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("IMEI:", 'normal');
$table->addCell(7000)->addText($celular['imei'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Fecha de compra:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($celular['fecha_compra'])), 'normal'); // Formatear fecha_compra

$table->addRow();
$table->addCell(3000)->addText("Fecha de entrega:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($celular['fecha_entrega'])), 'normal'); // Formatear fecha

$section->addTextBreak(1);

foreach ($condiciones as $condicion) {
    $section->addText("->  " . $condicion, 'normal');
}

$section->addTextBreak(1);
$section->addText("Se firma en la ciudad de Mapiripán el día " . date("d/m/Y") . " en dos ejemplares del mismo tenor.", 'normal', 'centrado');
$section->addTextBreak(2);

$section->addText("RECIBE- RESPONSABLE:", 'subtitulo', ['alignment' => Jc::LEFT]);
$section->addTextBreak(1);
$section->addText("_________________________________", 'normal', ['alignment' => Jc::LEFT]);
$section->addText("Nombre: MAURICIO DEVIA\nDEPARTAMENTO DE SISTEMAS", 'normal', ['alignment' => Jc::LEFT]);

$section->addTextBreak(2);

$section->addText("ENTREGA:", 'subtitulo', ['alignment' => Jc::LEFT]);
$section->addTextBreak(1);
$section->addText("_________________________________", 'normal', ['alignment' => Jc::LEFT]);
$section->addText("Nombre: " . $celular['nombre'] . "\nCargo: " . $celular['cargo'], 'normal', ['alignment' => Jc::LEFT]);

$footer = $section->addFooter();
$footer->addImage('../img/pie.png', [
    'width' => 450,
    'height' => 60,
    'alignment' => Jc::CENTER
]);

$fileName = "Acta_Devolucion_Celular_" . $celular['nombre'] . "_" . $celular['cedula'] . "_"  . ".docx";
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