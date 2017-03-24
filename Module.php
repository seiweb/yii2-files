<?php

namespace seiweb\files;


/**
 * Class Module
 * @package seiweb\files
 */
class Module extends \yii\base\Module
{
    public $uploadsAlias = '@frontend/web/uploads/files';
    public $uploadFileMaxSize = 2052;
    public $allowedFileExtensions = ['pdf', 'doc', 'docx','zip','rar','xls','xlsx','rtf','jpg','png'];
    public $maxFileCount = 15;

    public function getStorePath()
    {
        return \Yii::getAlias($this->uploadsAlias);
    }

    public function init()
    {
        parent::init();
    }
}
