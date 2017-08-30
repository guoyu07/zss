<?php 
    namespace backend\models\system;
    use yii\base\Model;
    
    class ImageForm extends Model{

        public $carousel_title;
        public $carousel_desc;
		public $file;
        
        public function rules(){
            return [[
                [['carousel_title','carousel_desc'],'required'],
                //['file', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*1024],
            ]];
        }
    }
?>