<?php

namespace backend\models\series;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property integer $image_id
 * @property string $image_url
 * @property string $image_wx
 * @property string $image_pc
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $model_id
 * @property integer $image_status
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'model_id', 'image_status'], 'integer'],
            [['image_url', 'image_wx', 'image_pc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'image_url' => 'Image Url',
            'image_wx' => 'Image Wx',
            'image_pc' => 'Image Pc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'model_id' => 'Model ID',
            'image_status' => 'Image Status',

        ];
    }

    public function imgUrlAdd($modelid,$variable,$user){
      
        for ($i=0;$i<count($variable);$i++) {
              $img = new Image();
              $img->image_url = $variable[$i][0];
              $img->image_wx = $variable[$i][1];          
              $img->image_pc = $variable[$i][2]; 
              $img->created_at  = time();
              $img->updated_at = time(); 
              $img->model_id = $modelid;
              $img->image_status = 1; 
              $img->save();
                } 
            if ($img->save()) {
             return true;
            }else{

              return false;
            }
              
                    
      }

       public function imgUrlck($modelid,$variable,$user){

         $img = new Image();
         
        if(Image::findOne(["model_id"=>$modelid])->delete()){ 

         for ($i=0;$i<count($variable);$i++) {
              $img = new Image();
              $img->image_url = $variable[$i][0];
              $img->image_wx = $variable[$i][1];          
              $img->image_pc = $variable[$i][2]; 
              $img->created_at  = time();
              $img->updated_at = time(); 
              $img->model_id = $modelid;
              $img->image_status = 1; 
              $img->save();
                } 
            if ($img->save()) {
             return true;
                }else{

              return false;
                 }
                                  
            }else{

              return false;
            } 
       }
     }



