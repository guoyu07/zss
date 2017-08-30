$(document).ready(function() {
     $(".accordion-desc").fadeOut(0);
     $(".accordion").click(function() {
          $(".accordion-desc").not($(this).next()).slideUp('fast');
          $(this).next().slideToggle(400);
		  
     
	  
	  var oA = $(this).children().children().children().next().attr('class');
	  
	  if(oA == 'icon-angle-up'){
		  $(this).children().children().children().next().attr('class','icon-angle-down');
	   }else{
		   $(this).children().children().children().next().attr('class','icon-angle-up');
		   }
	 });
	
	
	
});
