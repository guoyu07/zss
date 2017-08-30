<?php

namespace app\models\system;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%carousel}}".
 *
 * @property integer $this_id
 * @property string $this_title
 * @property string $this_original
 * @property string $this_pc
 * @property string $this_wx
 * @property string $this_desc
 * @property integer $group_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $updated_id
 * 
 */
class Carousel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carousel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_title', 'carousel_desc'], 'required'],
            [['carousel_title'],'string','min'=>1,'max'=>50],
            [['carousel_desc'], 'string','min'=> 30,'max'=>150],
            ['carousel_title', 'unique', 'message' => '该轮播组名已经存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'carousel_id' => 'Carousel ID',
            'carousel_title' => '轮播图名称',
            'carousel_original' => '轮播图原图',
            'carousel_pc' => 'pc端轮播图',
            'carousel_wx' => 'wx端轮播图',
            'carousel_desc' => '轮播图描述',
            'group_id' => '所属轮播组',
            'created_at' => '创建时间',
            'updated_at' => '上次修改时间',
            'updated_id'=> '上次修改人'
            
        ];
    }

    
    /*
     * 轮播图列表
     * */
    
    public function carousel_list(){
        
        return Carousel::find()
        ->select(["carousel_id","carousel_title","carousel_pc","zss_group.group_name","zss_carousel.created_at","zss_carousel.updated_at","zss_admin.username"])
        ->innerJoin("`zss_group` on `zss_carousel`.`group_id` = `zss_group`.`group_id`")
        ->innerJoin("`zss_admin` on `zss_carousel`.`updated_id` = `zss_admin`.`id`")
        ->orderBy(['`zss_carousel`.updated_at'=>SORT_DESC])
        ->asArray()->all();
        
        $pages = $redata['pages'] = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '5']);
        $redata['data'] = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $redata;
        
    }
    
    
    /*
     * 轮播图修改
     * */
    public function imageupdate($img_path,$id,$updated_id){
        
        $status = 0;//初始状态
        
        $pdata=yii::$app->request->post();
        
        $savedata = Carousel::find()->where("carousel_id=$id")->one();
        
        if($this->validate()){
              $status =1;
        }else if(!$this->validate() && $savedata->carousel_title == $pdata['Carousel']['carousel_title']){
              $status =1;
        }
       
        if($status == 1){
            //循环取值赋值
            foreach($pdata['Carousel'] as $pk=>$pv){
                $savedata->$pk = $pv;
            }
            
            if($img_path != 0){
                foreach ($img_path as $ik=>$iv){
                    $savedata->$ik = $iv;
                }
            }
            
            return  $savedata->save();
        }else{
            return $this->getErrors();
        }
    } 
    
    
    /*
     * 轮播图添加
     * */
    public function imagesave($img_path,$updated_id){
   
         $pdata=yii::$app->request->post();//接收数据
        
         
         $this->carousel_title = $pdata['Carousel']['carousel_title'];
         $this->carousel_desc = $pdata['Carousel']['carousel_desc'];
         $this->carousel_original = $img_path['carousel_original'];
         $this->carousel_pc = $img_path['carousel_pc'];
         $this->carousel_wx = $img_path['carousel_wx'];
         $this->created_at = time();
         $this->updated_at = time();
         $this->group_id = $pdata['group'];
         $this->updated_id = $updated_id;
         return $this->save();
    }
    
    
    /*
     * 轮播图修改---查询
     * */
    public function image_sel($id){
        return $this->find()->select(array('carousel_id','carousel_title','carousel_pc','carousel_desc','group_id'))
        ->where(['carousel_id' => $id])->asArray()->one();
    }
    
     
    /*
     * 轮播图搜索查询
     * */
    public function searchByName($search){
        
        $result_search=$this->find()
        ->select(["carousel_id","carousel_title","carousel_pc","zss_group.group_name","zss_carousel.created_at","zss_carousel.updated_at","zss_admin.username"])
        ->innerJoin("`zss_group` on `zss_carousel`.`group_id` = `zss_group`.`group_id`")
        ->innerJoin("`zss_admin` on `zss_carousel`.`updated_id` = `zss_admin`.`id`")
        ->where( array('like', 'carousel_title', "$search"))
        ->orderBy(['updated_at'=>SORT_DESC])
        ->asArray()
        ->all();
        
        if($result_search){
            foreach ($result_search as $k=>$v){
                $result_search[$k]['created_at'] = date('Y-m-d H:i:s',$v['created_at']);
                $result_search[$k]['updated_at'] = date('Y-m-d H:i:s',$v['updated_at']);
            }
            return $result_search;
        }else{
            return 0;
        }
        
    }
    
    
    /*
     * 轮播图详情
     * */
    public function ImageDetail($cid){
        return $this->find()
        ->select(['carousel_id','carousel_title','carousel_desc','carousel_original','`zss_group`.group_name','`zss_carousel`.created_at','`zss_carousel`.updated_at','username'])
        ->innerJoin("`zss_admin` on `zss_carousel`.`updated_id` = `zss_admin`.`id`")
        ->innerJoin("`zss_group` on `zss_carousel`.`group_id` = `zss_group`.`group_id`")
        ->where("carousel_id = $cid")
        ->orderBy(['`zss_carousel`.updated_at'=>SORT_DESC])
        ->asArray()
        ->one();
    }
}
   
