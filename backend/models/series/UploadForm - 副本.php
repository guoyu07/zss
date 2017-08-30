<?php
namespace backend\models\series;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }
    
    public function upload()
    {
        
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('add/menu/' . $file->baseName . '.' . $file->extension,"./add/");
                $info[] = $file->baseName . '.' . $file->extension;
            }
            return $info;
        } else {
            return false;
        }
    }
}