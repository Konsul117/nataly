<?php

namespace common\base;

class Module extends \yii\base\Module {

	public function init() {
		parent::init();
		$r = new \ReflectionClass($this);
		$r->getNamespaceName();
		$this->controllerNamespace = $r->getNamespaceName() . '\\controllers';
	}
}
