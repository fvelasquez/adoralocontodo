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
			var oauth_uid = '';
			
			function changevision(oauthuidvar)
			{
				if(oauthuidvar == undefined || oauthuidvar == '')
				{
					$('#sm_loginmedia').fadeIn('fast');
					$('#sm_sendmedia').css('display','none');
				}else{
					$('#sm_loginmedia').css('display','none');
					$('#sm_sendmedia').fadeIn('fast');
				}
			}
			
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
				oauth_uid = response.authResponse.userID;
				changevision(oauth_uid);
				//$('#nosession').val('');
			} else {
				//$('#nosession').val('nosess');
				//changevision();
				// no user session available, someone you dont know
  			}
			});

         	 
        	};
 
	  twttr.anywhere(function (T) {
 
	    var userID,
	        oauth_uid;
		
		T("#login").connectButton({
			authComplete: function(user) {
	        // triggered when auth completed successfully
	        changevision(user.data('id'));
      		}
		});
		
	    if (T.isConnected()) {
	      currentUser = T.currentUser;
	      userID = currentUser.data('id');
	      oauth_uid = $('#oauth_uid').val();
	      $('#login').append("Logged in as " + profileImageTag + " " + screenName);
	      if(oauth_uid == '')
	      {
	      	$('#oauth_uid').val(userID);
	      }else{
	      	changevision(oauth_uid);
	      }
	    };
 
	  });
	</script>
	
<div style="width:500px; margin:120px auto 0px; font-size:14px;">
	<ol>
		<li>Sube tu foto o video a youtube, vimeo, flickr, twitpic, etc...</li>
		<li>Copia el link que deseas publicar en la p&aacute;gina</li>
		<li>Pegalo en el campo de <strong>Media</strong></li>
		<li>Colocale un titulo y una descripci&oacute;n</li>
		<li>Publica tu adoración para que todos puedan verla y adorarlo con todo!</li>
	</ol>
</div>
<div id="sm_loginmedia" style="width:500px; margin:5px auto;display:none;">
	<h2>Para publicar tu adoraci&oacute;n ingresa con cualquiera de tus cuentas:</h2>
	<div id="login" style="display:inline"></div>  
	<div class="fb-login-button" data-show-faces="false" data-width="300" data-max-rows="0" data-scope="email,user_checkins,publish_stream" style="display:inline">Conectarse con Facebook</div>
</div>
<div style="margin-top:50px;">
<form method="post" action="savemedia.php" style="width:500px;margin:50px auto 0; display:none;" id="sm_sendmedia">
	<label>Titulo:<input name="titulo" id="titulo" type="text"/></label>
	<label>Link a tu media:<input name="media" id="media" type="text"/></label>
	<label>Descripci&oacute;n:<textarea name="decripcion" id="decripcion"></textarea></label>
	<input type="hidden" name="oauth_uid" id="oauth_uid" value="" />
	<input type="submit" name="Enviar" value="Publicar" id="Enviar">
</form>
</div>
<script>
	$(function(){
		changevision();
	});
</script>
</body>
</html>
