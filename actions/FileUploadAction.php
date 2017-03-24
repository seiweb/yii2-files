<?php

namespace seiweb\files\actions;

use seiweb\files\models\File;
use seiweb\files\ModuleTrait;
use Yii;
use yii\base\Action;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\validators\FileValidator;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\UploadedFile;

class FileUploadAction extends Action
{
    use ModuleTrait;

    public $modelAttribute = 'model_key';
    public $groupAttribute = 'group_key';
    public $objectAttribute = 'id_object';
    public $fileAttribute = 'swb_file';

    public function run()
    {
        if (!$model_key = \Yii::$app->request->post($this->modelAttribute)) { throw new BadRequestHttpException('Don\'t received POST param `model_key`.'); }
        if (!$id_object = \Yii::$app->request->post($this->objectAttribute)) { throw new BadRequestHttpException('Don\'t received POST param `id_object`.'); }

        $group_key = \Yii::$app->request->post($this->groupAttribute,0);

        $init = ['model_key'=>$model_key,'group_key'=>$group_key,'id_object'=>$id_object];

        $file = new File($init);

        $ufile = UploadedFile::getInstanceByName($this->fileAttribute);

        $v = new FileValidator();
        $v->maxSize = $this->getModule()->uploadFileMaxSize*1024;
        $v->extensions = $this->getModule()->allowedFileExtensions;
        $err = "Файл {$ufile->name} загружен";
        if(!$v->validate($ufile,$err))
        {
            Yii::$app->response->setStatusCode(400);
            return Json::encode(['success1'=>false,'message'=>$err]);
        }

        if($file->processUpload($ufile)){
            $res = ['success2' => true,'message'=>$err];
            return Json::encode($res);
        }

        //throw new HttpException(400,'bad req');
        Yii::$app->response->setStatusCode(400);
        return Json::encode(['success3'=>false,'message'=>$file->errors]);
    }
}
