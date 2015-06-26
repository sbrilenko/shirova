$(document).ready(function() {
  	
  	var obj =$.config.obj;
  	var total=obj.length;
  	var total_arr=0;
  	var sum_width=0;
  	var whats='';
  	var name_foldet_img='img/team_creative/';
  	var arr=new Array;
  	var count=0;
  	var spliter;
   var j=0;
  for (var i = 0; i < total; i++) {
  		  if(sum_width+obj[i]['width']+40>830) {arr[j]=whats;whats=''; sum_width=0;j++; }
  		  sum_width=sum_width+obj[i]['width']+40;
  		  whats+= '<div id="groop" class="group_'+i+'"><img src="'+name_foldet_img+obj[i]['photo_small']+'"/><br><br>'+obj[i]['name']+'</div>';
  		}
  		if(whats!=''){arr[j]=whats;}
  		total_arr=arr.length;
  		if(total_arr==1) {$('.float_right_arrow').hide();$('.float_left_arrow').hide();}
  				$('#one').append('<div id="f" style="min-width:910px;">'+arr[0]+'</div>');

         		 $('#one div >div#groop').live('click',function() {
          			 $('div#one div#f').hide();
          			
          			 $('.float_right_arrow').hide();$('.float_left_arrow').hide();
          			 $('div#one div#s').replaceWith('');
          			 var spl=$(this).attr('class').split('_');
          			 $('#one').append('<div id="s" style="min-width:910px;"><div style="float:left;"><img src=img/team_creative/'+obj[spl[1]]['photo']+' alt=""/></div><div style="float:left;text-align:left;">'+obj[spl[1]]['name']+'<br>'+obj[spl[1]]['position']+'<br>'+'<br>'+'</div><div style="position:absolute;text-align:left;margin-left:260px;margin-top:100px;">'+obj[spl[1]]['description']+'</div><div id="click"> < назад</div><div style="clear:both;"></div><div class="group_pic_down" ><img src="img/team_creative/'+obj[spl[1]]['photo_down']+'"></div></div>');
       		   });
       			   $('#click').live('click',function() {
          	 		 $('div#one div#s').hide();
          	 		 	if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          	 		  
          			 $('div#one div#f').show();
          			
        		  });
          
         $('.float_right_arrow,.float_left_arrow').live('click touchend',function() {
         	
         	if ($(':animated').length) { return false;}	
  	  						else {
        if($(this).attr('class')=="float_right_arrow")
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
  			else
  		if($(this).attr('class')=="float_left_arrow") 
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
						if ($(':animated').length) { return false;}	
						else $('.float_right_arrow').trigger('click')
						break;
						case 37: 
						 if ($(':animated').length) { return false;}	
						 else $('.float_left_arrow').trigger('click')
						break;
						
						
						case 27: 
						if($('#s').is(':visible'))
						{
							 $('div#one div#s').hide();
          	 		 		if(count>0) {$('.float_left_arrow').show();}
          	 		 		if(count==0) {$('.float_left_arrow').hide();}
          	 		 		if(count<total_arr-1) {$('.float_right_arrow').show();}
          	 		 		if((count==total_arr-1)||(total_arr==0)) {$('.float_right_arrow').hide();}
          	 		  
          			 $('div#one div#f').show();
						} 

						
						break;
						}
						
						
				});
				
  		
      });
      