<?php
/**
 * 文件上传类
 */

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class Upload extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
    
    
    public function rules()
    {
        return [
            [['file'], 'file','extensions' => 'png, jp', 'maxFiles' => 5],
        ];
    }
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'png, jp', 'maxFiles' => 5],
        ];
    }
    
    public function attributeLabels(){
        return [
            'file'=>'文件上传'
        ];
    }
    

    /*
     * 轮播图上传
     * */
    public function imageupload($upload){
        //实例化上传类
        $file = UploadedFile::getInstance($upload, 'file');
        $path='uploads/'.date("YmdH",time()).'/';
        
        //判断是否验证通过
        if ($file && $upload->validate()) {
            var_dump($upload);die;
            if(!file_exists($path)){
                mkdir($path,'777');
            }
            $save_path=$path . time() . '.' . $file->getExtension();
            return $file->saveAs($save_path)?$save_path:0;
        }else{
            return $upload->getErrors();
        }
    }
}