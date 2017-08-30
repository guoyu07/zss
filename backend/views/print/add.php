<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '门店列表'; 
?>

<style type="text/css">
.help-block{float:left; width:150px; color:red;}
input{float:left; margin-right: 10px;}
#allmap {width:800px; height:400px;}
body{background: white;}
p{
	height: 40px;
}
</style>
 <div class="widget-box">
<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
  <h5>打印机管理</h5>
</div>
<div class="widget-content nopadding">
<?= Html::jsFile('./assets/order/LodopFuncs.js')?> 
<!-- <h2><b><font color="#009999">打印机管理:</font></b></h2>
<p>相关函数有以下几个：</p>
<p><font color="#0000FF" size="3">GET_PRINTER_COUNT;获得打印机个数<br>
GET_PRINTER_NAME(intPrinterIndex);用序号获得打印机名，一般序号从0开始，-1特指默认打印机；<br>
SET_PRINTER_INDEX(oIndexOrName);按序号或名称指定打印机，选定后禁止手工重选；<br>
</font><font color="#0000FF" size="3">SET_PRINTER_INDEXA(IndexorName);按序号或名称指定打印机，选定后允许手工重选；<br>
SELECT_PRINTER;弹出界面选打印机并返回其序号，序号从0开始,返回-1表示放弃<br>
SET_PRINT_COPIES(intCopies);指定每次打印份数，缺省为1</font></p> -->


<form action="<?php echo Url::to(['print/set-print']); ?>" method="post">
<input type='hidden' name="_csrf" value='<?=Yii::$app->request->csrfToken?>'/>

<input type="hidden" name="Prints[shop_id]" value='<?=Html::encode($shop_id["shop_id"]);?>' >
	<!-- <br> -->
	<div>1：获得本系统内的打印机</div>
	<!-- <br> -->
	<p>
	  <input type="text" id="T1"  size="5"style="height:30px;">
	  <input type="button" value="数量"  onclick="document.getElementById('T1').value=getPrinterCount()" >                   
	</p>
	<!-- <br> -->
	<div>2：获得打印机名称</div>
	
	<!-- <br> -->
	<p><input type="text" id="T2" size="1" name="Prints[print_num]" value="0"style="height:30px;">注意：填写打印机的序号(从0开始),打印机第0号默认为外卖员和自提区，1号默认为堂食区(请勿给这两个号选择档口)
	</p>
	<!-- <br> -->
	<p>
	<input type="text" id="T3" name="Prints[print_name]" size="30" style="height:30px;">
	<input type="button" value="打印机名称"  onclick="document.getElementById('T3').value=getPrinterName(document.getElementById('T2').value)">    
	</p>
	<!-- <br> -->
	<div>3：选择对应的分类</div>
	
	<!-- <br> -->
	<p>
	<select style="overflow:scroll; font-size:15px;font-family:楷体;width:200px;height:30px;" name="Prints[series_id]" id="">
      <option value="" selected="selected">----请选择----</option>
      <?php
        foreach ($showAll as $key => $value) {?>
         
          <option  value="<?= $value['series_id']?>"><?= Html::encode($value["series_name"])?></option>
        <?php }
      ?>

    </select>
	</p>
	
	<input type="submit" value="提交"/>
</form>
<br>

</div>

<script language="javascript" type="text/javascript">  
        var LODOP; //声明为全局变量 
	function getPrinterCount() {	
		LODOP=getLodop();  
		return LODOP.GET_PRINTER_COUNT();	
	};
	function getPrinterName(iPrinterNO) {	
		LODOP=getLodop();  
		return LODOP.GET_PRINTER_NAME(iPrinterNO);	
	};
	function getPrinterOther(iPrinterNO,strTypeKEY) {	
		LODOP=getLodop();  
		return LODOP.GET_PRINTER_NAME(iPrinterNO+":"+strTypeKEY);
	       //例如：LODOP.GET_PRINTER_NAME("0:DriverName");	
	};
	function PreviewByPrinterIndex(intPrinterIndex) {	
		CreatePrintPage();
		if (LODOP.SET_PRINTER_INDEX(intPrinterIndex))
		LODOP.PREVIEW();		
	};
	function PrintByPrinterIndex(intPrinterIndex) {	
		CreatePrintPage();
		//LODOP.SET_PRINT_MODE("TRYLINKPRINTER_NOALERT",true);//这个语句设置网络共享打印机连接不通时是否提示一下
		if (LODOP.SET_PRINTER_INDEX(intPrinterIndex)) 
		LODOP.PRINT();		
	};
	function PreviewByPrinterName(strPrinterName) {				
		CreateHTMPrintPage();
		if (LODOP.SET_PRINTER_INDEXA(strPrinterName)) 
		LODOP.PREVIEW();		
	};
	function PrintByPrinterName(strPrinterName) {		
		CreateHTMPrintPage();
		if (LODOP.SET_PRINTER_INDEXA(strPrinterName)) 
		LODOP.PRINT();		
	};	
	function SelectAsDefaultPrinter() {
		LODOP=getLodop();  
        	if (LODOP.SELECT_PRINTER()>=0) 
        	alert("选择成功!"); else alert("选择失败！");
	};
	function PrintByDefaultPrinter() {
		CreatePrintPage();
		LODOP.PRINT();	
	};	
	function PrintMoreCopies(intCopies) {
		CreatePrintPage();		
    	        if (LODOP.SET_PRINT_COPIES(intCopies)) LODOP.PRINT();
		else  alert("设置打印份数失败！");
	};
	function PreviewReSelect(blCanSelect) {	
		CreatePrintPage();
		LODOP.SET_PRINTER_INDEX(-1);//指定打印机
		LODOP.SET_PRINT_PAGESIZE(1,0,0,"A4");//指定方向和纸张
		LODOP.SET_PRINT_COPIES(2);//指定份数
		LODOP.SET_PRINT_MODE("RESELECT_PRINTER",blCanSelect);
		LODOP.SET_PRINT_MODE("RESELECT_ORIENT",blCanSelect);
		LODOP.SET_PRINT_MODE("RESELECT_PAGESIZE",blCanSelect);
		LODOP.SET_PRINT_MODE("RESELECT_COPIES",blCanSelect);
		LODOP.PREVIEW();		
	};		
	function CreatePrintPage() {	
		LODOP=getLodop();  	
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_测试页一");
		LODOP.ADD_PRINT_RECT(77,74,409,345,0,2);
		LODOP.ADD_PRINT_ELLIPSE(351,140,140,60,0,1);
		LODOP.ADD_PRINT_RECT(299,133,344,42,1,1);
		LODOP.ADD_PRINT_TEXT(91,242,70,21,"测试页标题");
		LODOP.ADD_PRINT_TEXT(201,94,20,94,"测试页内容");
		LODOP.ADD_PRINT_TEXT(129,131,345,31,"测试内容一:9号宋体字是默认字体");
		LODOP.ADD_PRINT_TEXT(161,131,345,31,"测试内容二:11号普通宋体字正体");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT(193,131,345,31,"测试内容三:13.5 号宋体字的粗体");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",13.5);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT(225,131,345,31,"测试内容四:15号宋体字的斜体");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",15);
		LODOP.SET_PRINT_STYLEA(0,"Italic",1);
		LODOP.ADD_PRINT_TEXT(260,131,345,31,"测试内容五:16号斜体字带下划线");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",16);
		LODOP.SET_PRINT_STYLEA(0,"Italic",1);
		LODOP.SET_PRINT_STYLEA(0,"Underline",1);
		LODOP.ADD_PRINT_TEXT(308,144,318,29,"测试内容六:黑体字居中");
		LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(350,300,170,66,"测试内容七:单行文字右靠齐超出区域宽度时则折行显示");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",3);
		LODOP.ADD_PRINT_TEXT(428,79,400,23,"以上演示了位置、区域、字体、图形、线型等打印布局和风格。");
		LODOP.ADD_PRINT_LINE(119,76,118,481,0,1);
		LODOP.ADD_PRINT_LINE(78,127,420,128,0,1);
		LODOP.ADD_PRINT_LINE(79,76,118,127,0,1);			
	};	
	function CreateHTMPrintPage() {	
		LODOP=getLodop();  	
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_测试页二");
		var strHTML="<!doctype><body><font style='font-size:16px;'>字体大小:16px</font><br>";
		strHTML=strHTML+"<font style='font-size:16pt;'>字体大小:16pt</font><br>";
		strHTML=strHTML+"<font style='font-size:x-small'>字体大小:x-small</font><br>";
		strHTML=strHTML+"<font style='font-size:small'>字体大小:small</font><br>";
		strHTML=strHTML+"<font style='font-size:medium'>字体大小:medium</font><br>";
		strHTML=strHTML+"<font style='font-size:large'>字体大小:large</font><br>";
		strHTML=strHTML+"<font style='font-size:x-large'>字体大小:x-large</font><br>";
		strHTML=strHTML+"<font style='font-size:XX-large'>字体大小:XX-large</font><br>";
		strHTML=strHTML+"<font size='1'>字体大小:1</font><br>";
		strHTML=strHTML+"<font size='2'>字体大小:2</font><br>";
		strHTML=strHTML+"<font size='3'>字体大小:3</font><br>";
		strHTML=strHTML+"<font size='4'>字体大小:4</font><br>";
		strHTML=strHTML+"<font size='5'>字体大小:5</font><br>";
		strHTML=strHTML+"<font size='6'>字体大小:6</font><br>";
		strHTML=strHTML+"<font size='7'>字体大小:7</font><br>";
		strHTML=strHTML+"<font size='-1'>字体大小:-1</font><br>";
		strHTML=strHTML+"<font size='-2'>字体大小:-2</font><br></body>";
		LODOP.ADD_PRINT_HTM(5,5,"100%","100%",strHTML);
		LODOP.SET_PRINT_STYLEA(0,"Horient",3);
		LODOP.SET_PRINT_STYLEA(0,"Vorient",3);			
	};
</script> 