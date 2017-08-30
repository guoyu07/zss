
$.fn.containerNav = function(options) {
	var defaults = { items: ["热卖","新品","汤德","d"], debug: false, height: null, arrows: true};
	var opts = $.extend(defaults, options); var o = $.meta ? $.extend({}, opts, $$.data()) : opts; var container = $(this); $(container).addClass('container');
	$('.menu li:first', container).addClass('selected');
	$(container).append('<div class="category"><ul></ul></div>');
	var add = "<?= 20 ?>"
	alert(add)
	
	for(var i in o.items) $('.category ul', container).append("<li><a class='navmenu' alt='#"+o.items[i]+"'><img src="+"<?=  $series_info[1]['series_img1'] ?>"+ " /><span>"+o.items[i]+"</span></a></li>");
	var height = $('.category', container).height();
	if(o.height) height = o.height;
	$('.menu, .category', container).css('height',height);
	if(o.debug) $(container).append('<div id="debug">Scroll Offset: <span>0</span></div>');
	$('.category a', container).mouseover(function(event){
		var target = $(this).attr('alt');
		var cOffset = $('.menu', container).offset().top;
		var tOffset = $('.menu '+target, container).offset().top;
		var height = $('.category', container).height(); if(o.height) height = o.height;
		var pScroll = (tOffset - cOffset) - height/1000;
		$('.category a').removeClass('active');
		$(this).addClass('active');
		$('.menu li', container).removeClass('selected');
		$(target).addClass('selected');
		$('.menu', container).stop().animate({scrollTop: '+=' + pScroll + 'px'});
		if(o.debug) $('#debug span', container).html(tOffset);
	});
	
	if(o.arrows){
		
		
	}
};