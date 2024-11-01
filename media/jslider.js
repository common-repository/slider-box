/*
 * Slider Box Widgets
 * Site: http://photoboxone.com
 */

;(function($){
	if( typeof $ == 'undefined' ) return;
	
	$.parseJSONString = function(text){
		// text = 
		var v = "{}";
		if( typeof text == 'string' ) {
			v = text;
			while( v.search("'") !==-1 ){
				v = v.replace("'",'"');
			}
		} else {
			console.log(text,'Example: {"id":1,"title":"huhu"}');
		}
		return $.parseJSON(v);
	};
	
	$(document).ready(function(){
		if( $('body').hasClass('slider_loaded') ) return;
		$('body').addClass('slider_loaded');
		
		$('.slider_box_widgets').each(function(){
			var slider = $(this),
				list = $('.list-posts',this),
				list_ul = $('.list-posts ul',this),
				list_li = $('.list-posts li',this),
				n = list_li.length,
				step = 2,
				active = 0,
				speed = 400,
				//opts = $.parseJSONString(list.attr('data-options').ToString()),
				w = 0;
			
			//console.log(slider,opts);
			
			list_li.each(function(){
				var s = $(this);
				s.attr('data-left', s.offset().left - list_ul.offset().left);
				
				w += s.width() + parseInt(s.css('padding-right')) + parseInt(s.css('padding-left')) + parseInt(s.css('margin-right')) + parseInt(s.css('margin-left'));
			});
			
			$('.list-posts-content', this).width(w);
			
			$('.arrow-navi li', this).each(function(){
				var li = $(this),
					a = $('a', this);
				
				a.click(function(e){
					e.preventDefault();
					
					var i = active;
					
					if( li.hasClass('arrow-left') ){
						i -= step;
						if( i<0 ){
							i = n-n%step;
						}
					} else if( li.hasClass('arrow-right') ){
						i += step;
						if( i>=n ){
							i = 0;
						}
					}
					// console.log(i);
					if( active != i ){
						active = i;
						list.animate({ scrollLeft: list_li.eq(active).attr('data-left') }, speed);
					}
				});
			});
		});
	});
})(jQuery);