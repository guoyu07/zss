<?php

namespace backend\models\operate;

use Yii;
use backend\models\series\Series;

/**
 * This is the model class for table "{{%stat_series}}".
 *
 * @property integer $stat_series_id
 * @property string $series_name
 * @property string $series_turnover
 * @property string $created_at
 */
class StatSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_series}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_name', 'series_turnover', 'created_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stat_series_id' => 'Stat Series ID',
            'series_name' => 'Series Name',
            'series_turnover' => 'Series Turnover',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc 单条查询
     * @params  $where  array 查询条件
     */
    public function find_one($where)
    {
        return $this->find()->where($where)->asArray()->one();
    }

    /**
     * @inheritdoc  查询所有
     * @params $filed  array 字段列表
     * @params $where  array 查询条件
     */
    public function find_all($filed = "*",$where = '')
    {
        if(count($where) == 3){
          $orderby = ['created_at'=>SORT_DESC,'series_name'=>SORT_ASC];
        }else{
          $orderby = ['created_at'=>SORT_ASC,'series_name'=>SORT_ASC];
        }
        return $this->find()->select($filed)->where($where)->orderBy($orderby)->asArray()->all();
    }

    /**
     * @inheritdoc  搜索
     * @params  $start_time  date 开始时间
     * @params  $end_time  date 结束时间
     * @params  $word  string 模糊查询关键字
     */
    public function search($start_time,$end_time,$word)
    {
        //赋初值
        $start_time = empty($start_time) ? '2016-01-01' : $start_time;
        $end_time = empty($end_time) ? date('Y-m-d',strtotime("-1 day")) : $end_time;
        return $this
            ->find()
            ->from('zss_stat_series')
            ->where('created_at>=:start_time and created_at<=:end_time and series_name like :word',
              [':start_time'=>$start_time,':end_time'=>$end_time,':word'=>'%'.$word."%"])
            ->orderBy(['created_at'=>SORT_DESC,'series_name'=>SORT_ASC])
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc  批量添加
     * @params   $add  array 添加数据
     */
    public function add_all($add)
    {
      //判断是否更新
      $connection = \Yii::$app->db;
      //数据批量入库
      $connection->createCommand()->batchInsert(
        'zss_stat_series',
        ['series_name','series_turnover','created_at'],
        $add
      )->execute();
    }

    /**
     * @inheritdoc  总统计 饼图
     */
    public function find_for_chart()
    {
      return $this
          ->find()
          ->select(['series_name','count(series_turnover) as count','created_at'])
          ->groupBy(['series_name'])
          ->asArray()
          ->all();
    }

    /**
     * @inheritdoc  总统计 折线图
     */
    public function find_line_chart()
    {
      return $this
          ->find()
          ->select(['series_name','count(series_turnover) as count','created_at'])
          ->groupBy(['series_name','created_at'])
          ->asArray()
          ->all();
    }

    /**
     * @inheritdoc  总收入
     */
    public function find_total()
    {
      return $this
          ->find()
          ->select(['count(series_turnover) as count'])
          ->asArray()
          ->one();
    }

    /**
     * @inheritdoc  门店折线图 处理$data为折线图所需数据返回
     * @params  $data array  折线图所需数据
     */
    public function line_chart($data)
    {
      //各自取出时间和门店名
      foreach($data as $k=>$v){
        $time[$k]=$v['created_at'];
        $series_name[$k]=$v['series_name'];
      }
      //去重
      $time = array_unique($time);
      $series_name = array_unique($series_name);
      //把$series_name的键值从字符串转化成数字
      foreach($series_name as $k=>$v){
        $series_names[] = $v;
      }
      //时间反转 时间正序
      sort($time);
      //$data数据反转 配合时间的反转
      krsort($data);
      //处理后获得 折线图所需json数据
      foreach($series_names as $k=>$v){
        $series_info[$k]['name'] = $v;
        foreach($time as $kkk=>$vvv){
          $menu_info[$k]['data'][] = 0;
        }
        foreach($data as $kk=>$vv){
          if($vv['series_name'] == $v){
            foreach($time as $kkk=>$vvv){
              if($vv['created_at'] == $vvv){
                $series_info[$k]['data'][] = floatval($vv['series_turnover']);
              }
            }
          }
        }
        if($k == 9){
          break;
        }
      }
  		$info['series_info'] = json_encode($series_info);
  		$info['time'] = json_encode($time);
      //两个json数据一起返回
      return $info;
    }

    /**
     * @inheritdoc  本店本日各分类营业情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     * @params  $shop_id int  商店id
     */
    public function pie_shop_series_chart($shop_id,$date)
    {
      //echo $shop_id;
      $series = new Series();
      $series_info = $series
              ->find()
              ->select(['zss_series.series_id','zss_series.series_name','zss_series.series_name',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_menu','zss_series.series_id=zss_menu.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_series.series_name')
              ->where(['zss_shop.shop_id'=>$shop_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
              ->asArray()
              ->all();
      if(empty($series_info)){
        return json_encode(array(array('name'=>'无此详情','y'=>0)));
      }
      $sum = 0;
      foreach($series_info as $k=>$v){
        $sum += $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)'];
      }
      foreach($series_info as $k=>$v){
        $pie[$k]['name'] = $v['series_name'];
        if($sum == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)']*100/$sum;
        }
      }
      $pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  各门店本日消费额饼图 制作所需数据返回
     * @params  $date date  本日日期
     */
    public function pie_shop_chart($series_name,$date)
    {
      $order = new Order();
      foreach($series_ids as $k=>$v){
        $info = $order->find()
              ->select(['series_id','SUM(order_total) as total'])
              ->innerJoin('zss_order_info','zss_order.order_id=zss_order_info.order_id')
              ->where(['series_id'=>$series_id,'series_id'=>$v['series_id'],'zss_order.created_at'=>$date])
              ->groupBy(['series_id'])
              ->asArray()
              ->one();
        if(empty($info)){
          $info['series_name'] =  $v['series_name'];
          $info['total'] = 0;
        }
        $info['series_name'] =  $v['series_name'];
        $infos[] = $info;
      }
      $sum = 0;
      foreach($infos as $k=>$v){
        $sum += $v['total'];
      }
  		foreach($infos as $k=>$v){
  			$pie[$k]['name'] = $v['series_name'];
        if($sum == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['total']*100/$sum;
        }
  		}
      //print_r($pie);die;
  		$pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  本店本日各分类营业情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     * @params  $shop_id int  商店id
     */
    public function pie_series_menu_chart($series_id,$date)
    {
      //echo $shop_id;
      $series = new Series();
      $series_info = $series
              ->find()
              ->select(['zss_series.series_id','zss_series.series_name','zss_series.series_name','zss_menu.menu_name',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_menu','zss_series.series_id=zss_menu.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_menu.menu_id')
              ->where(['zss_series.series_id'=>$series_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
              ->asArray()
              ->all();
      if(empty($series_info)){
        return json_encode(array(array('name'=>'无此详情','y'=>0)));
      }
      //print_r($series_info);die;
      $sum = 0;
      foreach($series_info as $k=>$v){
        $sum += $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)'];
      }
      foreach($series_info as $k=>$v){
        $pie[$k]['name'] = $v['menu_name'] . "(" . $v['series_name'] . ")";
        if($sum == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)']*100/$sum;
        }
      }
      $pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  本店本日各分类营业情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     * @params  $shop_id int  商店id
     */
    public function pie_series_shop_chart($series_id,$date)
    {
      //echo $shop_id;
      $series = new Series();
      $series_info = $series
              ->find()
              ->select(['zss_series.series_id','zss_series.series_name','zss_series.series_name','zss_shop.shop_name',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_menu','zss_series.series_id=zss_menu.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_shop.shop_name')
              ->where(['zss_series.series_id'=>$series_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
              ->asArray()
              ->all();
      if(empty($series_info)){
        return json_encode(array(array('name'=>'无此详情','y'=>0)));
      }
      $sum = 0;
      foreach($series_info as $k=>$v){
        $sum += $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)'];
      }
      foreach($series_info as $k=>$v){
        $pie[$k]['name'] = $v['shop_name'];
        if($sum == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)']*100/$sum;
        }
      }
      $pie = json_encode($pie);
      return $pie;
    }
}
