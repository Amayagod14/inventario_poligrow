<?php
require '../db.php'; // Conectar a la base de datos
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
           c.serial, c.marca, c.dispositivo, c.fecha_entrega, c.fecha_compra, c.ram, c.mac, c.referencia
    FROM computadores c
    LEFT JOIN empleados e ON c.cedula = e.cedula
    WHERE c.serial = :serial
";
$stmt = $pdo->prepare($query);
$stmt->execute([':serial' => $serial]);
$computador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$computador) {
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

$section->addText("ACTA DE ENTREGA DE HERRAMIENTAS, EQUIPOS Y/O MATERIALES DE TRABAJO", 'titulo', 'centrado');
$section->addText("Fecha de entrega: " . date("d/m/Y"), 'normal');
$section->addTextBreak(1);

// Nueva sección para el compromiso
$section->addText("Yo, " . $computador['nombre'] . ", con cargo de " . $computador['cargo'] . ", me comprometo a hacer un uso adecuado del dispositivo entregado y a devolverlo en las condiciones en que fue recibido.", 'normal');

$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(3000)->addText("ITEM", 'subtitulo');
$table->addCell(7000)->addText("Descripción", 'subtitulo');

$table->addRow();
$table->addCell(3000)->addText("Marca:", 'normal');
$table->addCell(7000)->addText($computador['marca'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Dispositivo:", 'normal');
$table->addCell(7000)->addText($computador['dispositivo'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Serial:", 'normal');
$table->addCell(7000)->addText($computador['serial'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("RAM:", 'normal');
$table->addCell(7000)->addText($computador['ram'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("MAC:", 'normal');
$table->addCell(7000)->addText($computador['mac'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Referencia:", 'normal');
$table->addCell(7000)->addText($computador['referencia'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Fecha de compra:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($computador['fecha_compra'])), 'normal'); // Formatear fecha_compra

$table->addRow();
$table->addCell(3000)->addText("Fecha de entrega:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($computador['fecha_entrega'])), 'normal'); // Formatear fecha

$section->addTextBreak(1);
$section->addText("Condiciones Adicionales", 'subtitulo');
$condiciones = [
    "En caso de pérdida o daño por mal uso se descontará el valor total del equipo. El monto para descontar corresponderá al valor comercial de la herramienta en ese momento.",
    "En caso de cambio de cargo, funciones y/o terminación laboral del contrato con Poligrow Colombia SAS, las herramientas, equipos y/o materiales anteriormente mencionados pertenecen a la empresa y deberán ser devueltos al área de SISTEMAS.",
    "En caso de tratarse de equipos de cómputo y/o herramientas de trabajo, el responsable no podrá realizar ninguna modificación, instalación o eliminación del Software sin previa autorización por escrito del área de sistemas. El incumplimiento de lo anterior implicará la aplicación de las medidas disciplinarias establecidas en el Reglamento Interno de Trabajo.",
    "Los equipos se entregan en condiciones óptimas de uso y por lo tanto la devolución se realizará en la misma forma, teniendo en cuenta el desgaste normal por uso. Se anexa copia de la presente acta a su hoja de vida.",
    "En fe de lo anterior y con la firma del presente formato las partes deberán conocer y aceptar en su totalidad lo mencionado anteriormente en el acta."
];

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
$section->addText("Nombre: " . $computador['nombre'] . "\nCargo: " . $computador['cargo'], 'normal', ['alignment' => Jc::LEFT]);

$footer = $section->addFooter();
$footer->addImage('../img/pie.png', [
    'width' => 450,
    'height' => 60,
    'alignment' => Jc::CENTER
]);

$fileName = "Acta_Entrega_Computador_" . $computador['nombre'] . "_" . $computador['cedula'] . "_"  . ".docx";
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
