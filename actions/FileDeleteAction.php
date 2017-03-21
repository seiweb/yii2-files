<?php

namespace seiweb\files\actions;

use seiweb\files\models\File;
use seiweb\files\ModuleTrait;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;

class FileDeleteAction extends Action
{
    use ModuleTrait;

    public $filesAttribute = 'ids';

    public function run()
    {
        if (!$items = \Yii::$app->request->post($this->filesAttribute)) { throw new BadRequestHttpException('Don\'t received POST param `filesAttribute`.'); }

        foreach ($items as $id) {
            $model = File::findOne($id);

            $model->delete();
        }

        $res = ['result'=>'ok'];
        return Json::encode($res);
    }
}
