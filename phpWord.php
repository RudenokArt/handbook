composer require phpoffice/phpword - Установка через композер
<?php 

include_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/phpword/autoload.php';
$phpWord = new  \PhpOffice\PhpWord\PhpWord(); 
$_doc = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT'].'/local/components/vetliva/partner_contract/template.docx');
$_doc->setValue('partner', 'Санаторий Юность');
$_doc->saveAs($_SERVER['DOCUMENT_ROOT'].'/local/components/vetliva/partner_contract/contract.docx');

?>