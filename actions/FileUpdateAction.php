<?php

namespace seiweb\files\actions;

use seiweb\files\models\File;
use seiweb\files\ModuleTrait;
use Yii;
use yii\base\Action;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\UploadedFile;

class FileUpdateAction extends Action
{
    use ModuleTrait;

    public $fileAttribute = 'swb_file';

    public function run($id)
    {
        $model = File::findOne($id);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            $res = ['success' => true, 'message' => "Файл {$model->uf_file_name} успешно обновлен."];
            return Json::encode($res);
        }

        Yii::$app->response->setStatusCode(400);
        $res = [
            'success'=>false,
            'message'=>"Какая-то ошибка :-("
        ];

        return Json::encode($res);

    }
}
