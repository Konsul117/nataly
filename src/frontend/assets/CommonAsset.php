<?php

namespace frontend\assets;

use newerton\fancybox\FancyBoxAsset;
use yii\web\AssetBundle;

class CommonAsset extends AssetBundle {

	public $jsOptions = ['position' => \yii\web\View::POS_END];

	public $sourcePath = __DIR__ . '/files';

	public $js = [
	    'main.js',
    ];

	public $css = [
	    'main.css',
    ];

	public $depends = [
	    FancyBoxAsset::class,
    ];
}
