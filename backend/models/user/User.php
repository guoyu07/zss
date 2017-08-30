<?php

namespace backend\models\user;

use Yii;
use backend\models\user\Vip;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_phone
 * @property string $user_password
 * @property string $user_price
 * @property integer $user_virtual
 * @property string $user_sex
 * @property integer $vip_id
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_lastlogin
 * @property integer $user_status
 * @property string $user_lastip
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_price'], 'number'],
            [['user_virtual', 'vip_id', 'company_id', 'created_at', 'updated_at', 'user_lastlogin', 'user_status'], 'integer'],
            [['user_name'], 'string', 'max' => 30],
            [['user_phone'], 'string', 'max' => 11],
            [['user_password'], 'string', 'max' => 32],
            [['user_sex'], 'string', 'max' => 2],
            [['user_lastip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '自增id',
            'user_name' => ' 用户登录名称',
            'user_phone' => ' 用户手机',
            'user_password' => '密码',
            'user_price' => '用户余额',
            'user_virtual' => '用户积分',
            'user_sex' => '性别',
            'vip_id' => 'vip的id',
            'company_id' => '合伙公司id',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'user_lastlogin' => '上一次登录时闿',
            'user_status' => '0禁用 1弿启默访',
            'user_lastip' => '上一次登录ip',

        ];
    }


    /**
     * 查询前台用户表数捿
     */
    public function selectuser()
    {
        $query = (new \yii\db\Query());
        $list = $query->from('zss_user')
        ->leftJoin('zss_vip', 'zss_user.vip_id = zss_vip.vip_id')
        ->leftJoin('zss_company', 'zss_user.company_id = zss_company.company_id')
        ->orderBy(['zss_user.updated_at' => SORT_DESC,])
        ->all();
        return $list;
    }

    /**
     * 与公司表 和 会员等级表 订单,门店,菜单表关联
     * @params $cid 会员id
     */
    public function getdetail($cid){
	$more=$this->find()
                ->select('*')
                ->leftJoin("`zss_order` on `zss_user`.`user_id` = `zss_order`.`user_id`")
                ->leftJoin("`zss_company` on `zss_company`.`company_id` = `zss_user`.`company_id`")
                ->leftJoin("`zss_shop` on `zss_shop`.`shop_id` = `zss_order`.`shop_id`")
                ->leftJoin("`zss_order_info` on `zss_order_info`.`order_id` = `zss_order`.`order_id`")
                ->leftJoin("`zss_menu` on `zss_menu`.`menu_id` = `zss_order_info`.`menu_id`")
                ->addSelect(['zss_user.user_name as uname'])
                ->addSelect(['zss_user.user_id as uid'])
                ->where(['zss_user.user_id' => $cid])
                ->asArray()->one();
	return $more;
    }

    /**
     * 根据搜索条件查询前台用户表数数据
     * @params $search 条件
     */
    public function whereuser($search)
    {
        $query = (new \yii\db\Query());
        $list = $query->from('zss_user')
        ->innerJoin('zss_vip', 'zss_user.vip_id = zss_vip.vip_id')
        ->innerJoin('zss_company', 'zss_user.company_id = zss_company.company_id')
        ->where(['like','user_name',"$search"])
        ->orderBy(['zss_user.updated_at' => SORT_DESC,])
        ->all();
        return $list;
    }

    /**
     * 根据user_id搜索修改人
     * @params $cid 会员id
     */
    public function getupdated($cid)
    {
        $username = $this->find()
                            ->select('zss_admin.username')
                            ->leftJoin("`zss_admin` on `zss_user`.`updated_id` = `zss_admin`.`id`")
                            ->where(['zss_user.user_id' => $cid])
                            ->asArray()->one();
        return $username;
    }
    /**
     * 根据微信表里获取到的userid去user中查询用户的单个信息
     * @param int $user_id 会员ID
     */
    public function selectone($user_id){
        return  $this->find()->where(['user_id' => $user_id])->asArray()->one();
    }


    /**
     * 查看当前用户积分
     * @param
     * @return
     */
    public function get_user_virtual($id)
    {
        $virtual = $this->find()->select('user_virtual')->where(['user_id' => $id])->asArray()->one();
        return $virtual['user_virtual'];
    }


  /**
   * 查看当前用户经验
   * @param
   * @return
   */
  public function get_user_experience($id)
  {
      $experience = $this->find()->select(['user_experience','vip_experience','vip_name'])->leftJoin('zss_vip','zss_user.vip_id=zss_vip.vip_id')->where(['user_id' => $id])->asArray()->one();
      if(empty($experience['vip_experience'])){
        $vip = new Vip();
        $vip_info = $vip->vip_low();
        $user = $this->findOne($id);
        $user->vip_id = $vip_info['vip_id'];
        if(empty($experience['user_experience'])){
          $experience['user_experience'] = 0;
          $user->user_experience = $experience['user_experience'];
        }
        $re = $user->save();
        $experience['vip_experience'] = $vip_info['vip_experience'];
        $experience['vip_name'] = $vip_info['vip_name'];
      }
      return $experience;
  }

  /**
   * 修改当前用户会员等级
   * @param
   * @return
   */
  public function upd_vip_level($id,$vip_id)
  {
      $user = $this->findOne($id);
      $user->vip_id = $vip_id;
      $re = $user->save();
      return $re;
  }



}
