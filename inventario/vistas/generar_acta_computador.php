<?php
require '../db.php'; // Conexión a la base de datos
require '../PHPWord/src/PhpWord/Autoloader.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Registrar el autoloader de PHPWord
\PhpOffice\PhpWord\Autoloader::register();

// Verificar si se recibe el serial del dispositivo
if (!isset($_GET['serial'])) {
    die("Error: No se ha proporcionado el serial del dispositivo.");
}

$serial = $_GET['serial'];

// Consultar datos del empleado y dispositivo usando el serial
$query = "
    SELECT e.cedula, e.nombre, e.cargo, e.area, e.sub_area, 
           c.serial, c.marca, c.referencia, c.mac, c.ram, c.fecha, c.fecha_compra, c.estado_entrega
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

// Crear documento Word
$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Estilos
$phpWord->addFontStyle('titulo', ['bold' => true, 'size' => 16, 'name' => 'Arial']);
$phpWord->addFontStyle('subtitulo', ['bold' => true, 'size' => 12, 'name' => 'Arial']);
$phpWord->addFontStyle('normal', ['size' => 11, 'name' => 'Arial']);
$phpWord->addParagraphStyle('centrado', ['alignment' => 'center']);
$phpWord->addTableStyle('EstiloTabla', [
    'borderSize' => 6, 
    'borderColor' => '0070C0',
    'cellMargin' => 80,
]);

// Agregar imagen de encabezado (Asegúrate de que la imagen exista en la ruta correcta)
$header = $section->addHeader();
$header->addImage('../img/encabezado.png', [
    'width' => 450,
    'height' => 40,
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
]);

// Encabezado
$section->addText("ACTA DE ENTREGA DE EQUIPO COMPUTADOR", 'titulo', 'centrado');
$section->addTextBreak(1);

// Información de la empresa y la fecha
$section->addText("Empresa: POLIGROW COLOMBIA S.A.S", 'subtitulo');
$section->addText("Fecha de Entrega: " . date("d/m/Y"), 'normal');
$section->addTextBreak(1);

// Introducción
$section->addText("Yo, " . $computador['nombre'] . ", identificado con cédula de ciudadanía N° " . $computador['cedula'] . ", actuando como " . $computador['cargo'] . " en el área de " . $computador['area'] . ", sub-área " . $computador['sub_area'] . ", hago constar que he recibido el siguiente equipo computador:", 'normal');
$section->addTextBreak(1);

// Tabla de información del equipo
$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(4000)->addText("Campo", 'subtitulo');
$table->addCell(6000)->addText("Detalle", 'subtitulo');

$table->addRow();
$table->addCell(4000)->addText("Marca:", 'normal');
$table->addCell(6000)->addText($computador['marca'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Referencia:", 'normal');
$table->addCell(6000)->addText($computador['referencia'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Serial:", 'normal');
$table->addCell(6000)->addText($computador['serial'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("MAC:", 'normal');
$table->addCell(6000)->addText($computador['mac'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("RAM:", 'normal');
$table->addCell(6000)->addText($computador['ram'] . ' GB', 'normal');

$table->addRow();
$table->addCell(4000)->addText("Estado de entrega:", 'normal');
$table->addCell(6000)->addText($computador['estado_entrega'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Fecha de compra:", 'normal');
$table->addCell(6000)->addText($computador['fecha_compra'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Fecha de entrega:", 'normal');
$table->addCell(6000)->addText(date("d/m/Y"), 'normal');

$section->addTextBreak(1);

// Declaración de responsabilidad
$section->addText("Declaro que el equipo computador se encuentra en buen estado y que asumo la responsabilidad por su uso adecuado. En caso de pérdida o daño, responderé según las políticas de la empresa.", 'normal');
$section->addTextBreak(2);

// Firma
$section->addText("__________________________", 'subtitulo');
$section->addText("Firma del Empleado", 'normal');
$section->addTextBreak(2);

$section->addText("__________________________", 'subtitulo');
$section->addText("Responsable del Área de Sistemas", 'normal');

// Agregar imagen en el pie de página
$footer = $section->addFooter();
$footer->addImage('../img/pie.png', [
    'width' => 450,
    'height' => 60,
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
]);

// Guardar el documento
$fileName = "Acta_Entrega_Computador_" . $serial . ".docx";
$path = "../actas/" . $fileName;
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($path);

// Descargar el archivo
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Length: " . filesize($path));
readfile($path);

// Eliminar el archivo del servidor después de la descarga
unlink($path);
exit;
?>
