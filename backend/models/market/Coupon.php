<?php

namespace backend\models\market;

use Yii;
use backend\models\series\Series;
/**
 * This is the model class for table "{{%coupon}}".
 *
 * @property integer $coupon_id
 * @property string $coupon_name
 * @property string $coupon_price
 * @property string $coupon_type
 * @property string $menu_id
 * @property integer $coupon_show
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $end_at
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_price'], 'number'],
            [['coupon_show', 'created_at', 'updated_at', 'end_at'], 'integer'],
            [['coupon_name'], 'string', 'max' => 150],
            [['coupon_type', 'menu_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coupon_id' => '优惠券自增id',
            'coupon_name' => '优惠券名称',
            'coupon_price' => '优惠券可抵用',
            'coupon_type' => '类下的优惠',
            'menu_id' => '优惠菜品的id',
            'coupon_show' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'end_at' => '到期时间',
        ];
    }
	//查询表内的所有优惠
	public function select()
	{
		 return $this->find()
			 ->select(["zss_coupon.created_at",
			 "zss_coupon.coupon_id",
			 "zss_coupon.coupon_name",
			 "zss_coupon.coupon_price",
			 "zss_admin.username",
			 "zss_coupon.updated_at",
			  "zss_coupon.coupon_show",
			 "zss_coupon.coupon_type",
			 "zss_coupon.menu_id",
			 "zss_coupon.end_at",
			 ])
			 ->innerjoin("`zss_admin` on zss_coupon.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->all();
	}

	//查询表内的所有优惠
	public function selectwhere($sea)
	{
		 return $this->find()
			 ->select(["zss_coupon.created_at",
			 "zss_coupon.coupon_id",
			 "zss_coupon.coupon_name",
			 "zss_coupon.coupon_price",
			 "zss_admin.username",
			 "zss_coupon.updated_at",
			  "zss_coupon.coupon_show",
			 "zss_coupon.coupon_type",
			 "zss_coupon.menu_id",
			 "zss_coupon.end_at",
			 ])
			 ->innerjoin("`zss_admin` on zss_coupon.`updated_id` = `zss_admin`.`id`")
			 ->where(["like","zss_coupon.coupon_name",$sea])
			 ->asArray()
			 ->all();
	}

	//删除选中的优惠
	public function delOne($id){
		return $this->findOne($id)->delete();
	}

	//添加优惠
	public function addCoupon($data)
	{
		$str = "";
		//判断获取到的菜品、分类列表的数值
		if($data['coupon_type'] == 1){
			if(empty($data['list1'])){
				foreach($data['list2'] as $k=>$v){

					$str .= ",".$v;

				}

			$coupon_type = ltrim($str,",");
			$menu_id = "";

			}else{

				foreach($data['list1'] as $k=>$v){
					$str .= ",".$v;

				}
			$menu_id = ltrim($str,",");
			$coupon_type = "";
			}

		}

		if($data['coupon_type'] == 2){

			if(empty($data['list2'])){

				foreach($data['list1'] as $k=>$v){
					$str .= ",".$v;

				}
			$menu_id = ltrim($str,",");
			$coupon_type = "";

			}else{

				foreach($data['list2'] as $k=>$v){
					$str .= ",".$v;

				}
			$coupon_type = ltrim($str,",");
			$menu_id = "";
			}

		}
		
		if($data['coupon_type'] == 3){
			$coupon_type = 'all';
			$menu_id = 'all';
		}	
		//判断结束
		#添加数据
		$this->coupon_type = $coupon_type;
		$this->menu_id = $menu_id;
		$this->coupon_name = htmlspecialchars($data['CouponForm']['coupon_name']);
		$this->coupon_price = $data['CouponForm']['coupon_price'];
		$this->coupon_show = $data['coupon_show'];
		$this->updated_id = Yii::$app->user->identity->id;//修改人
		$this->end_at = strtotime($data['CouponForm']['end_time']);
		$this->created_at = time();
		$this->updated_at = time();
		return $this->save();
	 }

	 //获取要修改的一条数据的信息
	 public function getOne($id)
	{
		return $this->findOne($id);
	 }



	 //修改选中优惠

	 public function update_coupon($data,$id)
	{
		$coupon = $this->findOne($id);
		$str = "";
		//判断获取到的菜品、分类列表的数值
		if($data['coupon_type'] == 1){
			if(empty($data['list1'])){
				foreach($data['list2'] as $k=>$v){

					$str .= ",".$v;

				}

			$coupon_type = ltrim($str,",");
			$menu_id = "";

			}else{

				foreach($data['list1'] as $k=>$v){
					$str .= ",".$v;

				}
			$menu_id = ltrim($str,",");
			$coupon_type = "";
			}

		}

		if($data['coupon_type'] == 2){

			if(empty($data['list2'])){

				foreach($data['list1'] as $k=>$v){
					$str .= ",".$v;

				}
			$menu_id = ltrim($str,",");
			$coupon_type = "";

			}else{

				foreach($data['list1'] as $k=>$v){
					$str .= ",".$v;

				}
			$coupon_type = ltrim($str,",");
			$menu_id = "";
			}

		}
		
		if($data['coupon_type'] == 3){
			$coupon_type = 'all';
			$menu_id = 'all';
		}	


		$coupon->coupon_type = $coupon_type;
		$coupon->menu_id = $menu_id;
		$coupon->coupon_name = htmlspecialchars($data['CouponForm']['coupon_name']);
		$coupon->coupon_price = $data['CouponForm']['coupon_price'];
		$coupon->coupon_show = $data['coupon_show'];
		$coupon->updated_id = Yii::$app->user->identity->id;//修改人
		$coupon->end_at = strtotime($data['CouponForm']['end_time']);	
		$coupon->updated_at = time();

		return $coupon->save();
	 }


	 //修改一条数据的的显示状态
	 public function ChangeOneShow($data)
	{
		$coupon = $this->findOne($data['id']);
		if($data['show'] == 1){
			$coupon->coupon_show = 0;
		}
		if($data['show'] == 0){
			$coupon->coupon_show = 1;
		}
		return $coupon->save();

	 }

	 //获得选中优惠的详细信息
	public function getOneinfo($data)
	{
		 $id = $data['id'];
		 $couponinfo = $this->find()
			 ->select(["zss_coupon.created_at",
			 "zss_coupon.coupon_id",
			 "zss_coupon.coupon_name",
			 "zss_coupon.coupon_price",
			 "zss_admin.username",
			 "zss_coupon.updated_at",
			  "zss_coupon.coupon_show",
			 "zss_coupon.coupon_type",
			 "zss_coupon.menu_id",
			 "zss_coupon.end_at",
			 ])
			 ->where(['zss_coupon.coupon_id'=>$id])
			 ->innerjoin("`zss_admin` on zss_coupon.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->One();
		 if($couponinfo['coupon_show']==1){
			$couponinfo['coupon_show'] = "是";
		 }
		 if($couponinfo['coupon_show']==0){
			$couponinfo['coupon_show'] = "否";
		 }
		 $created_at = date('Y-m-d',$couponinfo['created_at']);
		 $updated_at = date('Y-m-d',$couponinfo['updated_at']);
		 $end_at = date('Y-m-d',$couponinfo['end_at']);
		 $couponinfo['created_at'] = $created_at;
		 $couponinfo['updated_at'] = $updated_at;
		 $couponinfo['end_at'] = $end_at;
		
		
		$menu = new Menu();
		 if(!empty($couponinfo['menu_id']) && empty($couponinfo['coupon_type'])){
			 $id = $couponinfo['menu_id'];
   			 $menuinfo = $menu->find()
				 ->select("zss_menu.menu_name")
				 ->where("menu_id in ($id)")
				 ->asArray()
				 ->all();
			 $str ="";
			 foreach($menuinfo as $k=>$v){
				$str .= ",".$v['menu_name'];
			 }
				$couponinfo['type'] = $str;
			}
		$series = new Series();
		 if(empty($couponinfo['menu_id']) && !empty($couponinfo['coupon_type'])){
			 $id = $couponinfo['coupon_type'];
   			 $menuinfo = $series->find()
				 ->select("zss_series.series_name")
				 ->where("series_id in ($id)")
				 ->asArray()
				 ->all();
			 $str ="";
			 foreach($menuinfo as $k=>$v){
				$str .= ",".$v['series_name'];
			 }
				$couponinfo['type'] = $str;
		}

		if(!empty($couponinfo['menu_id']) && !empty($couponinfo['coupon_type'])){
			$couponinfo['type'] = "全部";
		}
			 return $couponinfo;
	}
	 //批量删除优惠券
	 public function delmore($str)
	{
		return $this->deleteAll(["in","coupon_id",$str]);
	 }
}
