<?php

namespace backend\models\operate;

use Yii;
use backend\models\operate\StatMenu;
use backend\models\menu\Menu;

/**
 * This is the model class for table "{{%stat_shop}}".
 *
 * @property integer $stat_shop_id
 * @property string $shop_name
 * @property string $shop_sale
 * @property string $shop_expend
 * @property string $created_at
 */
class StatShop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_sale', 'shop_expend'], 'number'],
            [['created_at'], 'safe'],
            [['shop_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stat_shop_id' => '自增ID',
            'shop_name' => '门店名称',
            'shop_sale' => '门店销售额',
            'shop_expend' => '门店支出',
            'created_at' => '记录时间',
        ];
    }

    /**
     * @inheritdoc 单条查询
     * @params  $where  array 查询条件
     */
    public function find_one($where,$params = '*')
    {
        return $this->find()->select($params)->where($where)->asArray()->one();
    }

    /**
     * @inheritdoc  查询所有
     * @params $filed  array 字段列表
     * @params $where  array 查询条件
     */
    public function find_all($filed = "*",$where = '')
    {
        if(count($where) == 3){
          $orderby = ['created_at'=>SORT_DESC,'shop_name'=>SORT_ASC];
        }else{
          $orderby = ['created_at'=>SORT_ASC,'shop_name'=>SORT_ASC];
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
            ->from('zss_stat_shop')
            ->where('created_at>=:start_time and created_at<=:end_time and shop_name like :word',
              [':start_time'=>$start_time,':end_time'=>$end_time,':word'=>'%'.$word."%"])
            ->orderBy(['created_at'=>SORT_DESC,'shop_name'=>SORT_ASC])
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
        'zss_stat_shop',
        ['shop_name','shop_address','shop_tel','created_at','shop_expend','shop_sale','shop_turnover'],
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
          ->select(['shop_name','count(shop_turnover) as count','created_at'])
          ->groupBy(['shop_name'])
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
          ->select(['shop_name','count(shop_turnover) as count','created_at'])
          ->groupBy(['shop_name','created_at'])
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
          ->select(['count(shop_turnover) as count'])
          ->asArray()
          ->one();
    }

    /**
     * @inheritdoc  门店折线图 处理$data为折线图所需数据返回
     * @params  $data array  折线图所需数据
     */
    public function line_chart($data)
    {
      //print_r($data);die;
      //各自取出时间和门店名
      foreach($data as $k=>$v){
        $time[$k]=$v['created_at'];
        $shop_name[$k]=$v['shop_name'];
      }
      //去重
      $time = array_unique($time);
      $shop_name = array_unique($shop_name);
      //把$shop_name的键值从字符串转化成数字
      foreach($shop_name as $k=>$v){
        $shop_names[] = $v;
      }
      //时间反转 时间正序
      sort($time);
      //$data数据反转 配合时间的反转
      krsort($data);
      //处理后获得 折线图所需json数据
      foreach($shop_names as $k=>$v){
        $shop_info[$k]['name'] = $v;
        foreach($time as $kkk=>$vvv){
          $shop_info[$k]['data'][] = 0;
        }
        foreach($data as $kk=>$vv){
          if($vv['shop_name'] == $shop_info[$k]['name']){
            foreach($time as $kkk=>$vvv){
              if($vv['created_at'] == $vvv){
                $shop_info[$k]['data'][$kkk] = floatval($vv['shop_turnover']);
              }
            }
          }
        }
        if($k == 9){
          break;
        }
      }
      //print_r($shop_info);die;
  		$info['shop_info'] = json_encode($shop_info);
  		$info['time'] = json_encode($time);
      //两个json数据一起返回
      return $info;
    }

    /**
     * @inheritdoc  各门店本日消费额饼图 制作所需数据返回
     * @params  $date date  本日日期
     */
    public function pie_shops_chart($date)
    {
      $sum = $this->find_one(['created_at'=>$date],['SUM(shop_turnover) AS sum']);
  		$shop_all = $this->find_all(['shop_name','shop_turnover'],['created_at'=>$date]);
  		foreach($shop_all as $k=>$v){
        // if($v['shop_turnover'] > 0){
        //   $pie[$k]['sliced'] = true;
        //   $pie[$k]['selected'] = true;
        // }
  			$pie[$k]['name'] = $v['shop_name'];
        if($sum['sum'] == 0){
          $pie[$k]['y'] = 0;
        }else{
    			$pie[$k]['y'] = $v['shop_turnover']*100/$sum['sum'];
        }
  		}
      //print_r($pie);die;
  		$pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  本店本日各菜品消费情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     */
    public function pie_menus_chart($menu,$created_at)
    {
      if(!empty($menu)){
        $statmenu = new StatMenu();
        foreach($menu as $k=>$v){
          $menu_info[] = $statmenu->find_one(['menu_name'=>$v['menu_name'],'series_name'=>$v['series_name'],'created_at'=>$created_at]);
        }
        $sum = 0;
        foreach($menu_info as $k=>$v){
          $sum += $v['menu_total'];
        }
        //$shop_all = $this->find_all(['shop_name','shop_turnover'],['created_at'=>$created_at]);
        foreach($menu_info as $k=>$v){
          $pie[$k]['name'] = $v['menu_name'] . "(" . $v['series_name'] . ")";
          if($sum == 0){
            $pie[$k]['y'] = 0;
          }else{
      			$pie[$k]['y'] = $v['menu_total']*100/$sum;
          }
        }
      }else{
        $pie[0]['name'] = "无菜品";
        $pie[0]['y'] = 0;
      }
      $pie = json_encode($pie);
      return $pie;
    }

    /**
     * @inheritdoc  本菜品本日各门店营业情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     * @params  $menu_id int  菜品id
     */
    public function pie_menu_shop_chart($menu_id,$date)
    {
      //echo $shop_id;
      $menu = new Menu();
      $menu_info = $menu
              ->find()
              ->select(['zss_series.series_id','zss_series.series_name','zss_series.series_name','zss_shop.shop_name',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_series','zss_menu.series_id=zss_series.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_shop.shop_id')
              ->where(['zss_menu.menu_id'=>$menu_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
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

    /**
     * @inheritdoc  本菜品本日各门店营业情况饼图 制作所需数据返回
     * @params  $date date  本日日期
     * @params  $menu_id int  菜品id
     */
    public function pie_menu_type_chart($menu_id,$date)
    {
      //echo $shop_id;
      $menu = new Menu();
      $menu_info = $menu
              ->find()
              ->select(['zss_series.series_id','zss_menu.menu_name','zss_series.series_name','zss_series.series_name','zss_order.delivery_type',
                        'SUM(zss_order_info.menu_num*zss_order_info.menu_price)','zss_order.order_id','zss_shop.shop_id',
                        "FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"])
              ->innerJoin('zss_series','zss_menu.series_id=zss_series.series_id')
              ->innerJoin('zss_order_info','zss_menu.menu_id=zss_order_info.menu_id')
              ->innerJoin('zss_order','zss_order_info.order_id=zss_order.order_id')
              ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
              ->groupBy('zss_order.delivery_type')
              ->where(['zss_menu.menu_id'=>$menu_id,"FROM_UNIXTIME(zss_order.created_at,'%Y-%m-%d')"=>$date])
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
        if($v['delivery_type'] == 1){
          $shop_name = '送货';
        }else if($v['delivery_type'] == 2){
          $shop_name = '堂食';
        }if($v['delivery_type'] == 3){
          $shop_name = '自取';
        }
        $pie[$k]['name'] = $shop_name;
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
