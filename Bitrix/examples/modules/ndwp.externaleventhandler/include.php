<?php

\Bitrix\Main\Loader::registerAutoLoadClasses(
	'ndwp.externaleventhandler', [
		'\Ndwp\Externaleventhandler\OnBeforeIBlockElementAddHandler' => 'lib/OnBeforeIBlockElementAddHandler.php',
	]
);