<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<style>
label{display:none}
</style>
<div class="widget-box"  align="center">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>公司添加</h5>
        </div>
        <div class="widget-content nopadding"  style="margin-left:30px;">
            <?php $form = ActiveForm::begin(); ?>
        <!--  <form class="form-horizontal" method="post" action="index.php?r=user/vericompany">-->
              <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
            <table  class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体;text-align:center;">
             <tr>
             <td><span ><b>公司名称 :</b></span></td> <td><?= $form->field($model, 'company_name')->textInput(['style' => 'width:200px;height:30px']) ?>   </td>         </tr>
               <tr>
             <td><span ><b>公司折扣 :</b></span></td> <td>  <?= $form->field($model, 'company_discount')->textInput(['style' => 'width:200px;height:30px']) ?>           </td>         </tr>
            <tr>
             <td><span ><b>满 :</b></span></td> <td> <?= $form->field($model, 'company_price')->textInput(['style' => 'width:200px;height:30px']) ?>    </td>           </tr>
              <tr>
             <td><span ><b>减 :</b></span></td> <td><?= $form->field($model, 'company_subtract')->textInput(['style' => 'width:200px;height:30px']) ?>      </td>         </tr>
               <tr>
             <td><span ><b>满赠 :</b></span></td> 
             <td> 
                  <select  name='gift' style='height:35px;width:150px;'>
                      <option value="0">请选择</option>
                      <?php foreach($gift as $models){?>
                        <option value='<?= Html::encode($models['gift_id']);?>'><?= Html::encode($models['gift_name']);?></option> 
                      <?php }?>
                  </select>    
             </td>         
               </tr>
               <tr>
                   
                   <td>   <button class="btn btn-success" type="submit">添加</button></td>
               </tr>
               </table>
         <!-- </form>-->
         <?php ActiveForm::end(); ?>
        </div>
</div>