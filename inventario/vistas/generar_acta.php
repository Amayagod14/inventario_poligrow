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
           c.serial, c.imei, c.marca, c.modelo, c.fecha, c.fecha_compra
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

// Encabezado del documento
$section->addText("ACTA DE ENTREGA DE EQUIPO CELULAR", 'titulo', 'centrado');
$section->addTextBreak(1);

// Información de la empresa y la fecha
$section->addText("Empresa: POLIGROW COLOMBIA S.A.S", 'subtitulo');
$section->addText("Fecha de Entrega: " . date("d/m/Y"), 'normal');
$section->addTextBreak(1);

// Introducción
$section->addText("Yo, " . $celular['nombre'] . ", identificado con cédula de ciudadanía N° " . $celular['cedula'] . ", actuando como " . $celular['cargo'] . " en el área de " . $celular['area'] . ", sub-área " . $celular['sub_area'] . ", hago constar que he recibido el siguiente equipo celular:", 'normal');
$section->addTextBreak(1);

// Tabla de información del equipo
$table = $section->addTable('EstiloTabla');
$table->addRow();
$table->addCell(4000)->addText("Campo", 'subtitulo');
$table->addCell(6000)->addText("Detalle", 'subtitulo');

$table->addRow();
$table->addCell(4000)->addText("Marca:", 'normal');
$table->addCell(6000)->addText($celular['marca'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Modelo:", 'normal');
$table->addCell(6000)->addText($celular['modelo'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Serial:", 'normal');
$table->addCell(6000)->addText($celular['serial'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("IMEI:", 'normal');
$table->addCell(6000)->addText($celular['imei'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Fecha de compra:", 'normal');
$table->addCell(6000)->addText($celular['fecha_compra'], 'normal');

$table->addRow();
$table->addCell(4000)->addText("Fecha de entrega:", 'normal');
$table->addCell(6000)->addText(date("d/m/Y"), 'normal');

$section->addTextBreak(1);

// Declaración de responsabilidad
$section->addText("Declaro que el equipo celular se encuentra en buen estado y que asumo la responsabilidad por su uso adecuado. En caso de pérdida o daño, responderé según las políticas de la empresa.", 'normal');
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
$fileName = "Acta_Entrega_Celular_" . $serial . ".docx";
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
