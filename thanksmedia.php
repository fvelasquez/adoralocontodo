<?php 
session_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>sendmedia</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="BM Laptop">
	<!-- Date: 2011-10-23 -->
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="http://platform.twitter.com/anywhere.js?id=MXs6YlyWGYvmx6aglZ7wdQ&v=1"></script>
	<style>
		body { background: url(images/sendform_bg.jpg) no-repeat top left; font-size: 11px; font-family: Helvetica, Arial, Verdana; color: white; }
		label { display: block; font-weight: bold;}
		input[type=text]{ width: 500px; display: block;}
		textarea { display: block; width:500px; height:100px}
	</style>
</head>
<body>
			<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js"></script>
			<script>
			window.fbAsyncInit = function() {
          	FB.init({
            	appId      : '284281954937902',
            	channelURL : '//www.branding-machine.com/accounts/channel.html', // Channel File
            	status     : true, 
            	cookie     : true,
            	oauth      : true, // enable OAuth 2.0
            	xfbml      : true
         	 });
         	 
         	 FB.getLoginStatus(function(response) {
			if (response.authResponse) {
				// logged in and connected user, someone you know
				$('#oauth_uid').val(response.authResponse.userID);
				//$('#nosession').val('');
			} else {
				//$('#nosession').val('nosess');
				// no user session available, someone you dont know
  			}
			});

         	 
        	};
 
	  twttr.anywhere(function (T) {
 
	    var userID,
	        oauth_uid;
		T("#login").connectButton();
	    if (T.isConnected()) {
	      currentUser = T.currentUser;
	      userID = currentUser.data('id');
	      oauth_uid = $('#oauth_uid').val();
	      
	      if(oauth_uid == '')
	      {
	      	$('#oauth_uid').val(userID)
	      }
	    };
 
	  });
	  
	  $(function(){
	  		if($('#oauth_uid').value == '')
			{
				$('#sm_loginmedia').fadeIn('fast');
				$('#sm_sendmedia').css('display','none');
			}else{
				$('#sm_loginmedia').css('display','none');
				$('#sm_sendmedia').fadeIn('fast');
			}
		});
	</script>
	
<div style="width:500px; margin:120px auto 0px; font-size:12px;">
	<?php if($_GET['m'] == '1'){ ?>
	<h1>Gracias por compartirnos tu adoraci&oacute;n</h1>
	<?php } 
	if($_GET['m'] == '2'){ ?>
	<h1>El Reto29 solo esta aceptando videos seg&uacute;n las reglas que fueron establecidas. Gracias por tu comprensi&oacute;n.</h1>
	<? } ?>
</div>
</body>
</html>
