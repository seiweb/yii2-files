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

class FileDownloadAction extends Action
{
    use ModuleTrait;

    public function run($id)
    {
        $file = File::findOne($id);
        if($file==null)
            throw new HttpException(400,"Запрашиваемый файл не найден");


        $fname = $file->uf_file_name;
        $ftype = $file->ext;

        $path = $this->getModule()->getStorePath();

        $file = $path.DIRECTORY_SEPARATOR.$file->file_name;

        if (ob_get_level()) {
            ob_end_clean();
        }

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: inline; filename='{$fname}.{$ftype}'");
        header("Content-Transfer-Encoding: binary ");
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;

    }
}
