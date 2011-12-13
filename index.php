<?php 
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Adoralo Con Todo :: Hechos 29 2011</title>
	
	<meta name="generator" content="Branding Machine">
	<meta name="author" content="BM - Frisley Velasquez">
	<meta name="designer" content="BM - Andres Franco">
	<meta name="idea" content="Jacobo Perez, Andres Franco, Frisley Velasquez">
	<meta name="description" content="Adoralo con todo es un movimiento que te motiva a adorar a Dios en todo lugar y en cualquier momento de la forma que desees exaltando su nombre."/>
	<meta name="keywords" content="Adoralo Con Todo, Hechos 29, 2011, Hechos 29 2011, Adoralo, Casa de Dios" />
	
	<meta property="og:title" content="Adoralo Con Todo :: Hechos 29 2011"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://adoralocontodo.com"/>
    <meta property="og:image" content="http://adoralocontodo.com/icono_big.png"/>
    <meta property="og:site_name" content="Adoralo Con Todo"/>
    <meta property="og:description" content="Adoralo con todo es un movimiento que te motiva a adorar a Dios en todo lugar y en cualquier momento de la forma que desees exaltando su nombre."/>
    
	<link rel="shortcut icon" type="image/x-icon" href="http://adoralocontodo.com/favicon.ico">
	<!-- CSS -->
	<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/twit-stream.css" />
	<link href="css/webwidget_slideshow_common.css" rel="stylesheet" type="text/css" />
	<link href="css/style_1/style.css" rel="stylesheet" type="text/css" />
	
	<!-- JS -->
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.infinitescroll.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.json-2.2.min.js" type="text/javascript"></script>
	<script src="js/jstorage.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/webwidget_slideshow_common.js"></script>

	<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="js/pirobox_extended.js"></script>
	<script src="http://platform.twitter.com/anywhere.js?id=MXs6YlyWGYvmx6aglZ7wdQ&v=1"></script>
	<script type="text/javascript">
			var actualpage = 1;
			
			//Funcion de carga de informacion
			function lastPostFunc()
			{
				actualpage++;
			    $(".lastPostsLoader").fadeIn('fast');
			    $.post("getmedia.php"
			    ,{ action: "getLastMedia", page: actualpage }
			    ,function(data){
			        if (data != "") {
			        $("#thumbmasktrail:last-child").after(data);           
			        }
			        $(".lastPostsLoader").fadeOut('slow');
			    });
			};

	        $(function() {
				//Carga la primera pagina de media
				$(".thumb").html('<img src="js/loading.gif"/>');
				$('.thumb').load('getmedia.php');
				//Calcula el alto de la ventana y al llegar al final carga mas info
				$(window).scroll(function(){
				        if  ($(window).scrollTop() == $(document).height() - $(window).height()){
				           lastPostFunc();
				        }
				});
				
	        });

		showTweetLinks='all';
		</script>
		<script type="text/javascript" src="js/twitStream.js"></script>
		<script>
		$(function(){
			showTweetLinks=showTweetLinks.toLowerCase();
			if(showTweetLinks.indexOf('all')!=-1)
				showTweetLinks='reply,view,rt';
			$('.twitStream').each(function(){
				fetch_tweets(this);
			});
		});
		</script>
</head>
<body>

<div id="wrap">
	<div id="container">
		<div id="floatingmenu">
			<div id="header">
			<div id="logo"><a href="./"><img src="images/logohechos.png" alt="logohechos" border="0" /></a></div>
			<ul>
				<li><a href="sendmedia.php" rel="iframe-600-500" class="pirobox_gall"><img src="images/publica.png" alt="publica tu contenido"/></a></li>
				<!--li><a href="sendspecialmedia.php" rel="iframe-600-500" class="pirobox_gall"><img src="images/reto29.png" alt="publica tu contenido" width="200"/></a></li-->
				
				<li style="margin-top:20px">
				<div id="login"></div>
				<script type="text/javascript">
				  twttr.anywhere.config({ callbackURL: "http://adoralocontodo.com/blank.php" });
				  twttr.anywhere(function (T) {
				    T("#login").connectButton({
				    	authComplete: function(user){
				    		window.location = "index.php";
				    	}
				    });
				    T("#tweetbox").tweetBox({
	   	   		  		counter: true,
						height: 80,
						width: 190,
						label:'Cuentanos',
						defaultContent: '#adoralocontodo'
        			});
        			
				  });
 
				</script>
				</li>
				<li style="margin-top:20px">
				<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js"></script>
				<script>
				window.fbAsyncInit = function() {
          		FB.init({
					appId      : '284281954937902',
            		status     : true, 
            		cookie     : true,
            		oauth      : true, // enable OAuth 2.0
            		xfbml      : true
         	 	});
         	 
         	 FB.getLoginStatus(function(response) {
			if (response.authResponse) {
				// logged in and connected user, someone you know
				//alert(response.authResponse.userID);
			} else {
				//alert('2');
				// no user session available, someone you dont know
  			}
			});

         	 
        	};
        
			
			</script>

			<div class="fb-login-button" data-show-faces="false" data-width="300" data-max-rows="0" data-scope="email,user_checkins,publish_stream" >Con&eacute;ctate con Facebook</div>
			</li>
			<li style="margin-top:20px">
				<div class="fb-like" data-href="http://adoralocontodo.com" data-send="false" data-layout="button_count" data-width="40" data-show-faces="false"></div>
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://adoralocontodo.com" data-text="#adoralocontodo" data-count="horizontal" data-lang="es">Tweet</a>
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
				  {lang: 'es-419'}
				</script>
				<g:plusone size="medium" href="http://adoralocontodo.com"></g:plusone>
			</li>
			</ul>
			<!--div class="twitStream 6" id="tweet" title="#hechos29"></div-->
			</div>
		</div>
		<div id="body">
			<div id="socialpane">
				<img src="images/adoralo.png" alt="adoralo con todo" style="margin-top:-200px"/>
				<br/><br/>
				<!--img src="images/banner3.jpg" alt="banner3" width="200" height="500" /-->
				<p style="font-size:12px; color:#404040;">Comparte tu adoraci&oacute;n en video o foto y cuentanos como estas <strong>Adorandolo con Todo</strong></p>
				<br/>
				<div class="lastPostsLoader"><img src="js/loading.gif" /><br/>Cargando...</div>
				<div id="tweetbox"></div>
			</div>
			<div id="mediapane">
				<!--
				1- De cada imagen es necesario saber el alto y ancho
				2- Se divide cada fila de acuerdo al ancho total del marco y se van sumando los anchos de cada foto.
				3- El alto de la fila es predefinido por el alto de la primera foto de la misma.
				4- Se crea una nueva fila cada vez que el ancho total de las fotos de la fila llega al maximo del cuerpo.
				5- On hover se muestra mas informacion de la foto
				6- On click se muestra la foto o el video con flechas para ver el anterior o el siguiente
				
				7- Infinite Scrolling
				-->
				
				
				<div class="items">
				<ul class="thumb">
				</ul>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
</body>
</html>
