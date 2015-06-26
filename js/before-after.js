
	$(document).ready(function() {
  	var obj = $.config.obj;
  	var params = $.config.params;
  	var total=obj.length;
  	var current=0;
  	$('.picture_hight_width1').css('background','url("img/before_after/'+obj[current]['photo']+'")');
	$('.picture_hight_width2').css('background','url("img/before_after/'+obj[current]['photo_small']+'")');
	var img= new Image();
  	 img.src= 'img/before_after/'+obj[current+1]['photo'];
  	 var img2= new Image();
  	 img2.src= 'img/before_after/'+obj[current+1]['photo_small'];
  
      $(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 39: 
							if ($(':animated').length) { return false;}	
  	  						else $('.float_right_arrow').trigger('click');
						break;
						case 37: 
						if ($(':animated').length) { return false;}	
  	  					else  $('.float_left_arrow').trigger('click');
						break;
						
						}
				});
      
      
	
	 $('.float_left_arrow, .float_right_arrow').live('click touchend',function() {
  	  if ($(':animated').length) { return false;}	
  	  else {
  	if($(this).attr('class')==="float_right_arrow")
  			{ 
                        
  				   if(current<total-1) {
  				   if(current==total-2) { $('.float_right_arrow').hide();}
  				    $('.preloader').show();
  				    $("#slider").slider('option', 'value', 0);
  				    $('.picture_hight_width2').css('width','0px');
  				     $('.slider_color').css('width','0px');
  				   	$('.picture_hight_width1').animate({marginLeft:'910px'}, 500, function() {
  				   	$('.picture_hight_width1').css('margin-left','-910px');
					$('.picture_hight_width1').animate({marginLeft:'0px'},500);
					$('.float_left_arrow').show();
					

					$('.picture_hight_width1').css('background','url("'+img.src+'")');
					$('.picture_hight_width2').css('background','url("'+img2.src+'")');
					current=current+1;
					if(current<total-1) {
  					img.src= 'img/before_after/'+obj[current+1]['photo'];
					img2.src= 'img/before_after/'+obj[current+1]['photo_small'];
										}

  					else {img.src= 'img/before_after/'+obj[current]['photo'];
					img2.src= 'img/before_after/'+obj[current]['photo_small'];}
					
					
					$('.preloader').hide();
  		            $('span.replace').replaceWith('<span class="replace">'+obj[current]['client']+'</span>');
  		            $('span.text_port_before_after').replaceWith('<span class="text_port_before_after">'+obj[current]['description']+'</span>');
					
					});
  		           }
  			}
  			else
  	if($(this).attr('class')==="float_left_arrow") 
  			{ 
  				
  				 if(current>=1) {
  				 	if(current==1) { $('.float_left_arrow').hide();}
  				 	 
  					$('.preloader').show();
  					$("#slider").slider('option', 'value', 0);
  					$('.picture_hight_width2').css('width','0px');
  					$('.slider_color').css('width','0px');
  				 	$('.picture_hight_width1').animate({marginLeft:'-910px'},500 , function() {
  				 	$('.picture_hight_width1').css('margin-left','910px');
  				    $('.picture_hight_width1').animate({marginLeft:'0px'},500);
  				 	$('.float_right_arrow').show();
  					current=current-1;
  					$('.picture_hight_width1').css('background','url("img/before_after/'+obj[current]['photo']+'")');
  					$('.picture_hight_width2').css('background','url("img/before_after/'+obj[current]['photo_small']+'")');
  					img.src= 'img/before_after/'+obj[current+1]['photo'];
					img2.src= 'img/before_after/'+obj[current+1]['photo_small'];
  					$('.preloader').hide();
  
  		             $('span.replace').replaceWith('<span class="replace">'+obj[current]['client']+'</span>');
  		              $('span.text_port_before_after').replaceWith('<span class="text_port_before_after">'+obj[current]['description']+'</span>');
  		           });
  		           }
  			}
  		}
        	});
  	
 });