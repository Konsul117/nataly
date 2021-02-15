<?php

use common\modules\image\components\ImageThumbCreator;
use common\modules\image\Image;
use common\modules\image\models\ImageProvider;

return [
	'modules' => [
		'image' => [
			'class'      => Image::class,
			'components' => [
				'imageThumbCreator' => [
					'class'       => ImageThumbCreator::class,
					'thumbsSizes' => [
						ImageProvider::FORMAT_THUMB  => [
							'width'  => 90,
							'height' => 90,
							'crop'   => true,
						],
						ImageProvider::FORMAT_POST_MAIN => [
							'width'     => 170,
							'height'    => 170,
							'watermark' => true,
						],
						ImageProvider::FORMAT_MEDIUM => [
							'width'     => 400,
							'height'    => 400,
							'watermark' => true,
						],
						ImageProvider::FORMAT_FULL   => [
							'width'     => 1000,
							'height'    => 1000,
							'watermark' => true,
						],
                        ImageProvider::FORMAT_BOOK   => [
                            'width'     => 211,
                            'height'    => 300,
                            'watermark' => false,
                        ],
					],
				],
			],
		],
	],
];
