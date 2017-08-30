function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}     
$(document).ready(function(){
    $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
     });
	 //弹窗显示详细信息
	 $(document).on("click","#see",function(){
		id = $(this).attr("value");
		$.ajax({
		   type: "GET",
		   url: "<?= Yii::$app->urlManager->createUrl(['order/see-order']); ?>",
		   data: "id="+id,
		   success: function(msg){
				layer.open({
				  type: 0,
				  skin: 'layui-layer-rim', //加上边框
				  area: ['1100px', '540px'], //宽高
				  content: "<a id='dian'>测试</a>",
				});
		   }
		});
	 });
	 //搜索
	 $(document).on("click",".tip-bottom",function(){
		 word = $("#word").val();
		 pay_type = $("#but").attr("value");
		 order_status = $("#but2").attr("value");
		 delivery_type = $("#but3").attr("value");
		 start_time = $("#start_time").attr("value");
		 end_time = $("#end_time").attr("value");
				 $.ajax({
					   type: "GET",
					   url: "<?= Yii::$app->urlManager->createUrl(['order/search-order']); ?>",
					   data: "word="+word+"&pay_type="+pay_type+"&order_status="+order_status+"&delivery_type="+delivery_type+"&start_time="+start_time+"&end_time="+end_time,
						dataType: 'json',
					   success: function(msg){
							console.log(msg);
							str = '';
							str += " <thead> <tr><th>ID</th><th>订单号码</th><th>收货人姓名</th><th>电话</th><th>派送类型</th><th>座位号</th><th>金额</th><th>订单状态</th><th>支付方式</th><th>桌号</th><th>创建时间</th><th>修改时间</th><th>操作</th></tr></thead> <tbody>";
							for(i=0;i<msg.length;i++){
								  str += "<tr class=\"gradeX\"><td>"+msg[i]['order_id']+"</td><td><a href=\"javascript:void(0)\">"+msg[i]['order_sn']+"</a></td> <td>"+msg[i]['user_name']+"</td><td>"+msg[i]['user_phone']+"</td><td>";
								  if(msg[i]['delivery_type']==1){
										str += "送货";
								  }else if(msg[i]['delivery_type']==2){
									  str += "自取";
								  }else if(msg[i]['delivery_type']==3){
									  str += "堂食";
								  }
								  str += " <td>"+msg[i]['seat_number']+"</td><td>"+msg[i]['order_total']+"</td><td>";
								  if(msg[i]['pay_status']==0){
									  str += "未支付";
								  }else if(msg[i]['pay_status']==1){
									   str += "支付失败";
								  }else if(msg[i]['pay_status']==2){
									   str += "支付成功";
								  }
								  str += "</td><<td>";
								  if(msg[i]['pay_type']==1){
										str += "微信";
								  }else if(msg[i]['pay_type']==2){
										str += "支付宝";
								  }else if(msg[i]['pay_type']==3){
										str += "银联";
								  }
									str+="</td><td>"+msg[i]['seat_number']+"</td><td>"+msg[i]['created_at']+"</td><td>"+msg[i]['updated_at']+"</td><td><img id=\"see\" value="+msg[i]['order_id']+" alt=\"查看\" style=\"cursor:pointer;\" src=\"./assets/search.png\" title=\"查看\" width=20 height=20></td></tr>";
							}
							str += " </tbody>";
							$("table").html(str);
					   }
				 });
	 });
	 $(document).on("click","#li",function(){
		 id = $(this).attr("value");
		 $("#but").attr("value",id);
		$("#but").html($(this).text());
	 });
	 $(document).on("click","#li2",function(){
		 $("#but2").attr("value",id);
		$("#but2").html($(this).text());
	 });
	 $(document).on("click","#li3",function(){
		 $("#but3").attr("value",id);
		$("#but3").html($(this).text());
	 });
});