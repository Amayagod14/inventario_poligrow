<?php
require '../db.php';
require '../PHPWord/src/PhpWord/Autoloader.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

\PhpOffice\PhpWord\Autoloader::register();

if (!isset($_GET['id'])) {
    die("Error: No se ha proporcionado el ID de la SIM Card.");
}

$id = $_GET['id'];

$query = "
    SELECT e.cedula, e.nombre, e.cargo, e.area, e.sub_area, 
           s.linea_celular, s.fecha_compra, s.dispositivo, s.fecha_entrega  
    FROM sim_cards s
    LEFT JOIN empleados e ON s.cedula = e.cedula
    WHERE s.id = :id
";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);
$simCard = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$simCard) {
    die("Error: No se encontraron datos para la SIM Card proporcionada.");
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

$section->addText("ACTA DE ENTREGA DE SIM CARDS", 'titulo', 'centrado');
$section->addText("Fecha de entrega: " . date("d/m/Y"), 'normal');
$section->addTextBreak(1);

// Nueva sección para el compromiso
$section->addText("Yo, " . $simCard['nombre'] . ", con cargo de " . $simCard['cargo'] . ", me comprometo a hacer un uso adecuado de la SIM Card entregada y a devolverla en las condiciones en que fue recibida.", 'normal');

$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(3000)->addText("ITEM", 'subtitulo');
$table->addCell(7000)->addText("Descripción", 'subtitulo');

// Agregar información del dispositivo
$table->addRow();
$table->addCell(3000)->addText("Dispositivo:", 'normal');
$table->addCell(7000)->addText($simCard['dispositivo'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Línea Celular:", 'normal');
$table->addCell(7000)->addText($simCard['linea_celular'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Fecha de compra:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($simCard['fecha_compra'])), 'normal'); // Formatear fecha

$table->addRow();  // Nueva fila para la fecha de entrega
$table->addCell(3000)->addText("Fecha de entrega:", 'normal');
$table->addCell(7000)->addText(date("d/m/Y", strtotime($simCard['fecha_entrega'])), 'normal'); // Formatear fecha

// Agregar información del empleado
$table->addRow();
$table->addCell(3000)->addText("Nombre del Empleado:", 'normal');
$table->addCell(7000)->addText($simCard['nombre'], 'normal');

$table->addRow();
$table->addCell(3000)->addText("Cargo:", 'normal');
$table->addCell(7000)->addText($simCard['cargo'], 'normal');

$section->addTextBreak(1);

$section->addText("Condiciones Adicionales", 'subtitulo');
$condiciones = [
    "En caso de pérdida o daño por mal uso se descontará el valor total de la SIM Card.",
    "Las SIM Cards son propiedad de la empresa y deberán ser devueltas al área de SISTEMAS al finalizar el contrato.",
    "El responsable no podrá realizar ninguna modificación sin previa autorización por escrito del área de sistemas.",
    "Se anexa copia de la presente acta a su hoja de vida.",
    "Con la firma del presente formato, las partes aceptan en su totalidad lo mencionado anteriormente."
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
$section->addText("Nombre: " . $simCard['nombre'] . "\nCargo: " . $simCard['cargo'], 'normal', ['alignment' => Jc::LEFT]);

$footer = $section->addFooter();
$footer->addImage('../img/pie.png', [
    'width' => 450,
    'height' => 60,
    'alignment' => Jc::CENTER
]);

$fileName = "Acta_Entregar_Simcard_" . $simCard['nombre'] . "_" . $simCard['cedula'] . "_" . ".docx";
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
