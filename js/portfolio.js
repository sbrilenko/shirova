  $(document).ready(function() {
  	var obj = <?php echo json_encode($mass);?> 
  	
  	var total=obj.length;
  	var current=0;
  	 var img= new Image();
  	 img.src= 'img/portfolio/'+obj[current+1]['photo'];
      $('.picture_hight_width').css('background','url("img/portfolio/'+obj[current]['photo']+'")');
      
       $(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 39: 
							 if ($(':animated').length) { return false;}	
  	  						else  $('.float_right_arrow').trigger('click');	
						break;
						case 37:
							 if ($(':animated').length) { return false;}	
  	  						else  $('.float_left_arrow').trigger('click');
						 break;						
					}
				});
      
  	 $('.float_right_arrow,.float_left_arrow').live('click touchend',function() {
  	  if ($(':animated').length) { return false;}	
  	  else {
  	if($(this).attr('class')==="float_right_arrow")
  			{ 
  				   if(current<total-1) {
  				   if(current==total-2) { $('.float_right_arrow').hide();}
  				      
  				    $('.preloader').show();
  				   	$('.picture_hight_width').animate({marginLeft:'930px'}, 500, function() {
  				   	$('.picture_hight_width').css('margin-left','-930px');
					$('.picture_hight_width').animate({marginLeft:'20px'},500);
					$('.float_left_arrow').show();
					$('.picture_hight_width').css('background','url("'+img.src+'")');
					$('.preloader').hide();
  					current=current+1;
  					img.src='img/portfolio/'+obj[current+1]['photo'];
  		            //$('.picture_hight_width img').attr('src',cur.src);
  		            $('span.replace').replaceWith('<span class="replace">'+obj[current]['client']+'</span>');
  		            $('div.text_port').replaceWith('<div class="text_port">'+obj[current]['description']+'</div>');
					});

  		           }
  			}
  			else
  	if($(this).attr('class')==="float_right_arrow") 
  			{ 
  				 if(current>=1) {
  				 	if(current==1) { $('.float_left_arrow').hide();}
  					$('.preloader').show();
  				 	$('.picture_hight_width').animate({marginLeft:'-930px'},500 , function() {
  				 	$('.picture_hight_width').css('margin-left','930px');
					$('.picture_hight_width').animate({marginLeft:'20px'},500);
  				 	$('.float_right_arrow').show();
  					current=current-1;
  					$('.picture_hight_width').css('background','url("img/portfolio/'+obj[current]['photo']+'")');
  					$('.preloader').hide();
  					img.src='img/portfolio/'+obj[current+1]['photo'];
  		             $('span.replace').replaceWith('<span class="replace">'+obj[current]['client']+'</span>');
  		              $('div.text_port').replaceWith('<div class="text_port">'+obj[current]['description']+'</div>');
  		           });
  		           }
  			}
  		}
        	});
  	
  })
