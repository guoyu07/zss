<?php

namespace backend\models\operate;

use Yii;
use backend\models\order\Order;
use backend\models\menu\Menu;

/**
 * This is the model class for table "{{%stat_menu}}".
 *
 * @property integer $stat_shop_id
 * @property string $menu_name
 * @property string $series_name
 * @property string $menu_price
 * @property string $menu_count
 * @property string $menu_total
 * @property string $menu_introduce
 * @property integer $menu_status
 * @property string $created_at
 */
class StatMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_price', 'menu_count', 'menu_total'], 'number'],
            [['menu_status'], 'integer'],
            [['created_at'], 'safe'],
            [['menu_name'], 'string', 'max' => 30],
            [['series_name', 'menu_introduce'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stat_shop_id' => '自增ID',
            'menu_name' => '门店名称',
            'series_name' => 'Series Name',
            'menu_price' => 'Menu Price',
            'menu_count' => '门店销售额',
            'menu_total' => '门店支出',
            'menu_introduce' => 'Menu Introduce',
            'menu_status' => 'Menu Status',
            'created_at' => '记录时间',
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
          $orderby = ['created_at'=>SORT_DESC,'menu_name'=>SORT_ASC];
        }else{
          $orderby = ['created_at'=>SORT_ASC,'menu_name'=>SORT_ASC];
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
            ->from('zss_stat_menu')
            ->where('created_at>=:start_time and created_at<=:end_time and menu_name like :word',
              [':start_time'=>$start_time,':end_time'=>$end_time,':word'=>'%'.$word."%"])
            ->orderBy(['created_at'=>SORT_DESC,'menu_count'=>SORT_DESC])
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
        'zss_stat_menu',
        ["menu_name","series_name","menu_price","menu_count","menu_total","created_at"],
        $add
      )->execute();
    }

    /**
     * @inheritdoc  菜品折线图 处理$data为折线图所需数据返回
     * @params  $data array  折线图所需数据
     */
    public function line_chart($data)
    {
      //print_r($data);die;
      //各自取出时间和门菜品及菜品对应的厨师
      foreach($data as $k=>$v){
        $time[$k]=$v['created_at'];
        $menu_name[$k]=$v['menu_name'] . "(" . $v['series_name'] .")";
        $series_name[$k]=$v['series_name'];
      }
      //去重
      $time = array_unique($time);
      $menu_name = array_unique($menu_name);

      //把$menu_name的键值从字符串转化成数字
      foreach($menu_name as $k=>$v){
        $menu_names[] = $v;
      }
      //时间反转 时间正序
      sort($time);
      //$data数据反转 配合时间的反转
      krsort($data);
      //处理后获得 折线图所需json数据
      foreach($menu_names as $k=>$v){
        $menu_info[$k]['name'] = $v;
        foreach($time as $kkk=>$vvv){
          $menu_info[$k]['data'][] = 0;
        }
        foreach($data as $kk=>$vv){
          if($vv['menu_name'] . "(" . $vv['series_name'] .")" == $v){
            foreach($time as $kkk=>$vvv){
              if($vv['created_at'] == $vvv){
                $menu_info[$k]['data'][$kkk] = floatval($vv['menu_count']);
              }
            }
          }
        }
        if($k == 9){
          break;
        }
      }
      //print_r($menu_info);die;
  		$info['menu_info'] = json_encode($menu_info);
  		$info['time'] = json_encode($time);
      //两个json数据一起返回
      return $info;
    }

    /**
     * @inheritdoc  本店本日各菜品消费情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     */
    public function pie_menus_chart($date)
    {
      $statmenu = new StatMenu();
      $menu_info = $statmenu->find_all(['menu_name','series_name','menu_total'],['created_at'=>$date]);
      $sum = 0;
      foreach($menu_info as $k=>$v){
        $sum += $v['menu_total'];
      }
      foreach($menu_info as $k=>$v){
        $pie[$k]['name'] = $v['menu_name'] . "(" . $v['series_name'] . ")";
        if($sum == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['menu_total']*100/$sum;
        }
      }
      $pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  各门店本日消费额饼图 制作所需数据返回
     * @params  $date date  本日日期
     */
    public function pie_shop_chart($menu_id,$shop_ids,$date)
    {
      $order = new Order();
      foreach($shop_ids as $k=>$v){
        $info = $order->find()
              ->select(['shop_id','SUM(order_total) as total'])
              ->innerJoin('zss_order_info','zss_order.order_id=zss_order_info.order_id')
              ->where(['menu_id'=>$menu_id,'shop_id'=>$v['shop_id'],'zss_order.created_at'=>$date])
              ->groupBy(['shop_id'])
              ->asArray()
              ->one();
        if(empty($info)){
          $info['shop_name'] =  $v['shop_name'];
          $info['total'] = 0;
        }
        $info['shop_name'] =  $v['shop_name'];
        $infos[] = $info;
      }
      $sum = 0;
      foreach($infos as $k=>$v){
        $sum += $v['total'];
      }
  		foreach($infos as $k=>$v){
  			$pie[$k]['name'] = $v['shop_name'];
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
     */
    public function pie_shop_menu_chart($shop_id,$date)
    {
      //echo $shop_id;
      $menu = new Menu();
      $menu_info = $menu
              ->find()
              ->select(['zss_series.series_id','zss_series.series_name','zss_menu.menu_name','zss_series.series_name',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_series','zss_menu.series_id=zss_menu.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_menu.menu_id')
              ->where(['zss_shop.shop_id'=>$shop_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
              ->asArray()
              ->all();
      if(empty($menu_info)){
        return json_encode(array(array('name'=>'无此详情','y'=>0)));
      }
      $sum = 0;
      foreach($menu_info as $k=>$v){
        $sum += $v['SUM(zss_order_info.menu_num*zss_order_info.menu_price)'];
      }
      foreach($menu_info as $k=>$v){
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
}
