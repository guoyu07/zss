<?php

namespace backend\models\shop;

use Yii;
use backend\models\shop\AdminDistribution;
/**
 * This is the model class for table "{{%shop}}".
 *
 * @property integer $shop_id
 * @property string $shop_name
 * @property integer $shop_status
 * @property string $shop_x
 * @property string $shop_y
 * @property string $shop_address
 * @property string $shop_tel
 * @property integer $created_at
 * @property integer $updated_at
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_status', 'created_at', 'updated_at'], 'integer'],
            [['shop_x', 'shop_y'], 'number'],
            [['shop_name'], 'string', 'max' => 100],
            [['shop_address'], 'string', 'max' => 255],
            [['shop_tel'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shop_id' => 'Shop ID',
            'shop_name' => 'Shop Name',
            'shop_status' => 'Shop Status',
            'shop_x' => 'Shop X',
            'shop_y' => 'Shop Y',
            'shop_address' => 'Shop Address',
            'shop_tel' => 'Shop Tel',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

	/**
	 * @inheritdoc  读取所有管理员
	 */
	 public function admin()
	{
		 return $admin = (new \yii\db\Query())->select(['id', 'username'])->where(["type"=>2])->from('zss_admin')->all();
	 }

	 /**
	 *@Action 取得所有配送员
	 */
	 public function all_deli($id)
	{
		$all = (new \yii\db\Query())->select(['id', 'username'])->from('zss_admin')->where(["type"=>3])->all(); //取得所有的配送员
		$no_del = AdminDistribution::findBySql('SELECT * FROM zss_admin_distribution Where shop_id != '.$id)->asArray()->all();//取得别家店已经匹配的外卖员
		$ids = array();
		foreach($no_del as $value)
		{
			$ids[] = $value['admin_id'];
		}
		foreach($all as $key=>$value)
		{
			if(in_array($value['id'],$ids))
			{
				unset($all[$key]);
			}
		}
		return $all;

	}

	/**
	*@Action 
	**/
	public function in_deli($id)
	{
		$in_del = AdminDistribution::findBySql('SELECT * FROM zss_admin_distribution Where shop_id = '.$id)->asArray()->all();//取得本家的的外卖员
		if(!is_array($in_del))
		{
			return array();
		}
		$ids = array();
		foreach($in_del as $key=>$value)
		{
			$ids[] = $value['admin_id'];
		}
		return $ids;
	}

	/**
	 * @inheritdoc  门店添加
	 */
	 public function add($data)
	{
		$obj = new Shop();
		$obj->updated_id = Yii::$app->user->identity->id;
		$obj->shop_name = $data['shop_name'];
		$obj->shop_status = $data['shop_status'];
		$obj->shop_address =  $data['shop_address'];
		$obj->shop_tel =  $data['shop_tel'];
		$obj->shop_x =  $data['shop_x'];
		$obj->shop_y =  $data['shop_y'];
		$obj->add_id =  $data['add_id'];
		$obj->subtract_id =  $data['subtract_id'];
		$obj->distribution =  $data['distribution'];
		$obj->lunchbox =  $data['lunchbox'];
		$obj->updated_at =  time();
		$obj->created_at =  time();
		$result = $obj->save();
		if(!$result)
		{
			return false;
		}
		else
		{
			$shop_id = $obj->attributes['shop_id'];
			if(isset($data['admin']))
			{
				foreach($data['admin'] as $val)
				{
					$db = Yii::$app->db;
					$st = $db->createCommand("INSERT INTO zss_admin_shop (shop_id,admin_id) VALUES ($shop_id,$val)");
					$re = $st->execute();
				}
				return $re;
			}
			return true;
		}
	}


    /**
     * @inheritdoc  门店列表
     */
    public function shop_list()
    {
		return $this->find()
				->select("username,shop_name,shop_id,shop_status,shop_x,shop_y,shop_address,shop_tel,zss_shop.created_at,zss_shop.updated_at")
				->innerJoin("`zss_admin` on `zss_shop`.`updated_id` = `zss_admin`.`id`")
				->asArray()
				->all();
    }

    /**
     * @inheritdoc  门店删除
     */
    public function shop_delete($id)
    {
        $model = Shop::findOne($id);
		return $model->delete();
    }

    /**
     * @inheritdoc  门店修改
     */
    public function shop_update($data)
    {
        $shop_id = $data['id'];//门店id
        $re = Shop::updateAll([
				'updated_id'=>Yii::$app->user->identity->id,
				'shop_name'=>$data['shop_name'],
				'shop_status'=>$data['shop_status'],
				'shop_x'=>$data['shop_x'],
				'shop_y'=>$data['shop_y'],
				'shop_address'=>$data['shop_address'],
				'shop_tel'=>$data['shop_tel'],
				'updated_at'=>time()
			],['shop_id'=>$shop_id]);
		//店长更改
		if($re)
		{
			$db = Yii::$app->db;
			$st = $db->createCommand("DELETE FROM zss_admin_shop WHERE shop_id=:shop_id",[':shop_id' => $shop_id]);
			$re = $st->execute();
			if(isset($data['admin']))
			{
				foreach($data['admin'] as $val)
				{
					$st = $db->createCommand("INSERT INTO zss_admin_shop (admin_id,shop_id) VALUES ($val,$shop_id)");
					$re = $st->execute();
				}
				return $re;
			}
			return true;
		}
		else
		{
			return false;
		}
    }

    /**
     * @inheritdoc  门店编辑
	 * @param  $id 门店id
     */
    public function shop_edit($id)
    {
       $result = $this->find()->where(['shop_id' => $id])->asArray()->one();
	   $rows = (new \yii\db\Query())
		   ->select(['admin_id'])
		   ->from('zss_admin_shop')
			->where(['shop_id' => $id])
		   ->all();
	   $shop_admin = array();
	   foreach($rows as $val)
	   {
		   $shop_admin[] = $val['admin_id'];
	   }
		return array_merge($result, array('shop_admin' => $shop_admin));
    }

	/**
   * @params $filed array  字段列表
   */
    public function find_all($filed,$where = "1=1")
    {
      return $this
              ->find()
              ->select($filed)
              ->where($where)
              ->asArray()
              ->all();
    }

	/**
	*@ Action	检查门店唯一
	*/
	function check($data)
	{
		$arr = $this->find()
				->select(['shop_id','shop_name'])
				->where(["shop_name"=>$data['shop_name']])
				->asArray()
				->one();
		if(isset($arr['shop_name']))
		{
			if($arr['shop_name'] == $data['shop_name'] && $arr['shop_id'] == $data['id'])
			{
				return true;
			}
			else if($arr['shop_name'] == $data['shop_name'])
			{
				return false;
			}
			else
			{

				return true;
			}
		}
		else
		{
			return true;
		}
	}

	/**
	*@ Action	查询门店服务类型
	*/
	function type()
	{
		return $data = (new \yii\db\Query())->select(['type_id', 'type_name'])->from('zss_type') ->all();
	}

	/**
	*@ Action	修改门店营业状态
	*/
	function shop_status($data)
	{
		$model = Shop::findOne($data['shop_id']);
		if($data['status']==0)
		{
			$model->shop_status = 1;
		}
		else if($data['status']==1)
		{
			$model->shop_status = 0;
		}
		return $model->save();
	}

	/**
	*@ 批量删除门店
	*/
	function DeleteAll_shop($str)
	{
		return Shop::deleteAll("shop_id in (".$str.")");
	}

	/**
	*@ Action	根据门店的id 查询门店的信息
	*/
	function shop_info($id)
	{
		$list = $this->find()
				->where(["shop_id"=>$id])
				->asArray()
				->one();
		$type= (new \yii\db\Query())->from('zss_shop_type')->where(['shop_id' => $list['shop_id']])->all();
		$shop_type = array();
		foreach($type as $v)
		{
			$shop_type[] = $v['type_id'];
		}
		return array_merge($list, array('shop_type' => $shop_type));
	}

	/**
	*@ Action	Admin 查看门店信息
	*@ param	$id 门店的id
	*/
	function shop($id)
	{
		//门店信息
		$list = $this->find()
				->select('*')
				->leftJoin("zss_add","zss_add.add_id=zss_shop.add_id")
				->leftJoin("zss_subtract","zss_subtract.subtract_id=zss_shop.subtract_id")
				->leftJoin("zss_gift","zss_gift.gift_id=zss_add.gift_id")
				->where(['zss_shop.shop_id' => $id])
				->asArray()
				->one();
		//门店配送类型
		$type= (new \yii\db\Query())->from('zss_shop_type')->where(['shop_id' => $list['shop_id']])->all();
		//取得店长
		$admin = (new \yii\db\Query())
				->select(['id', 'username'])
				->from('zss_admin_shop')
				->innerJoin("zss_admin","zss_admin.id=zss_admin_shop.admin_id")
				->where(['shop_id' => $id])
				->all();
		//合并数组传输
		$shop_type = array();
		foreach($type as $v)
		{
			$shop_type[] = $v['type_id'];
		}
		 $list = array_merge($list, array('shop_type' => $shop_type));
		 $list = array_merge($list, array('admin' => $admin));
		 return $list;
	}

	function userShopId($id)
	{
		return $shop_id = (new \yii\db\Query())
				->select(['shop_id'])
				->from('zss_admin_shop')
				->where(['admin_id' => $id])
				->one();
	}

	/**
	*@ Action	店长更改信息
	*@ Table	zss_shop
	*@ Table	zss_type
	*@ Table	zss_shop_type
	*/
	function update_shop($data)
	{
		//	1. 门店和服务类型处理
		$shop_id = $data['id'];
		$db = Yii::$app->db;
		$st = $db->createCommand("DELETE FROM zss_shop_type WHERE shop_id=:shop_id",[':shop_id' => $shop_id]);
		$re = $st->execute();
		if($data['type_id'])
		{
			foreach($data['type_id'] as $val)
			{
				$st = $db->createCommand("INSERT INTO zss_shop_type (shop_id,type_id) VALUES ($shop_id,$val)");
				$re = $st->execute();
			}
		}
		
		// 3. 修改门店数据
		$model = Shop::findOne($shop_id);
		$model->shop_status = $data['shop_status'];
		$model->shop_x = $data['shop_x'];
		$model->shop_y = $data['shop_y'];
		$model->shop_address = $data['shop_address'];
		$model->shop_tel = $data['shop_tel'];
		$model->updated_at = time();
		$model->updated_id = Yii::$app->user->identity->id;
		$model->takeaway_start_time = strtotime($data['takeaway_start_time']);
		$model->takeaway_end_time = strtotime($data['takeaway_end_time']);
		$model->eat_start_time = strtotime($data['eat_start_time']);
		$model->eat_end_time = strtotime($data['eat_end_time']);
		$model->shop_remark = $data['shop_remark'];
		$model->distribution = $data['distribution'];
		$model->lunchbox = $data['lunchbox'];
		$model->add_id = $data['add_id'];
		$model->subtract_id = $data['subtract_id'];
		return $model->save();

	}

	/**
	 * @inheritdoc  搜索门店
	 * @param  $word 检索关键字
	 */
	 function SearchShop($word)
	{
		 return $this->find()
				->select("username,shop_name,shop_id,shop_status,shop_x,shop_y,shop_address,shop_tel,zss_shop.created_at,zss_shop.updated_at")
				->innerJoin("`zss_admin` on `zss_shop`.`updated_id` = `zss_admin`.`id`")
				->where(['like', 'shop_name', $word])
				->orWhere(['like', 'shop_address', $word])
				->asArray()
				->all();
	}

  /**
   * @params $filed array  字段列表
   */
    public function shop_infos($filed,$where = "1=1")
    {
      $shop = $this->find_all($filed,$where);
      $type = (new \yii\db\Query())->from('zss_shop_type')->select(['type_id'])->where(['shop_id' => $shop[0]['shop_id']])->all();
      if(empty($type)){
        $types = array();
      }else{
        foreach($type as $v){
          $types[] = $v['type_id'];
        }
      }

      $shop[0]['type'] = $types;
      $admin = (new \yii\db\Query())->from('zss_admin_shop')
              ->select(['username'])
              ->innerJoin("zss_admin","zss_admin_shop.admin_id = zss_admin.id")
              ->where(['zss_admin_shop.shop_id' => $shop[0]['shop_id']])
      				->all();
      if(empty($admin)){
        $admins = array();
      }else{
        foreach($admin as $v){
          $admins[] = $v['username'];
        }
      }
      $shop[0]['admin'] = $admins;
      return $shop[0];
    }

    /**
     * @params $shop_id int  门店id
     */
      public function shop_menus($shop_id)
      {
        //echo $shop_id;die;
        $menus = (new \yii\db\Query())->from('zss_shop_menu')
                ->select(['zss_menu.menu_name','zss_series.series_name'])
                ->innerJoin("zss_menu","zss_shop_menu.menu_id = zss_menu.menu_id")
                ->innerJoin("zss_series","zss_menu.series_id = zss_series.series_id")
                ->where(['zss_shop_menu.shop_id' =>$shop_id])
        				->all();
        return $menus;
      }

      /**
       * @params $shop_id int  门店id
       */
        public function shop_shop($menu_id)
        {
          $shops = (new \yii\db\Query())->from('zss_shop_menu')
                  ->select(['zss_shop.shop_id','zss_shop.shop_name'])
                  ->innerJoin("zss_shop","zss_shop_menu.shop_id = zss_shop.shop_id")
                  ->where(['zss_shop_menu.menu_id' =>$menu_id])
          				->all();
          foreach($shops as $k=>$v){
            $shops[$k]['shop_id'] = $v['shop_id'];
            $shops[$k]['shop_name'] = $v['shop_name'];
          }
          return $shops;
        }

        /**
         * @params $shop_id int  门店id
         */
          public function shop_series($series_name)
          {
            $shops = (new \yii\db\Query())->from('zss_shop_menu')
                    ->select(['zss_shop.shop_id','zss_shop.shop_name'])
                    ->innerJoin("zss_shop","zss_shop_menu.shop_id = zss_shop.shop_id")
                    ->where(['zss_shop_menu.menu_id' =>$menu_id])
                    ->all();
            foreach($shops as $k=>$v){
              $shops[$k]['shop_id'] = $v['shop_id'];
              $shops[$k]['shop_name'] = $v['shop_name'];
            }
            return $shops;
          }

		/**
      	 * @inheritdoc  查询门店id
      	 */
      	 function find_id($shop_name)
      	{
      		 $shop_id = $this->find()
      				->select("shop_id")
      				->where(['shop_name'=>$shop_name])
      				->asArray()
      				->one();
              return $shop_id['shop_id'];
      	}

		/**
      	 * @inheritdoc  查询增减表
      	 */
		 public function zj($n='')
		 {
			 $add = (new \yii\db\Query())
					->select("*")
					->from('zss_add')
					->all();
			$subtract = (new \yii\db\Query())
					->select("*")
					->from('zss_subtract')
					->all();
			$a = array();
			$s = array();
			 if($n==1)
			 {
				 foreach($add as $val)
				 {
					 $a[$val['add_id']] = $val['add_price'];
				 }
				 foreach($subtract as $val)
				 {
					 $s[$val['subtract_id']] = $val['subtract_price'];
				 }
				 return array("add"=>$a,"subtract"=>$s);
			 }
			 else
			 {
				 return array("add"=>$add,"subtract"=>$subtract);
			 }
		}
		
		/**
		 * @inheritdoc  获取满增满减信息
		 * @param  $id 满增满减表id
		 * @param  $type 类型(1满增 0满减)
		 */
		function SelectGift($get)
		{
			if($get['type']==1)
			{
				$rows = (new \yii\db\Query())->select(['gift_id']) ->from('zss_add')->where(['add_id' => $get['id']])->one();
				$result = (new \yii\db\Query())->select(['gift_name']) ->from('zss_gift')->where(['gift_id' => $rows['gift_id']])->one();
				return $result['gift_name'];
			}
			elseif($get['type']==0)
			{
				$rows = (new \yii\db\Query())->select(['subtract_subtract']) ->from('zss_subtract')->where(['subtract_id' => $get['id']])->one();
				return $rows['subtract_subtract'];
			}
			else
			{
				return false;
			}
		}
	

     public function shop_order()
	 {
		 return $this->find()->select(['shop_name','shop_x','shop_y','shop_address','shop_tel'])->Asarray()->all();
	 }
		
	/**
	*@Action 添加配送员
	*/
	 public function adddis($data)
	 {
		 $shop_id = $data['id'];
		 $db = Yii::$app->db;
		 //处理配送员
		$st = $db->createCommand("DELETE FROM zss_admin_distribution WHERE shop_id=:shop_id",[':shop_id' => $shop_id]);
		$re = $st->execute();
		if($data['form'])
		{
			foreach($data['form'] as $val)
			{
				$st = $db->createCommand("INSERT INTO zss_admin_distribution (shop_id,admin_id) VALUES ($shop_id,$val)");
				$re = $st->execute();
			}
		}
		return $re;
	 }


}
