<?php

Yii::setAlias('@themeRoot', '@frontend/sources/front/tmp/dist');

return [
	'id'         => 'frontend',
	'components' => [
		'assetManager' => [
            'appendTimestamp' => true,
		],
		'errorHandler' => [
			'errorView' => '@frontend/views/layouts/error.php',
		],
		'request'      => [
			'cookieValidationKey' => 'valentina-vl',
		],
	],
];
