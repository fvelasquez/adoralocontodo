<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
include 'includes/config.php';
include 'includes/functions.php';

$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
mysql_select_db(BD_NAME);

$oauth_uid 		= (isset($_POST['oauth_uid']) && $_POST['oauth_uid'] != '')?$_POST['oauth_uid']:'677348592';
$user_id 		= (isset($_POST['user_id']) && $_POST['user_id'] != '')?$_POST['user_id']:'1';
$fecha_crea 	= date('Y-m-d H:i:s',strtotime ("+7 hours"));
$media 			= (isset($_POST['media']) && $_POST['media'] != '')?$_POST['media']:'';

//GETS CONTENT FROM LINK
$oembed			= get_url_content($media);
$media_tipo 	= (isset($oembed->type) && $oembed->type != '')?$oembed->type:'photo';

$media_provider	= (isset($oembed->provider_name) && $oembed->provider_name != '')?$oembed->provider_name:'';
$media_html		= '';
$link 			= (isset($oembed->url) && $oembed->url != '')?$oembed->url:'';

if($media_tipo == 'video'){
	$media_html 	= (isset($oembed->html) && $oembed->html != '')?$oembed->html:'';
	$ivimeo			= $media;
	$media 			= (isset($oembed->thumbnail_url) && $oembed->thumbnail_url != '')?$oembed->thumbnail_url:'';
	
	switch($media_provider){
		case 'YouTube':
			$lnk 			= explode('v=',$oembed->url);
			$link 			= 'http://www.youtube.com/v/'.$lnk[1].'?version=3&amp;hl=es_ES';
		break;
		case 'Vimeo':
			$lnk			= explode('.com/',$ivimeo);
			$link 			= 'http://vimeo.com/moogaloop.swf?clip_id='.$lnk[1].'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0';
		break;
		case 'Ustream.tv':
			//http://www.ustream.tv/recorded/18156483
			$lnk			= $oembed->author_url;
			$html			= explode('value=\"autoplay=false&amp;brand=embed&amp;cid=',$oembed->html);
			if(is_array($html)){
				$htmla			= $html[1];
				$html			= explode('\"/><param name=\"',$htmla);
				$htmlb			= $html[0];
				$lnk			= 'http://static-cdn1.ustream.tv/swf/live/viewer:14.swf?vrsl=c:25&cid='.$htmlb.'';
			}else{
				$html			= explode('value=\"loc=%2F&amp;autoplay=false&amp;vid=',$oembed->html);
				$htmla			= $html[1];
				$html			= explode('&amp;locale=en_US\" /><param name=',$htmla);
				$htmlb			= $html[0];
				$lnk			= 'http://static-cdn1.ustream.tv/swf/live/viewer:14.swf?vrsl=c:25&vid='.$htmlb.'';
			}
			
			$media			= $oembed->thumbnail_url;
		break;
		case 'Tumblr':
			$media			= 'images/video_tumblr.png';
			$lnk			= $_POST['media'];
		break;
		default:
			$media			= 'images/video_generico.png';
			$lnk			= $_POST['media'];
		break;
	}
	
	//echo $link;
}
if($media_tipo == 'photo'){
	switch($media_provider){
		case 'Twitpic':
			$tlink			= $link;
			$link			= $media;
			$media			= $tlink;
		break;
		default:
			$tlink			= $link;
			$link			= $media;
			$media			= $tlink;
		break;
	}
}
//var_dump($oembed);
//echo $link;
$cookie = get_facebook_cookie(FB_APP_ID, FB_APP_SECRET);
//var_dump($cookie);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/me?access_token='.$cookie['access_token']);
	$userd = curl_exec($ch);
	$user	= json_decode($userd);
	curl_close($ch);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"access_token=".$cookie['access_token']."&message=he publicado mi adoracion en adoralocontodo.com&picture=http://adoralocontodo.com/icono_big.png&link=http://adoralocontodo.com&name=AdoraloConTodo.com");
	//echo 'https://graph.facebook.com/'.$user->username.'/feed';
	curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/'.$user->username.'/feed');
	$postd = curl_exec($ch);
	$post	= json_decode($postd);
	//var_dump($postd);
	curl_close($ch);
?>
<div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?= FB_APP_ID ?>',
          status     : true, 
          cookie     : true,
          xfbml      : true
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
      };

      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
</script>
<?php

$titulo 		= (isset($_POST['titulo']) && $_POST['titulo'] != '')?$_POST['titulo']:'';
$descripcion 	= (isset($_POST['descripcion']) && $_POST['descripcion'] != '')?$_POST['descripcion']:'';

$media_width 	= (isset($oembed->width) && $oembed->width != '')?$oembed->width:'';
$media_height 	= (isset($oembed->height) && $oembed->height != '')?$oembed->height:'';
$contest = '';
$contestval = '';
if(isset($_POST['contest']) && $_POST['contest'] == true){ $contest = ', concurso'; $contestval = ", '1'"; }
if($media_tipo != 'photo')
{
$res = mysql_query("INSERT INTO media (oauth_uid, user_id, fecha_crea, media, link, titulo, descripcion, media_tipo, media_html, media_provider, media_width, media_height$contest) VALUES ('$oauth_uid','$user_id','$fecha_crea','$media','$link','$titulo','$descripcion','$media_tipo','$media_html','$media_provider','$media_width','$media_height'$contestval)");

?>
<script>window.location = 'thanksmedia.php?m=1';</script>
<?php
}else{
?>
<script>window.location = 'thanksmedia.php?m=2';</script>
<?php
}
?>