<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.03.2017
 * Time: 2:27
 */

namespace seiweb\files\behaviors;

use Codeception\Exception\ConfigurationException;
use seiweb\files\models\File;
use seiweb\files\ModuleTrait;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class FileBehavior
 * @package seiweb\files\behaviors
 * @mixin FileBehavior
 */
class FileBehavior extends Behavior
{
    use ModuleTrait;

    public $modelKey = null;

    public function init()
    {
        if ($this->modelKey == null)
            throw new ConfigurationException("Необходимо установить modelKey");


    }

    public function getFileById($id)
    {
        return File::findOne($id);
    }

    public function getFileByGroup($group_key)
    {
        return $this->getFiles($group_key, true)->one();
    }

    /**
     * Возвращает файлы, привязанные к модели
     *
     * @param null $group_key
     * @param bool $one
     *
     * @return mixed
     */
    public function getFiles($group_key = null, $one = false)
    {
        $q = $this->owner->hasMany(File::className(), ['id_object' => 'id'])
            ->where(File::tableName() . '.model_key=:m_name', [':m_name' => $this->modelKey])->orderBy('sort');
        if ($group_key)
            $q->andWhere(['group_key' => $group_key]);
        if ($one)
            $q->limit(1);

        return $q;
    }

    public function getFilesByGroup($group_id, $one = false)
    {
        $q = $this->getFiles($group_id, $one);
        if ($one)
            return $q->one();
        return $q->all();
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => function ($event) {
                $this->deleteAllFiles();
            },
        ];
    }

    public function deleteAllFiles()
    {
        $condition = ['and', 'id_object=:id', 'model_key=:m'];
        $params = ['id' => $this->owner->primaryKey, ':m' => $this->modelKey];

        $files = File::find()->where($condition, $params)->select('file_name')->column();

        foreach ($files as $file_name) {
            unlink($this->getModule()->getStorePath() . DIRECTORY_SEPARATOR . $file_name);
        }

        File::deleteAll(['and', 'id_object=:id', 'model_key=:m'], ['id' => $this->owner->primaryKey, ':m' => $this->modelKey]);
    }

    public function attachFile($file, $group_key = 0, $replace = false)
    {
        $file->model_key = $this->modelKey;
        $file->group_key = $group_key;
        $file->id_object = $this->owner->primaryKey;


        if ($replace) {
            $files = $this->owner->getFiles($group_key)->all();
            foreach ($files as $f)
                $f->delete();
        }

        if ($file->save()) return true;

        return false;
    }

    /**
     * Присоединяет файл к модели
     *
     * На входе нужен экземпляр UploadedFile
     * Возвращает экземпляр
     *
     * @param UploadedFile $file
     * @param int          $group_key
     *
     * @return null|File
     */
    public function attachFile1($file, $group_key = 0, $replace = false)
    {
        if (!$file)
            return null;

        $fileModel = new File(['model_key' => $this->modelKey, 'group_key' => $group_key, 'id_object' => $this->owner->primaryKey]);
        $fileModel->file = $file;


        if ($fileModel->processUpload()) {

            if ($replace) {
                $files = $this->owner->getFiles($group_key)->andWhere('id<>' . $fileModel->id)->all();
                foreach ($files as $f)
                    $f->delete();
            }
            return $fileModel;
        }

        return $fileModel;
    }

    /**
     * Отсоединяет файл и удаляет его
     *
     * @param $file_id
     */
    public function detachFile($file)
    {
        $file->delete();
    }

    private function populateFiles()
    {
    }
}