$(document).ready(function() {
  	
  	var obj =$.config.obj;
  	var total=obj.length;
  	var total_arr=0;
  	var total_arr2=0;
  	var sum_width=0;
  	var sum_width2=0;
  	var whats='';
  	var name_foldet_img;
  	var arr=new Array;
  	var arr2;
  	var count=0;
  	var count2=0;
  	var count_back=0;
  	var spliter;
  	var params = $.config.params;
  	var variable;
  	var count_other;
   	var current = $.config.current;
   if(current=='model') {name_foldet_img='img/team_model/';}
   if(current=='partner') {name_foldet_img='img/team_partner/';}

   var j=0;
  for (var i = 0; i < total; i++) {
  		  if(sum_width+obj[i]['width']+40>830) {arr[j]=whats;whats='';  sum_width=0;j++;}
  		  sum_width=sum_width+obj[i]['width']+40;
  		  
  		  
  		  	if((obj[i]['url']!=undefined)&&(obj[i]['url']!='')) {whats+= '<div class="partner"><a href="http://'+obj[i]['url']+'" target="_blank" title=""><img src="'+name_foldet_img+obj[i]['photo']+'"/></a></div>';}
  		  	else {whats+= '<div class="partner"><img src="'+name_foldet_img+obj[i]['photo']+'"/></div>';}
  		  			
  		

  		}
  		if(whats!=''){arr[j]=whats;}
  		total_arr=arr.length;
  		if(total_arr==1) {$('.float_right_arrow').hide();$('.float_left_arrow').hide();}
  		
  		//if(params!=null) {$('.float_right_arrow').hide();$('.float_left_arrow').hide();	spliter=params.split('-'); $('#one').append('<div style="min-width:910px;">'+obj[spliter[0]]['description']+'</dv><a href="/group/">Назад</a>');}
  		//else {
  				$('#one').append('<div id="f" style="min-width:910px;">'+arr[0]+'</div>');
  		//		}
  		
        
	
 
         $('.arrow > img').live('click',function() {
         	
         	if ($(':animated').length) { return false;}	
  	  						else {
        if($(this).attr('src')=="img/arrow_right_pressed.png")
  			{
  					if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('#one').animate({marginLeft:'910px'}, 500, function() {
  				   	 $('div#one div').replaceWith('');
  				   	$('#one').css('margin-left','-910px');
					$('#one').animate({marginLeft:'0px'},500);
					count+=1;
  						$('#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
  						$('.preloader').hide();
  								});
  						}
  			}
  		if($(this).attr('src')=="img/arrow_left_pressed.png") 
  			{ 
  				 if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('#one').animate({marginLeft:'-910px'}, 500, function() {
  				   	 $('div#one div').replaceWith('');
  				   	$('#one').css('margin-left','910px');
					$('#one').animate({marginLeft:'0px'},500);
  						count-=1;
  						$('#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
  						$('.preloader').hide();
  					});
  				}
  			}
  			
  			
  			
  		}
  		});
  		
  		$(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 39: 
								 if ($(':animated').length) { }	
  	  						else {
  	  							if(count<total_arr-1) {
  					if(count==total_arr-2) { $('.float_right_arrow').hide();}
  					$('.preloader').show();
  					$('.float_left_arrow').show();
  				   	$('#one').animate({marginLeft:'910px'}, 500, function() {
  				   	 $('div#one div').replaceWith('');
  				   	$('#one').css('margin-left','-910px');
					$('#one').animate({marginLeft:'0px'},500);
					count+=1;
  						$('#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
  						$('.preloader').hide();
  								});
  						}
  	  							 }
						break;
						case 37: 
						if ($(':animated').length) { }	
  	  						else {
  	  								if(count>=1) {
  				 	if(count==1) { $('.float_left_arrow').hide();}
  				 	$('.preloader').show();
  					$('.float_right_arrow').show();
  					$('#one').animate({marginLeft:'-910px'}, 500, function() {
  				   	 $('div#one div').replaceWith('');
  				   	$('#one').css('margin-left','910px');
					$('#one').animate({marginLeft:'0px'},500);
  						count-=1;
  						$('#one').append('<div id="f" style="min-width:910px;">'+arr[count]+'</div>');
  						$('.preloader').hide();
  					});
  				}
  	  							 }
						break;
						
						}
				});
  		
  		
  		
      });
      