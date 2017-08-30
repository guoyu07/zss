<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;
    

    public function rules()
    {
         return [
            [['file'], 'file','extensions' => 'png, jpg'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'file'=>'文件上传'
        ];
    }
    
    /* 
     * 图片上传
     * */
    public function imageupload($upload){
        //执行入库操作
        
        $path='uploads/'.date("YmdH",time()).'/';
        if(!file_exists($path)){
            
            mkdir($path);
            chmod($path, 0777);
        }
        
        $save_path=$path . time() . '.' . $upload->file->getExtension();
        return $upload->file->saveAs($save_path)?$save_path:0;
    }
}