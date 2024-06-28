<?php 


include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$phpWord = new  \PhpOffice\PhpWord\PhpWord(); 
$_doc = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
$_doc->setValue('test_var', 'test-value');
// $_doc->setImageValue('sig','sig.png'); // вставить изображение
$_doc->saveAs($_SERVER['DOCUMENT_ROOT'].'/result.docx');