<?php

namespace backend\models\order;

use Yii;
use backend\models\user\User;
use backend\models\operate\StatShop;
use backend\models\operate\StatMenu;
use backend\models\operate\StatSeries;
use backend\models\series\Series;
use backend\models\shop\Shop;
use backend\models\menu\Menu;
/**
 * This is the model class for table "{{%order}}".
 * 
 * @property integer $order_id
 * @property integer $order_sn
 * @property integer $user_id
 * @property string $order_freight
 * @property integer $delivery_type
 * @property string $order_address
 * @property integer $seat_number
 * @property string $user_name
 * @property string $user_phone
 * @property string $order_payment
 * @property string $order_total
 * @property integer $pay_type
 * @property integer $pay_status
 * @property integer $pay_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order_status
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'user_id', 'delivery_type', 'seat_number', 'pay_type', 'pay_status', 'pay_at', 'created_at', 'updated_at', 'order_status'], 'integer'],
            [['order_freight', 'order_payment', 'order_total'], 'number'],
            [['order_address', 'user_name'], 'string', 'max' => 30],
            [['user_phone'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'order_freight' => 'Order Freight',
            'delivery_type' => 'Delivery Type',
            'order_address' => 'Order Address',
            'seat_number' => 'Seat Number',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'order_payment' => 'Order Payment',
            'order_total' => 'Order Total',
            'pay_type' => 'Pay Type',
            'pay_status' => 'Pay Status',
            'pay_at' => 'Pay At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_status' => 'Order Status',
        ];
    }

  /**
     * @inheritdoc  查询订单列表
     */
  function order_list($where='')
  {
    return $this->find()
        ->select(["order_id","order_sn","zss_order.user_phone","delivery_type","seat_number","meal_number","order_payment","order_total","pay_type","pay_status","zss_order.created_at","zss_order.updated_at","order_status","site_name as user_name","site_phone as user_phone","delivery_type","payonoff","zss_order.shop_id"])
        ->addSelect(['zss_order.user_name as name'])
        ->leftJoin("zss_site","zss_order.order_address = zss_site.site_id")
        ->orderBy(['order_id'=>SORT_DESC])
        ->where($where)
        ->asArray()
        ->all();
  }

  /**
     * @inheritdoc  查询个人订单
   * @ type 优惠类型
   * @param 红包
   * @param 折扣
   * @param 满减
   * @param 优惠券
     */
   function personal_order($id)
  {
    return $list = $this->find()
        ->select(["order_id","order_sn","zss_order.user_id","zss_order.shop_id","order_freight","delivery_type","order_address","seat_number","meal_number","zss_order.user_phone","order_payment","order_total","zss_order.gift_id","pay_type","pay_status","pay_at","zss_order.created_at","zss_order.updated_at","order_status","shop_name","shop_address","shop_tel","gift_name","zss_order.user_name as name","zss_order.wallet","zss_order.sub","zss_order.msg","zss_order.coupon","site_name as user_name","site_phone as user_phone","delivery_type","site_detail as order_address","payonoff","wallet","sub","coupon"])
        ->addSelect(['zss_order.user_name as name'])
        ->addSelect(['subtract_price','subtract_subtract'])
        ->addSelect(['coupon_name','coupon_price'])
        ->leftJoin("zss_site","zss_order.order_address = zss_site.site_id")
        ->leftJoin("`zss_shop` on `zss_shop`.`shop_id` = `zss_order`.`shop_id`")
        ->leftJoin("`zss_gift` on `zss_gift`.`gift_id` = `zss_order`.`gift_id`")
        ->leftJoin("zss_subtract","zss_subtract.subtract_id = zss_order.sub")
        ->leftJoin("zss_coupon","zss_coupon.coupon_id = zss_order.coupon")
        ->where(['zss_order.order_id'=>$id])
        ->asArray()
        ->one();
  }

  /**
     * @inheritdoc  查询个人订单
   * @parameter  pay_type 支付方式
   * @parameter  order_status 订单状态
   * @parameter  delivery_type 派送类型
     */
  function search_order($data,$admin)
  {
    $andwhere = array();
    if(!empty($admin))
    {
      $shop_id = $this->shop_id($admin);
      $andwhere["shop_id"] = $shop_id;
    }
    $where = array();
    if(!empty($data['pay_type']))
    {
      $where['payonoff'] = $data['pay_type'];
    }
    if(!empty($data['pay_status']) || $data['pay_status']==0)
    {
      $where['order_status'] = $data['pay_status'];
    }
    if(!empty($data['delivery_type']))
    {
      $where['delivery_type'] = $data['delivery_type'];
    }
    return $this->find()
        ->select(["order_id","order_sn","zss_order.user_phone","delivery_type","seat_number","meal_number","order_payment","order_total","pay_type","pay_status","zss_order.created_at","zss_order.updated_at","order_status","site_name as user_name","site_phone as user_phone","delivery_type","payonoff"])
        ->addSelect(['zss_order.user_name as name'])
        ->leftJoin("zss_site","zss_order.order_address = zss_site.site_id")
        ->where($where)
        ->andWhere($andwhere)
        ->asArray()
        ->all();
  }

  /**
   * @inheritdoc  模糊查询订单详细信息
   */
   function like_order($data,$admin)
  {
     $andwhere = array();
    if(!empty($admin))
    {
      $shop_id = $this->shop_id($admin);
      $andwhere["shop_id"] = $shop_id;
    }
     if(empty($data['start_time']))
    {
      $start_time = strtotime("1970-01-01 08:00:00");
    }
    else
    {
      $start_time = strtotime($data['start_time']);
    }
    if(empty($data['end_time']))
    {
      $end_time = time();
    }
    else
    {
      $end_time = strtotime($data['end_time']);
    }
    if($data['word'])
    {

      return $result= $this->find()
          ->select(["zss_order.order_id","order_sn","zss_order.user_phone","delivery_type","seat_number","meal_number","order_payment","order_total","pay_type","pay_status","zss_order.created_at","zss_order.updated_at","order_status","type_name","site_name as user_name","site_phone as user_phone","delivery_type"])
          ->addSelect(['zss_order.user_name as name'])
          ->leftJoin("zss_site","zss_order.order_address = zss_site.site_id")
          ->orderBy(['order_id'=>SORT_DESC])
          ->where(['between', 'zss_order.created_at',$start_time,$end_time])
          ->andWhere(['like', "zss_order.order_sn", $data['word']])
          ->orWhere(['like', "site_phone", $data['word']])
          ->orWhere(['like', "site_name", $data['word']])
          ->andWhere($andwhere)
          ->asArray()
          ->all();
    }
    else
    {
      return $result= $this->find()
          ->select(["zss_order.order_id","order_sn","zss_user.user_name","zss_order.user_phone","delivery_type","seat_number","meal_number","order_payment","order_total","pay_type","pay_status","zss_order.created_at","zss_order.updated_at","order_status","type_name"])
          ->addSelect(['zss_order.user_name as name'])
          ->innerJoin("`zss_user` on `zss_order`.`user_id` = `zss_user`.`user_id`")
          ->leftJoin("`zss_type` on `zss_order`.`delivery_type` = `zss_type`.`type_id`")
          ->orderBy(['order_id'=>SORT_DESC])
          ->where(['between', 'zss_order.created_at',$start_time,$end_time])
          ->asArray()
          ->all();
    }

  }

  /**
  *@门店名称
  */
  function shop_list($shop_id)
  {
    foreach($shop_id as $key=>$val)
    {
      $shop = (new \yii\db\Query())    
        ->select(['shop_id', 'shop_name'])    
        ->from('zss_shop')
        ->where(['shop_id'=>$val])
        ->one();
      if($shop)
      {
        $data[$key] = $shop;
      }
    }
    
    return $data;
  }

    /**
     * @params inheritdoc  门店财务统计
     * @params $date  date  日期
     */
    public function stat_shop($date)
    {
      $statshop = new StatShop();
      $exise = $statshop->find_one(['created_at'=>$date]);
      if(!empty($exise)){
        return ;
      }
      //筛选数据
      $list = $this
          ->find()
          ->from('zss_order o')
          ->select(
            ["s.shop_name","s.shop_address","s.shop_tel",
            "FROM_UNIXTIME(o.created_at,'%Y-%m-%d') AS created_at",
            "SUM(g.gift_price) as shop_expend","SUM(o.order_payment) AS shop_sale"]
            )
          ->innerJoin('zss_shop as s','o.shop_id = s.shop_id')
          ->leftJoin('zss_gift as g','o.gift_id = g.gift_id')
          ->where(['o.order_status'=>3,"FROM_UNIXTIME(o.created_at,'%Y-%m-%d')"=>$date])
          ->groupBy("created_at,shop_name")
          ->orderBy(['o.created_at'=>SORT_ASC,'s.shop_name'=>SORT_ASC])
          ->asArray()
          ->all();
      //查询主表 显示数组
      $shop = new Shop();
      $shop_info = $shop->find_all(["shop_name","shop_address","shop_tel"]);
      foreach($shop_info as $ks=>$vs){
        //拼接入库字段
        $shop_info[$ks]['created_at'] = $date;
        $shop_info[$ks]['shop_expend'] = "0.00";
        $shop_info[$ks]['shop_sale'] = "0.00";
        $shop_info[$ks]['shop_turnover'] = "0.00";
      }
      //判断数据 当期日期是否有销售额 入库
      if(!empty($list)){
        //将有销售额的数组进行拼接
        foreach($shop_info as $ks=>$vs){
          foreach($list as $kl=>$vl){
            if($vl['shop_name'] == $vs['shop_name']){
              $vl['shop_turnover'] = $vl['shop_sale'] - $vl['shop_expend'];
              $shop_info[$ks] = $vl;
            }
          }
        }
      }
      //数据批量入库
      return $statshop->add_all($shop_info,$date);
    }

    /**
     * @params inheritdoc  门店菜单数据统计
     * @params $date  date  日期
     */
    public function stat_menu($date)
    {
      $statmenu = new StatMenu();
      $exise = $statmenu->find_one(['created_at'=>$date]);
      if(!empty($exise)){
        return ;
      }
      //筛选数据
      $list = $this
          ->find()
          ->from('zss_order o')
          ->select(["m.menu_id","m.menu_name","s.series_name","m.menu_price","count(i.menu_num) as menu_count"])
          ->innerJoin('zss_order_info as i','o.order_id = i.order_id')
          ->innerJoin('zss_menu as m','i.menu_id = m.menu_id')
          ->innerJoin('zss_series as s','m.series_id = s.series_id')
          ->where(['o.order_status'=>3,"FROM_UNIXTIME(o.created_at,'%Y-%m-%d')"=>$date])
          ->groupBy("menu_id")
          ->orderBy(['menu_count'=>SORT_DESC])
          ->asArray()
          ->all();
      //print_r($list);die;
      //查询主表 显示数组
      $menu = new Menu();
      $menu_info = $menu->find_all(["menu_name","series_name","menu_price"]);
      foreach($menu_info as $km=>$vm){
        //拼接入库字段
        $menu_info[$km]['menu_count'] = 0;
        $menu_info[$km]['menu_total'] = 0;
        $menu_info[$km]['created_at'] = $date;
      }
      //判断数据 当期日期是否有销售额 入库
      if(!empty($list)){
        //将有销售额的数组进行拼接
        foreach($menu_info as $km=>$vm){
          foreach($list as $kl=>$vl){
            if($vl['menu_name'] == $vm['menu_name'] && $vl['series_name'] == $vm['series_name']){
              $vl['menu_total'] = $vl['menu_price'] * $vl['menu_count'];
              $menu_info[$km] = $vl;
            }
            $menu_info[$km]['created_at'] = $date;
            unset($menu_info[$km]['menu_id']);
          }
        }
      }
      //数据批量入库
      return $statmenu->add_all($menu_info);
    }

    /**
     * @params inheritdoc  分类数据统计
     * @params $date  date  日期
     */
    public function stat_series($date)
    {
      $statseries = new StatSeries();
      $exise = $statseries->find_one(['created_at'=>$date]);
      if(!empty($exise)){
        return ;
      }
      //筛选数据
      $list = $this
          ->find()
          ->from('zss_order o')
          ->select(["m.menu_id","s.series_name","SUM(i.menu_price) as series_turnover"])
          ->innerJoin('zss_order_info as i','o.order_id = i.order_id')
          ->innerJoin('zss_menu as m','i.menu_id = m.menu_id')
          ->innerJoin('zss_series as s','m.series_id = s.series_id')
          ->where(['o.order_status'=>3,"FROM_UNIXTIME(o.created_at,'%Y-%m-%d')"=>$date])
          ->groupBy("series_name")
          ->orderBy(['series_turnover'=>SORT_DESC])
          ->asArray()
          ->all();
      //查询主表 显示数组
      $series = new Series();
      $series_info = $series->find_all(["series_name","series_name"]);
      foreach($series_info as $km=>$vm){
        //拼接入库字段
        $series_info[$km]['series_turnover'] = 0;
        $series_info[$km]['created_at'] = $date;
      }
      //print_r($series_info);die;
      //判断数据 当期日期是否有销售额 入库
      if(!empty($list)){
        //将有销售额的数组进行拼接
        foreach($series_info as $km=>$vm){
          foreach($list as $kl=>$vl){
            if($vl['series_name'] == $vm['series_name']){
              $series_info[$km] = $vl;
            }
            $series_info[$km]['created_at'] = $date;
            unset($series_info[$km]['menu_id']);
          }
        }
      }
      //数据批量入库
      return $statseries->add_all($series_info);
    }

  /**
     * @inheritdoc  查看门店订单
     */
  function shop_id($id)
  {
    $arr = (new \yii\db\Query())    
        ->select(['shop_id'])    
        ->from('zss_admin')
        ->leftJoin("zss_admin_shop", 'zss_admin_shop.admin_id = zss_admin.id')
        ->where(['zss_admin.id' => $id])    
        ->all();
        if($arr){
          $shop_id = array();
        foreach($arr as $val)
        {
          $shop_id[] = $val['shop_id'];
        }
        return $shop_id;
        }
        
  }

  /**
   * 检测是否有订单响起音乐
   */
  
  public function order_status($arr){

    return $this->find()
          ->where($arr)
          ->asArray()
          ->all();
  }


  /**
   * 更改打印状态
   */
  function printer($id){
    return $this->updateall(["order_status"=>2],["order_id"=>$id]);
  }
  

}
