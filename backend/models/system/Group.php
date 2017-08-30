<?php

namespace backend\models\system;

use Yii;
use app\models\system\Carousel;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $group_id
 * @property string $group_name
 * @property integer $group_ctime
 * @property integer $group_show
 * @property integer $group_start
 * @property integer $group_end
 * @property integer $created_at
 * @property integer $updated_at
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_show', 'group_ctime', 'created_at', 'updated_at'], 'integer'],
            [['group_name'], 'string', 'max' => 30],
            [['group_ctime'], 'integer','min'=>3, 'max' => 50],
            [['group_name', 'group_ctime'], 'required'],
            ['group_name', 'unique', 'message' => '该轮播组名已经存在'],
        ];
    }

 /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => '',
            'group_name' => '轮播组名',
            'group_show' => '是否显示',
            'group_ctime' => '轮播速度(秒)',
            'group_start' => '轮播组开始时间',
            'group_end' => '轮播组结束时间',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    /*
     * 轮播组列表
     * */
    public function GroupList(){
         $data = Group::find()->orderBy('group_show desc');
        $pages = $redata['pages'] = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
        $redata['model'] = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $redata;
    }
    
    
    /*
     * 轮播组详情
     * */
    public function groupdetail($did){
        return $this->find()
        ->select(['group_name','group_start','group_end','group_ctime','`zss_group`.created_at','`zss_group`.updated_at','username','group_show'])
        ->innerJoin("`zss_admin` on `zss_group`.`updated_id` = `zss_admin`.`id`")
        ->where("group_id = $did")
        ->asArray()
        ->one();
    }
    
    /*
     * 轮播组更换
     * */
    public function ChangeStatus($id,$status){
        
        $gdata = Group::find()->where("group_id=$id")->one();//根据id找数据
        $sdata = Group::find()->where("group_show=1")->one();//根据状态找数据
        
        if($gdata && $sdata){  ///解决问题,开启事务
            $sdata->group_show = 0;
            $gdata->group_show = 1;
            
            if (!$gdata->save() && $gdata->errors) {
                var_dump($gdata->errors);die;
            }
            
            if($sdata->save()){
                return $gdata->save()?1:0;
            }else{
                return 100;
            }     //正常情况下,接收一个未启用状态的id,将启用状态的轮播组转换状态,改为未启用
            //如果修改成功则返回1   如果失败则返回0
        }else if($gdata && (!$sdata)){
            $gdata->group_show = 1;
            return $gdata->save()?2:3;
        }else{
            return 0;
        }
    }
    
    /*
     * 轮播组添加
     * */
    public function groupsave($pdata){
        //判断开始时间是否晚于结束时间
        if(strtotime($pdata['Group']['group_start']) > strtotime($pdata['Group']['group_end'])){ return 2; }
       
        foreach ($pdata['Group'] as $pk=>$pv) {
            $this->$pk = $pv;
        }
        $this->group_start=strtotime($pdata['Group']['group_start']);
        $this->group_end=strtotime($pdata['Group']['group_end']);
        $this->created_at=time();
        $this->updated_at=time();
        $this->updated_id = Yii::$app->user->identity->id;
        
        
        //如果添加成功    要求显示
        if($this->save() && $pdata['Group']['group_show'] == 1){
         $olddata = Group::find()->where("group_show = 1")->one();
        
         $olddata->group_show = 0;
         
         return $olddata->save()?1:0;   //返回1 添加成功  返回0 添加失败
        }else if($this->save() && $pdata['Group']['group_show'] == 0){
           return  1; //如果不要求显示,就直接返回1
        }
    }
    
    /*
     * 轮播图修改---查询
     * */
    public function group_sel($id){
        return $this->find()->select(array('group_id','group_name','group_ctime','group_start','group_end'))->where(['group_id' => $id])->asArray()->one();
    }
    
    /*
     * 轮播组修改---修改
     * */
    public function groupUpdate($gdata){

        $pdata = yii::$app->request->post();//修改后的数据
        
        //查询除要修改id的所有轮播组名
        $all_group = $this->find()->select('group_id,group_name')->where("group_name ='". $pdata['Group']['group_name']."'")->asArray()->one();
    
        if (count($all_group) && ($all_group['group_id'] != $gdata->group_id)){return 0;}  //保证轮播组字段唯一性
        
        if($this->load($pdata)){ //加载提交数据
            
            if(!isset($pdata['Group']['group_show'])){ //如果没有传入group_show的状态,证明前端没有办法修改,就直接赋值为1
                $pdata['Group']['group_show'] = 1;
            }

            //判断入库条件是否满足
            $status = ($this->validate() || (!$this->validate() && $gdata->group_name == $pdata["Group"]['group_name']))?1:0;
            
            //判断是否轮播组开始时间和修改时间是否丢失
            if($pdata['Group']['group_start'] && $pdata['Group']['group_end']){
                $gdata->group_start = strtotime($pdata['Group']['group_start']);
                $gdata->group_end = strtotime($pdata['Group']['group_end']);
                unset($pdata['Group']['group_start']);
                unset($pdata['Group']['group_end']);
            }
            
            //入库条件是否满足
            if($status == 1){
                if($pdata['Group']['group_show'] == 1){
                    $olddata = Group::find()->where("group_show = 1")->one();//查询出现在数据库状态为1的那一条数据
                    //判断两个要显示的轮播图的id是否相同
                    if($pdata['Group']['group_id'] == $olddata->group_id){
                        $olddata_change_status = 1;
                    }else{
                        $olddata->group_show = 0;//将状态改变
                        $olddata_change_status = $olddata->save()?1:0;//判断旧数据状态是否更新
                        $olddata_change_status = 1;
                    }
                }else if($pdata['Group']['group_show'] == 0){
                    $olddata_change_status = 1;
                }
                
                //如果旧轮播组的id等于传入轮播图的id
                if($olddata_change_status){
                    foreach ($pdata['Group'] as $pk=>$pv){
                        if($pk == "group_show"){
                            $gdata->$pk = (int)$pv;
                        }else{
                            $gdata->$pk = $pv;
                        }
                    }
                    return $gdata->save();//返回新数据的修改状态
                }
            }
        }
    }
    
    /*
     * 轮播组搜索
     * */
    public function searchByName($search){
        $result_search=$this->find()->select(array('group_id','group_name','group_ctime','group_show','group_start','group_end'))->where( array('like', 'group_name', "$search"))->asArray()->all();
        if($result_search){
            foreach ($result_search as $k=>$v){
                 
                $result_search[$k]['group_start'] = date('Y-m-d H:i:s',$v['group_start']);
                $result_search[$k]['group_end'] = date('Y-m-d H:i:s',$v['group_end']);
            }
            return $result_search;
        }else{
            return 0;
        }
    }
    
    /*
     * 所有个数少于3张轮播图的轮播组查询
     * */
    public function findCon($status = 0){
        
        $str = '';
        $group_all = $this->find()->select(['group_id','group_name'])->asArray()->all();
        foreach ($group_all as $gk=>$gv){
            $count = Carousel::find()->where("group_id ='".$gv['group_id']."'")->count();
            if($count >=3){
                if(!(($status != 0) && $status == $gv['group_id'])){
                    unset($group_all[$gk]);
                }
            }
        }
        
        return $group_all?$group_all:0;
    }
    
    /*
     * 轮播组删除检测
     * */
    public function AfterDel($gid){
        
        //查看该轮播组状态  
        $is_exits = $this->find()->select('group_show')->where("group_id = $gid")->asArray()->one();
        
        if($is_exits['group_show'] == 1){//启用状态    
            return 1;  //返回1表示正在使用中,无法完成删除
        }else{
            //查看该分组下是否存在轮播图
            $count = Carousel::find()->where("group_id = $gid")->count();
            return $count?2:0;  //返回2表示当前分组下还存在轮播图,无法完成删除      没有轮播图返回0
        }
    }
    
    /*
     * 轮播组删除
     * */
    public function GroupDelete($gid){
        $fdata = $this->find()->where("group_id = $gid")->one();
        return $fdata->delete()?1:0;
    }
    
    /*
     * 轮播组自动切换
     * */
    public function AutoChange(){
        $group_show_time = $this->find()->select(['group_id','group_start','group_end'])->asArray()->all();
        
        $time = time();  //当前时间戳
        $str = '';
        foreach($group_show_time as $gk=>$gv){
            $group_status = 0;
            if($time > $gv['group_start'] && $time < $gv['group_end']){
                $need_change_group = Group::find()->where("group_id = '".$gv['group_id']."'")->one();
                $old_group_show = Group::find()->where("group_show = 1")->one();
                
                $group_status = ($group_show_time[$gk]['group_id'] == $old_group_show['group_id'])?1:0;
                
                if($group_status == 0){ //如果符合轮播组已经开启,就直接跳过这一步
                    $need_change_group->group_show = 1;
                    $old_group_show->group_show = 0;
                    
                    $old_group_show->save();
                    $need_change_group->save();
                }
            }
        }
    }
    
    /*
     * 轮播组添加   检测时间是否重叠
     * */
    public function IsTimeRe($start,$end){
        
        $start = strtotime($start);
        $end = strtotime($end);
        
        if($start && $end){
            $check_all_time = $this->find()->select(['group_start','group_end'])->asArray()->all();
            if(count($check_all_time)){
                $success = 0;
                $error = 0;
                foreach ($check_all_time as $ck=>$cv){
                    //如果当前添加的轮播组的开始时间大于原有的轮播组的结束时间      如果当前添加的轮播组的结束时间小于原有轮播组的开始时间
                    if($start > $cv['group_end'] || $end < $cv['group_start']){
                       $success += 1;
                    }else{
                        $error += 1;
                    }
                }
                return $error?false:true;
            }else{
                return true;  //如果轮播组内没有内容的时候,直接返回true
            }
        }
    }
}
