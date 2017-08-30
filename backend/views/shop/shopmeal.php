<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
$this->title = '当前门店团餐';
?>
<?= Html::jsFile('./assets/order/laydate/laydate.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?>
<?= Html::cssFile('./assets/order/time/jquery.datetimepicker.css')?>
<?= Html::jsFile('./assets/order/time//jquery.js')?>
<?= Html::jsFile('./assets/order/time/jquery.datetimepicker.js')?>
<style type="text/css">
    input{padding: 0px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 0px; height: 30px; width: 100px;}
</style>
<div class="widget-box">
  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
    <h5>门店团餐</h5>
  </div>
        <?php if(isset($data)): ?>
            <input id="name" type="text" value=" 请输入公司名称" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999">
            <input id="phone" type="text" value=" 请输入联系方式"  onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999">
            <input id="date" type="text" value=" 请输入取餐时间"  onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999">
            <?php foreach($data as $model): ?>
                <a href="javascript:void(0)" class="menu" id="<?= Html::encode($model['menu_id']) ?>"><?= Html::encode($model['menu_name']) ?></a>
            <?php endforeach; ?>
        <?php endif; ?>
  <div class="widget-content nopadding">
    <input id="shop_id" type="hidden" value="<?= Html::encode($shop_id) ?>">
    <table class="table table-bordered data-table" style="overflow:scroll; font-size:12px;">
        <tr>
            <th>菜品名</th>
            <th>单价</th>
            <th>折扣</th>
            <th>数量</th>
            <th>小计</th>
        </tr>
        <tbody>
            <?php if(isset($data)): ?>
                <?php foreach($data as $model): ?>
                    <tr id="menu<?= Html::encode($model['menu_id']) ?>" data-id="<?= Html::encode($model['menu_id']) ?>" style="display:none">
                        <input type="hidden" value="<?= Html::encode($menu_id) ?>">
                        <td><?= Html::encode($model['menu_name']) ?></td>
                        <td><input type="text" name="menu_price" value="<?= Html::encode($model['menu_price']) ?>"></td>
                        <td><input type="text" name="menu_discount" value="1"></td>
                        <td><input type="text" name="menu_count" value="1"></td>
                        <td><span name="menu_total" data-value="<?= Html::encode($model['menu_price']) ?>"><?= Html::encode($model['menu_price']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="2">总计：￥ <span id='total' data-value="0">0.00</span></td>
                        <td colspan="2"><button class="btn btn-inverse sub">团购点餐</button></td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>
  </div>
</div> 

<script>
$(document).ready(function(){
    //时间插件
    $('#date').datetimepicker({value:'',step:10});
	$('.menu').on('click',function(){
		var id = $(this).attr('id');
		var tr = $('#menu'+id);
		tr.show();
		calculate(tr);
	});	

    $('.data-table tbody tr td input[type=text]').on('keyup', function(){
    	var tr = $(this).parents('tr');
    	calculate(tr);
    });  

    //团购点餐
    $('.btn.sub').click(function(){
    	var data = {};
    	data['shop_id'] = $('#shop_id').val();
    	data['total'] = $('#total').data('value');
        data['name'] = $('#name').val();
        data['phnoe'] = $('#phnoe').val();
        data['date'] = $('#date').val();
    	data['menu'] = [];
    	$('.data-table tbody tr:visible').each(function(index, ele){
    		data['menu'][index] = {
    			'menu_id': $(ele).data('id'),
    			'menu_price': $(ele).find('[name=menu_price]').val(),
    			'menu_discount': $(ele).find('[name=menu_discount]').val(),
    			'menu_count': $(ele).find('[name=menu_count]').val(),
    			'menu_total': $(ele).find('[name=menu_total]').data('value')
    		};
    	});

    	console.log(data);
    	//发送请求
    	$.get("<?= Yii::$app->urlManager->createUrl(['shop/shoporder']); ?>", data, function(data, status){
    		if(status == 'success'){

    		}
    	});
    });			
});

//计算小计、合计
function calculate(tr){
	var menu_price = parseFloat(tr.find('[name=menu_price]').val());
	if(!menu_price){menu_price = 0;}
	var menu_discount = parseFloat(tr.find('[name=menu_discount]').val());
	if(!menu_discount){menu_discount = 0;}
	var menu_count = parseInt(tr.find('[name=menu_count]').val());
	if(!menu_count){menu_count = 0;}

	var menu_total = menu_price*menu_discount*menu_count;
	tr.find('[name=menu_total]').data('value', menu_total);
	tr.find('[name=menu_total]').text(menu_total);

	var total = 0;
	$('.data-table tbody tr:visible [name=menu_total]').each(function(index, ele){
		total += parseFloat($(ele).data('value'));
	});
	$('#total').data('value', total);
	$('#total').text(total);
}	 
</script>