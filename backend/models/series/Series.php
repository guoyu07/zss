<?php

namespace backend\models\series;

use Yii;
use backend\models\admin\Admin;
/**
 * This is the model class for table "{{%series}}".
 *
 * @property integer $series_id
 * @property string $series_name
 * @property integer $series_sort
 * @property integer $series_status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Series extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%series}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_sort', 'series_status', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['series_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'series_id' => 'Series ID',
            'series_name' => 'Series Name',
            'series_sort' => 'Series Sort',
            'series_status' => 'Series Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
             'updated_id' => 'Updated Id',
        ];
    }
    //所有类别
    public function showall()
    {
        return Series::find()->select(["username","series_id","series_name","series_sort","series_status","zss_series.updated_at","zss_series.created_at","img1","img2","img3","series_name2","series_desc"])
                             ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_series`.`updated_id`")
                             ->OrderBy(["series_sort"=>SORT_DESC])
                             ->asArray()
                             ->all();

    }

    //delete
    public function delone($id)
    {
        $newid = explode(",",$id);

       return Series::deleteAll(["series_id"=>$newid]);

    }
    //查找添加类别是否存在
    public function checkinfo($name)
    {
       return Series::find()->where(["series_name"=>"$name"])->asArray()->one();

    }

    //查找添加类别是否存在
    public function oneinfo($id)
    {

     return  $arr = Series::find()->where(["series_id"=>$id])->asArray()->one();

    }
     //查找添加类别
    public function addinfo($name)
    {
        $model = new Series();

        foreach($name as $key=>$value)
        {
              $model->$key = $value;

        }
              return  $model->save() ;

     }
     //修改
     public function fixinfo($user){

        $arr = array("series_id"=>$user["series_id"]);

        return  Series::updateall($user,$arr);


     }
     //搜索
     public function search($key){

       return Series::find()->select(["username","series_id","series_name","series_sort","series_status","zss_series.updated_at","zss_series.created_at","img1","img2"])
                             ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_series`.`updated_id`")
                             ->OrderBy(["series_sort"=>SORT_DESC])
                             ->where(['like', 'series_name', "$key"] )
                             ->asArray()
                             ->all();

     }

     /**
      * @params $filed array  字段列表
      */
       public function find_all($filed)
       {
         return $this
                 ->find()
                 ->select($filed)
                 ->asArray()
                 ->all();
       }
       //修改状态
       public function fixnow($id,$status)
        {       if ($status==1) {   
                    $stri = 0;
                }else{
                     $stri = 1;
                }
               return Series::updateall(array("series_status"=> $stri),array("series_id"=>$id));

        }

		//查询id
         public function series_id($where)
         {
           $series_id = $this
                   ->find()
                   ->select('series_id')
                   ->where($where)
                   ->asArray()
                   ->one();
            return $series_id['series_id'];
         }

         //修改图片1
         public function fiximg1($id,$name)
         {
              return Series::updateall(array("img1"=> $name),array("series_id"=>$id));
         }

          //修改图片2
         public function fiximg2($id,$name)
         {
              return Series::updateall(array("img2"=> $name),array("series_id"=>$id));
         }

          //修改图片3
         public function fiximg3($id,$name)
         {
              return Series::updateall(array("img3"=> $name),array("series_id"=>$id));
         }
}
