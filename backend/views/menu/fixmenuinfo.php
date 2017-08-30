<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '菜单列表';
?>
<style type="text/css">
body{ font-size:15px; background-color:#f9f9f9;}
.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%; height:40%;}
#tto td{ text-align:center;}
    textarea{  
        border:0;  
        background-color:transparent;  
        /*scrollbar-arrow-color:yellow;  
        scrollbar-base-color:lightsalmon;  
        overflow: hidden;*/  
        color: #666464;  
        height: auto;  
    }  
   
</style>
  <div align="center">

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="menuid" id="menuid"  value="<?= $info["id"]?>">
<input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
<table class="table table-bordered data-table" id="tto" style="overflow:scroll; font-size:15px;font-family:楷体">
<tr>
  <td><span><b>菜品分类</b></span><br/ ></td>
  <td>
    <select name="MenuForm[series_id]" id="" style="width:300px">
       <option value="" >----请选择----</option>
      <?php
        foreach ($allser as $key => $value) {?>
        <?php if($info["series_name"]==$value["series_name"]){?>
         <option style="width:100px" selected="selected" value="<?= $value['series_id']?>"><?= Html::encode($value["series_name"])?></option>

        <?php }else{ ?>

          <option style="width:100px" value="<?= $value['series_id']?>"><?= Html::encode($value["series_name"])?></option>
        <?php } ?>
        <?php }
      ?>
  
    </select>

  </td>
  
</tr>
<tr>
  <td><span><b>菜品名称</b></span><br/ ></td>
  <td><input type="text" id="name" value="<?= $info["name"]?>" name="MenuForm[menu_name]" placeholder="请填写菜品名称" style="height:26px;width:300px">
   <span><font color="red" id=><?php echo Html::error($model,'menu_name') ?></font></span>
</td>

</tr>
<tr>
  <td> <span><b>菜品价格</b></span><br/ ></td>
  <td>
    <input type="text" id="price" value="<?= $info["price"]?>" name="MenuForm[menu_price]" placeholder="请填写正确的菜品价格"  style="height:26px;width:300px">  <span><font color="red"><?php echo Html::error($model,'menu_price') ?></font></span>

</td>

</tr>
<tr>
  <td><span><b>菜品单位</b></span><br/ ></td>
  <td>


  <select name="MenuForm[menu_code]"  style="width:300px">
  <option value="">----请选择----</option>
   <?php $arr=array("份","碗","个","勺","盆","厅","斤");
   foreach ($arr as $key => $value) {
      if ($info["menu_code"]==$value) {
          echo "<option selected='selected' value=".$value.">".$value."</option>";
      }else{

        echo "<option  value=".$value.">".$value."</option>";

      }

   }
     
   ?> 
    
  </select>
 
  
  </td>
</tr>



<tr>
  <td><span><b>菜品图片</b></span><br/ >
</td>
  <td>
   

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
  
    <?= $form->field($modelimg, 'imageFiles[]',['inputOptions'=>["class"=>"file","id"=>"fileField"]])->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
(一次可选择多张,不多于4张)
  </td>

</tr>
<tr>
  <td><span><b>菜品排序</b></span><br/ ></td>
  <td>
  <input type="text" id="sort" value="<?= $info["sort"]?>" name="MenuForm[menu_sort]" placeholder="默认为50，数字越大越靠前"  style="height:26px;width:300px">  <span><font color="red">
   <span><font color="red"><?php echo Html::error($model,'menu_sort') ?></font></span>

</td>

</tr>
<tr>
  <td><span><b>是否在线上显示</b></span></td>
  <td>
  
<div style="height:50px">
 <input type="radio" value="1" checked="checked" name="MenuForm[shop_show]">显示
 <input type="radio" value="0" name="MenuForm[shop_show]">隐藏
 <span><font color="red"><?php echo Html::error($model,'shop_show') ?></font></span>
 </div>
  </td>
  <td></td>
</tr>
<tr>
  <td><span ><b>菜品原图片</b></span><br/ ></td>
  <td>
  
  <div id="img"><?= $info["img"]?></div></td>
  
</tr>
<tr>
  <td><span ><b>菜品介绍</b></span><br/ ><br/ ></td>
  <td>

    <textarea id="menu_introduce"  name="MenuForm[menu_introduce]" ><?= $info["menuintroduce"]?></textarea>
     <span><font color="red"><?php echo Html::error($model,'menu_introduce') ?></font></span>
  </td>
  
</tr>
<tr>
  <td>
  
</td>
  <td><div class="form-group" style="width:100px">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div></td>
  
</tr>
</table>
</form>

</div>