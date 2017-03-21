<?php
/**
 * Created by PhpStorm.
 * User: kostanevazno
 * Date: 17.07.14
 * Time: 0:20
 */

namespace seiweb\files;


use yii\base\Exception;

trait ModuleTrait
{
    private $_module;


    /**
     * @return null|\seiweb\files\Module
     * @throws Exception
     */
    protected function getModule()
    {
        if ($this->_module == null) {
            $this->_module = \Yii::$app->getModule('swb_files');
        }

        if(!$this->_module){
            throw new Exception("\n\n\n\n\nYii2 files module not found, may be you didn't add it to your config?\n\n\n\n");
        }

        return $this->_module;
    }
}