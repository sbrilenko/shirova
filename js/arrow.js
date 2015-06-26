  $(document).ready(function() {
		
			
	 	$('.arrow > img').bind('mouseover',function() {

	 		if($(this).attr('src')=="img/arrow_right.png")
						{
							$(this).attr('src','img/arrow_right_pressed.png');
							$(this).css('cursor','pointer');
						}
			else 
			if($(this).attr('src')=="img/arrow_left.png")
						{
							$(this).attr('src','img/arrow_left_pressed.png');
							$(this).css('cursor','pointer');
						}
			
												});
	$('.arrow > img').bind('mouseout',function() {
					if($(this).attr('src')=="img/arrow_right_pressed.png")
						{
							$(this).attr('src','img/arrow_right.png');
							$(this).css('cursor','default');
						}
					else 
					if($(this).attr('src')=="img/arrow_left_pressed.png")
						{
							$(this).attr('src','img/arrow_left.png');
							$(this).css('cursor','default');
						}
		
							});
 });