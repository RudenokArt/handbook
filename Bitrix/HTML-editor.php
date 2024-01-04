<?php 

function add_textarea_form($c, $g){
	$LHE = new CLightHTMLEditor;
	$LHE->Show(array(
		'id' => "",
		'width' => '100%',
		'height' => '200px',
		'inputName' => $c,
		'content' => $g,
		'BBCode' => true,
		'bUseFileDialogs' => false,
		'bFloatingToolbar' => false,
		'bArisingToolbar' => false,
		'toolbarConfig' => array(
			'Bold', 'Italic', 'Underline', 'RemoveFormat', 'Code', 'Source', 'Video', 'Html',
			'CreateLink', 'DeleteLink', 'Image', 'Video',
			'BackColor', 'ForeColor',
			'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
			'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
			'StyleList', 'HeaderList',
			'FontList', 'FontSizeList',
		),
	));
};

AddEventHandler("fileman", "OnIncludeLightEditorScript", "CustomizeLHEForForum");

         $LHE = new CLightHTMLEditor();

         $arEditorParams = array(
            'bRecreate' => true,
            'id' => $arParams["LheId"],
            'content' => isset($arResult["REVIEW_TEXT"]) ? $arResult["REVIEW_TEXT"] : "",
            'inputName' => "REVIEW_TEXT",
            'inputId' => "",
            'width' => "100%",
            'height' => "200px",
            'minHeight' => "200px",
            'bUseFileDialogs' => false,
            'bUseMedialib' => false,
            'BBCode' => true,
            'bBBParseImageSize' => true,
            'jsObjName' => $arParams["jsObjName"],
            'toolbarConfig' => array(),
            'smileCountInToolbar' => 3,
            'arSmiles' => $arSmiles,
            'bQuoteFromSelection' => true,
            'ctrlEnterHandler' => 'reviewsCtrlEnterHandler'.$arParams["form_index"],
            'bSetDefaultCodeView' => ($arParams['EDITOR_CODE_DEFAULT'] === 'Y'),
            'bResizable' => true,
            'bAutoResize' => true
         );

         $arEditorParams['toolbarConfig'] = forumTextParser::GetEditorToolbar(array('forum' => $arResult['FORUM']));
         $LHE->Show($arEditorParams);


?>