$(document).ready(function() {
  	
  	var obj =$.config.obj;
  	var total=obj.length;
  	var total_arr=0;
  	var total_arr2=0;
  	var sum_width=0;
  	var sum_width2=0;
  	var whats='';
  	var name_foldet_img='img/team_model/';
  	var arr=new Array;
  	var arr2;
  	var count=0;
  	var count2=0;
  	var count_back=0;
  	var spliter;
   //	var current = $.config.current;
   var name_slide2;
   var descript_slide2;
   var id_big_photo;
   var j=0;
  for (var i = 0; i < total; i++) {
  		  if(sum_width+obj[i]['width']+40>830) {arr[j]=whats;whats='';  sum_width=0;j++;}
  		  	sum_width=sum_width+obj[i]['width']+40;
  		 	whats+= '<div id="model" class="galery_'+i+'"><img src="'+name_foldet_img+obj[i]['photo']+'" alt=""/><br><br>'+obj[i]['name']+'</div>';
  		}
  		if(whats!=''){arr[j]=whats;}
  		total_arr=arr.length;
  		if(total_arr==1) {$('.float_right_arrow').hide();$('.float_left_arrow').hide();}
  		$('#one').append('<div id="f" style="min-width:910px;">'+arr[0]+'</div>');
         		 	$('div#model').live('click',function() {
         		 		var spl=$(this).attr('class').split('_');
         		 		         j=0;
         		 		         count2=0;
         		 		         arr2=new Array;
         		 		         sum_width2=0;
         		 		         whats='';
         		 		         for (var i = 0; i < obj[spl[1]]['gal'].length; i++) {
         		 		         	 if(sum_width2+obj[spl[1]]['gal'][i]['width_gal_small']+20>830) {arr2[j]=whats;whats='';  sum_width2=0;j++;}
  		  									sum_width2=sum_width2+obj[spl[1]]['gal'][i]['width_gal_small']+20;
  		  									whats+= '<div id="galery_model" class="galery_model_'+i+'"><img src="'+name_foldet_img+obj[spl[1]]['gal'][i]['photo_small']+'"/></div>';	
  									  }
  							if(whats!=''){arr2[j]=whats;}
         		 			    
         		 		  $('div#one div#f').hide();
         		 		   $('div#one div#th').replaceWith('');
         		 		  name_slide2=obj[spl[1]]['name'];
  						  descript_slide2=obj[spl[1]]['description'];
  						  id_big_photo=spl[1];
         		 		$('#one').append('<div id="th" style="min-width:910px;">'+arr2[0]+'<div style="clear:both; margin-top:100px;"><div style="margin-top:-100px;text-align:left;padding:0">'+'<br>'+name_slide2+'<br>'+descript_slide2+'<br><br><br><br><br><span id="click_return_model" > < назад</span></div></div>');   	
         		 		$('.float_right_arrow').show();$('.float_left_arrow').hide();
         		 		count_back=count;
         		 		count=count2; 
         		 		total_arr2=total_arr;
         		 		total_arr=arr2.length;
         		 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
         		 });
         		 
         		$('#click_return_model').live('click',function() {
          	 		 $('div#one div#th').hide();
          	 		  count=count_back;
                      total_arr=total_arr2;
          	 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
        
          			 $('div#one div#f').show();
          			
        		  });
        		  
        		  
        		  $('#click_return_picture').live('click',function() {
          	 		 $('div#one div#ss').hide();
          	 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          			 $('div#one div#th').show();
          			
        		  });
        		 
        		  
        		  $('#one div >div#galery_model').live('click',function() {
        		  	 $('div#one div#th').hide();
        		  	 
          			 var splll=$(this).attr('class').split('_');
          			  $('div#one div#ss').replaceWith('');
          			  $('.float_left_arrow').hide(); $('.float_right_arrow').hide();
          			    $('div#one').append('<div id="ss"><div id="click_return_picture" > < назад</div></div>');
					$('#ss').css('background','url("img/team_model/'+obj[id_big_photo]['gal'][splll[2]]['photo']+'") no-repeat');
       
          			   });
         		 
         		 $('#ss').live('click',function() {
        		  			$('div#one div#ss').hide();
          	 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          			 $('div#one div#th').show();
          			   });
         
 
         $('.arrow > img').live('click',function() {
         	
         	if ($(':animated').length) { return false;}	
  	  						else {
        if($(this).attr('src')=="img/arrow_right_pressed.png")
  			{ 
  				    if($('#f').is(':visible')) {
  					if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('div#one').animate({marginLeft:'910px'}, 500,function() {
  				   	$('div#one').css('margin-left','-910px');
  				   		count+=1;
  				   	 $('div#one div#f').replaceWith('');
					  $('div#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
					$('div#one').animate({marginLeft:'0px'},500);
						$('.preloader').hide();
					 
  						});		
  						}
  					}
  				 else    if($('#th').is(':visible')) {
  				 				if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('div#one').animate({marginLeft:'910px'}, 500,function() {
  				   	$('div#one').css('margin-left','-910px');
  				   		count+=1;
  				   	 $('div#one div#th').replaceWith('');
					  $('div#one').append('<div id="th" style="min-width:910px;">'+arr2[count]+'<div style="clear:both; margin-top:100px;"><div style="margin-top:-100px;text-align:left;">'+'<br>'+name_slide2+'<br>'+descript_slide2+'<br><br><br><br><br><span id="click_return_model" > < назад</span></div></div>');
					$('div#one').animate({marginLeft:'0px'},500);
						$('.preloader').hide();
					 
  						});		
  						}
  								 }
  			}
  		if($(this).attr('src')=="img/arrow_left_pressed.png") 
  			{ 
  				 if($('#f').is(':visible')) {
  				 if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('div#one').animate({marginLeft:'-910px'}, 500,function() {
  				   	$('div#one').css('margin-left','910px');
  				   		count-=1;
  				   	 $('div#one div#f').replaceWith('');
  				 $('div#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
					$('div#one').animate({marginLeft:'0px'},500);
  					$('.preloader').hide();
  					});
  				
  				}
  			}
  				 else    if($('#th').is(':visible')) {
  				 			 if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('div#one').animate({marginLeft:'-910px'}, 500,function() {
  				   	$('div#one').css('margin-left','910px');
  				   		count-=1;
  				   	 $('div#one div#th').replaceWith('');
  				 $('div#one').append('<div id="th" style="min-width:910px;">'+arr2[count]+'<div style="clear:both;margin-top:100px;"></div><div style="margin-top:-100px;text-align:left;">'+'<br>'+name_slide2+'<br>'+descript_slide2+'<br><br><br><br><br><span id="click_return_model" > < назад</span></div></div>');
					$('div#one').animate({marginLeft:'0px'},500);
  					$('.preloader').hide();
  					});
  				
  							}
  					}
  			}
	
  		}
  		});
  		
  		  		$(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 39: 
								 if ($(':animated').length) { return false;}	
  	  						else {
  	  							if($('#f').is(':visible')) {
  					if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('div#one').animate({marginLeft:'910px'}, 500,function() {
  				   	$('div#one').css('margin-left','-910px');
  				   		count+=1;
  				   	 $('div#one div#f').replaceWith('');
					  $('div#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
					$('div#one').animate({marginLeft:'0px'},500);
						$('.preloader').hide();
					 
  						});		
  						}
  					}
  				 else    if($('#th').is(':visible')) {
  				 				if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('div#one').animate({marginLeft:'910px'}, 500,function() {
  				   	$('div#one').css('margin-left','-910px');
  				   		count+=1;
  				   	 $('div#one div#th').replaceWith('');
					  $('div#one').append('<div id="th" style="min-width:910px;">'+arr2[count]+'<div style="clear:both;margin-top:100px;"><div style="margin-top:-100px;text-align:left;">'+'<br>'+name_slide2+'<br>'+descript_slide2+'<br><br><br><br><br><span id="click_return_model" > < назад</span></div></div>');
					$('div#one').animate({marginLeft:'0px'},500);
						$('.preloader').hide();
					 
  						});		
  						}
  								 }
  	  							 }
						break;
						case 37: 
						if ($(':animated').length) { return false;}	
  	  						else {
  	  							 if($('#f').is(':visible')) {
  				 if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('div#one').animate({marginLeft:'-910px'}, 500,function() {
  				   	$('div#one').css('margin-left','910px');
  				   		count-=1;
  				   	 $('div#one div#f').replaceWith('');
  				 $('div#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
					$('div#one').animate({marginLeft:'0px'},500);
  					$('.preloader').hide();
  					});
  				
  				}
  			}
  				 else    if($('#th').is(':visible')) {
  				 			 if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('div#one').animate({marginLeft:'-910px'}, 500,function() {
  				   	$('div#one').css('margin-left','910px');
  				   		count-=1;
  				   	 $('div#one div#th').replaceWith('');
  				 $('div#one').append('<div id="th" style="min-width:910px;"><span id="click_return_model" > < назад</span>'+arr2[count]+'<div style="clear:both;"></div><div style="margin-top:-100px;text-align:left;">'+'<br>'+name_slide2+'<br>'+descript_slide2+'</div></div>');
					$('div#one').animate({marginLeft:'0px'},500);
  					$('.preloader').hide();
  					});
  				
  							}
  					}
  	  							 }
						break;
						
						case 27: 
						
						
					 if($('#th').is(':visible'))
						{
							$('div#one div#th').hide();
          	 		  count=count_back;
                      total_arr=total_arr2;
          	 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          			 $('div#one div#f').show();
						} 
					
						
						else if($('#ss').is(':visible'))
						{
							$('div#one div#ss').hide();
          	 			if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          			 $('div#one div#th').show();
          			 
						} 
					
						
						break;
						
						}
				});
  		
  		
      });
      
      
      