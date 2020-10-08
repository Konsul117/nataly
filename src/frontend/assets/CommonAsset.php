<?php

namespace frontend\assets;

use newerton\fancybox\FancyBoxAsset;
use yii\web\AssetBundle;

class CommonAsset extends AssetBundle {

	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

	public $sourcePath = __DIR__ . '/files';

	public $css = [
	    'main.css',
    ];

	public $depends = [
	    FancyBoxAsset::class,
    ];
}
