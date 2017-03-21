<?php

namespace seiweb\files;


/**
 * Class Module
 * @package seiweb\files
 */
class Module extends \yii\base\Module
{
    public $uploadsAlias = '@frontend/web/uploads/files';
    public $sizeLimit=8048000;

    public function getStorePath()
    {
        return \Yii::getAlias($this->uploadsAlias);
    }

    public function init()
    {
        parent::init();
    }
}
