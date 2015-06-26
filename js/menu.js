 

  var urlget = String(document.location).split('/');
   
  $(document).ready(function() {
	     if(urlget[3]=='portfolio') {
	     			 $('#menu li.first').css('backgroundPosition','0px 0px');
	     				// $('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
	     				$('#menu li.first a').css('color','#864fba');	
	     							}
	       if(urlget[3]=='backstage') {
	     			 $('#menu li.new_menu').css('backgroundPosition','0px 0px');
	     				// $('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
	     				$('#menu li.new_menu a').css('color','#864fba');	
	     							}
	     if(urlget[3]=='before-after') {
	     	 			$('#menu li.second').css('backgroundPosition','0px 0px');
	     				 //$('#menu li.second').css('background','url("img/button2_pressed.png") no-repeat');
	     				$('#menu li.second a').css('color','#864fba');	
	     							}
	      if((urlget[3]=='group')||(urlget[3]=='partner')||(urlget[3]=='model')) {
	      				$('#menu li.th').css('backgroundPosition','0px 0px');
	     				// $('#menu li.th').css('background','url("img/button3_pressed.png") no-repeat');
	     				$('#menu li.th a').css('color','#864fba');	
	     							}
	     if(urlget[3]=='news') {
	     	 			$('#menu li.news').css('backgroundPosition','0px 0px');
	     				 //$('#menu li.second').css('background','url("img/button2_pressed.png") no-repeat');
	     				$('#menu li.news a').css('color','#864fba');	
	     							}
	 	$('#menu li a').mouseover(function() {
			 var clasin=$(this).parents().attr('class');
			
			if (clasin=='news') {
				            $('#menu li.news').css('backgroundPosition','0px 0px');
				           // $('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
							}
			if (clasin=='first') {
				            $('#menu li.first').css('backgroundPosition','0px 0px');
				           // $('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
							}
			if (clasin=='new_menu') {
				            $('#menu li.new_menu').css('backgroundPosition','0px 0px');
				           // $('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
							}
			if (clasin=='second') {
				           // $('#menu li.second').css('background','url("img/button2_pressed.png") no-repeat');
				           $('#menu li.second').css('backgroundPosition','0px 0px');
							}
			if (clasin=='th') {
							$('#menu li.th').css('backgroundPosition','0px 0px');
				           // $('#menu li.th').css('background','url("img/button3_pressed.png") no-repeat');
							}
			
												});
	$('#menu li a').mouseout(function() {
		
			var clasout=$(this).parents().attr('class');
			
			if (clasout=='first') {
				 			$('#menu li.first').css('backgroundPosition','0px -50px');
				            //$('#menu li.first').css('background','url("img/button1.png") no-repeat');
							}
			if (clasout=='new_menu') {
				 			$('#menu li.new_menu').css('backgroundPosition','0px -50px');
				            //$('#menu li.first').css('background','url("img/button1.png") no-repeat');
							}
			if (clasout=='second') {
				$('#menu li.second').css('backgroundPosition','0px -50px');
				           // $('#menu li.second').css('background','url("img/button2.png") no-repeat');
							}
			if (clasout=='news') {
				$('#menu li.news').css('backgroundPosition','0px -50px');
				           // $('#menu li.second').css('background','url("img/button2.png") no-repeat');
							}				
			if (clasout=='th') {
							$('#menu li.th').css('backgroundPosition','0px -50px');
				           // $('#menu li.th').css('background','url("img/button3.png") no-repeat');
							}
		     if(urlget[3]=='backstage') { 
								 $('#menu li.new_menu').css('backgroundPosition','0px 0px');
								//$('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
										 $('#menu li.new_menu a').css('color','#864fba');	
										}
			if(urlget[3]=='portfolio') { 
								 $('#menu li.first').css('backgroundPosition','0px 0px');
								//$('#menu li.first').css('background','url("img/button1_pressed.png") no-repeat');
										 $('#menu li.first a').css('color','#864fba');	
										}
			 if(urlget[3]=='before-after') {
			 	$('#menu li.second').css('backgroundPosition','0px 0px');
	     				// $('#menu li.second').css('background','url("img/button2_pressed.png") no-repeat');
	     				$('#menu li.second a').css('color','#864fba');	
	     							}
	     	if(urlget[3]=='news') {
			 	$('#menu li.news').css('backgroundPosition','0px 0px');
	     				// $('#menu li.second').css('background','url("img/button2_pressed.png") no-repeat');
	     				$('#menu li.news a').css('color','#864fba');	
	     							}
		       if((urlget[3]=='group')||(urlget[3]=='partner')||(urlget[3]=='model')) {
		       			$('#menu li.th').css('backgroundPosition','0px 0px');
	     				// $('#menu li.th').css('background','url("img/button3_pressed.png") no-repeat');
	     				$('#menu li.th a').css('color','#864fba');	
	     							}
	     	
							});
	 
	 
	 
 });