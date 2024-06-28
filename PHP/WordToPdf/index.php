<?php 


include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$phpWord = new  \PhpOffice\PhpWord\PhpWord(); 
$_doc = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
$_doc->setValue('test_var', 'test-value');
// $_doc->setImageValue('sig','sig.png'); // вставить изображение
$_doc->saveAs($_SERVER['DOCUMENT_ROOT'].'/result.docx');
use PhpOffice\PhpWord\Settings;
Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
Settings::setPdfRendererPath('.');
$phpWord = \PhpOffice\PhpWord\IOFactory::load('result.docx');
$pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
$pdfWriter->save('document.pdf');