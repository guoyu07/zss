<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '会员管理';
?>

<?= Html::jsFile('assets/order/laydate/laydate.js')?>
<style>
label{display:none}
.table textarea{
  width: 400px;
}
</style>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>经验信息设置</h5>
        </div>
        <div class="widget-content nopadding"   style="margin-left:30px;">
          <form class="form-horizontal" method="post" action="">
              <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
              <table  class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体;text-align:center;">
                  <tr>
                      <td><span ><b>经验值 :</b></span></td><td> <textarea name="vip_experience_get" id="ge" rows="8" cols="10" ><?= Html::encode($info['vip_experience_get']) ?></textarea> </td>
                  </tr>
                  <tr>
                      <td><span ><b>经验获取攻略 :</b></span></td><td> <textarea name="vip_experience_raiders" id="ra" rows="8" cols="40"><?= Html::encode($info['vip_experience_raiders']) ?></textarea> </td>
                  </tr>
                  <tr>
                      <td > <button class="btn btn-success" type="button">修改</button></td>
                  </tr>
              </table>

        </div>
</div>

<script type="text/javascript">
  $(".btn").click(function(){
    var ge = $("#ge").val();
    var ra = $("#ra").val();
    $.get("index.php?r=user/vip-info",{ge:ge,ra:ra},function(data){
      if(data == 1){
        layer.msg('修改成功');
      }else if(data == 0){
        layer.msg('修改失败');
        history.go(0);
      }else{
        layer.msg('请勿使用特殊字符');
      }
    })
  })
</script>
