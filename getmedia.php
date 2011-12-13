<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
include 'includes/config.php';
include 'includes/functions.php';
// ************************************************************************
// Trae la media que se solicita onDEMAND
// ************************************************************************
$sizecanvas = 800;
$maxperpage = 29;
$twitterReply = 'https://twitter.com/intent/tweet?in_reply_to=';
$twitterRetweet = 'https://twitter.com/intent/retweet?tweet_id=';
$twitterFav = 'https://twitter.com/intent/favorite?tweet_id=';

$pagina 	= (isset($_POST['page']) && $_POST['page'] != '')?$_POST['page']:0;
if($pagina == ''){ $pagina = 1; }
$top 		= ($pagina-1) * 29;

// GET TWEETS #adoralocontodo

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL,"http://search.twitter.com/search.json?q=%23adoralocontodo");
$otweets = curl_exec($ch);
$otweets = json_decode($otweets);
$rtweets = $otweets->results;
//var_dump($rtweets);
insert_tweet($rtweets);

curl_close($ch);

$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
mysql_select_db(BD_NAME);
//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
$res = mysql_query("SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage");
//$res = mysql_query("SELECT * FROM media ORDER BY concurso desc, fecha_crea DESC LIMIT $top,$maxperpage");

$list = '';
$list .= '<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>';
$mcount = 0;
$bigthumb = '';
$bigthumb2 = '';
$moveup = '';

while($r = mysql_fetch_assoc($res)){
	
	$fformated = new DateTime($r['fecha_crea']);
	$fechaformated = $fformated->format('d/m/Y');
	$mwidth = $r['media_width'];
	if($mwidth > '800'){ $mwidth = '800';}
	$mheight =$r['media_height']; 
	if($mheight > '600'){ $mheight = '600';}
	
	$lightbox = 'rel="gallery-'.$mwidth.'-'.$mheight.'"  class="pirobox_gall"';
	
	if($r['media_tipo'] == 'video'){ 
		
	 	$lightbox = 'rel="iframe-'.$mwidth.'-'.$mheight.'" class="pirobox_gall"'; }
	
	if(($mcount % 15)==0){ 
		$bigthumb = "width: 305px; height: 305px;";
		if($r['media_provider'] == 'Twitter'){ $bigthumb2 = "width: 265px; height: 265px; padding: 20px"; }
		$biginfo = " height: 210px; margin-left: 6px; margin-top: 70px; padding-top: 10px; width: 300px;"; 
		$tfbiguser = "tfbiguser"; 
		$tfbigtext = "tfbigtext"; 
	}else{ 
		$bigthumb = ""; $biginfo = ""; $tfbiguser = ""; $tfbigtext = ""; $bigthumb2 = '';
	}
	if(($mcount % 16)==0 || ($mcount % 18)==0 || ($mcount % 20)==0){ $moveup = " margin-top:-160px; clear:right"; }else{ $moveup = "";}
	if($mcount == 0){ $moveup = ""; }
	
	if($r['media_provider'] == 'Twitter'){
		$lightbox = 'rel="iframe-400-150" class="pirobox_gall"';
		if($r['link'] != ''){

			$lightbox = 'rel="iframe-'.$mwidth.'-'.$mheight.'" class="pirobox_gall"';
			
			$list .= '<li class="thumbmask" style="'.$bigthumb.''.$moveup.'" id="thumbmasktrail">';
			if($r['media_tipo'] == 'photo'){ $lnk_media = $r['media']; }
			if($r['media_tipo'] == 'tweet'){ $lnk_media = $r['link']; }
			if($r['media_tipo'] == 'video'){ $lnk_media = $r['link']; }
		
			$list .= '<a href="'.$lnk_media.'" title="'.$r['titulo'].'" '.$lightbox.'><img src="'.$r['media'].'" alt="'.$r['titulo'].'" border="0" class="tumbimg"  style="'.$bigthumb.'"></a>';
			$list .= '<div id="tweetfichainfo" style="padding-top:1px; '.$biginfo.'">';
			if($tfbiguser != ''){
				$list .= '<br><br><span class="'.$tfbiguser.'">'.$r['titulo'].'</span>';
			}else{
				$list .= '<span style="font-size:12px; font-weight:bold; margin-top:5px; margin-botton:5px; display:block">'.$r['titulo'].'</span>';
			}
			$list .= '<div style="font-size:9px">'.$fechaformated.'</div>';
			$list .= '<a href="'.$twitterReply.$r['tweet_id'].'" alt="Responder"><img src="images/reply.png" alt="reply" border="0"/></a>';
			$list .= '<a href="'.$twitterRetweet.$r['tweet_id'].'" alt="Retuitear"><img src="images/retweet.png" alt="reply" border="0"/></a>';
			$list .= '<a href="'.$twitterFav.$r['tweet_id'].'" alt="Hacerlo Favorito"><img src="images/favorite.png" alt="reply" border="0"/></a>';
			$list .= '<br/>';
			$list .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$r['link'].'" data-text="#AdoraloConTodo" data-count="none">Tweet</a> &nbsp; ';
			$list .= '<iframe src="//www.facebook.com/plugins/like.php?href='.urlencode($r['link']).'&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=284281954937902" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe>';
			$list .= '</div>';
		
		}else{
		
		$list .= '<li id="thumbmasktrail" class="thumbmask" style="'.$bigthumb.''.$moveup.'">';
		$list .= '<div id="tweetficha" style="'.$bigthumb2.'">';
			$list .= '<div id="tweetfichaheader">';
				$list .= '<div id="tweetfichaimg">';
					$list .= '<a href="getTweet.php?tid='.$r['tweet_id'].'" '.$lightbox.'>';	
					$list .= '<img src="'.$r['media'].'" border="0" width="40" />';
					$list .= '</a>';
				$list .= '</div>';
				$list .= '<div id="tweetfichauser" class="'.$tfbiguser.'">';
					$list .= '<a href="getTweet.php?tid='.$r['tweet_id'].'" '.$lightbox.'>';
					$list .= $r['tweet_user'];
					$list .= '</a>';
				$list .= '</div>';
				$list .= '<div class="clearfix"></div>';
			$list .= '</div>';
			$list .= '<div id="tweetfichabody" class="'.$tfbigtext.'">';
				$list .= '<div id="tweetfichatext">'.$r['tweet_text'].'</div>';
			$list .= '</div>';
		$list .= '</div>';
		$list .= '<div id="tweetfichainfo" style="padding-top:1px; '.$biginfo.'">';
			$list .= '<a href="'.$twitterReply.$r['tweet_id'].'" alt="Responder"><img src="images/reply.png" alt="reply" border="0"/></a>';
			$list .= '<a href="'.$twitterRetweet.$r['tweet_id'].'" alt="Retuitear"><img src="images/retweet.png" alt="reply" border="0"/></a>';
			$list .= '<a href="'.$twitterFav.$r['tweet_id'].'" alt="Hacerlo Favorito"><img src="images/favorite.png" alt="reply" border="0"/></a>';
			$list .= '<br/>';
			$list .= '<div style="font-size:9px">'.$fechaformated.'</div>';
			$list .= '<br/>';
			$list .= '<iframe src="//www.facebook.com/plugins/like.php?href='.urlencode($r['link']).'&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=284281954937902" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe>';
		$list .= '</div>';
			
		}
	}else{
		$class = "tumbimg";
		if($bigthumb != ''){
			$list .= '<li class="thumbmask" style="'.$bigthumb.''.$moveup.'" id="thumbmasktrail">';
			$class = "tumbimgbig";
			$showmoretext = $r['descripcion'];
		}else{
			$list .= '<li class="thumbmask thumbmasktrail" style="'.$bigthumb.''.$moveup.'" id="thumbmasktrail">';
		}
		
		if($r['media_tipo'] == 'photo'){ $lnk_media = $r['media']; }
		if($r['media_tipo'] == 'video'){ $lnk_media = $r['link']; }
		
		$list .= '<a href="'.$lnk_media.'" title="'.$r['titulo'].'" '.$lightbox.'><img src="'.$r['media'].'" alt="'.$r['titulo'].'" border="0" class="'.$class.'"></a>';
		
		$list .= '<div id="tweetfichainfo" style=" margin-top:79px; '.$biginfo.'">';
		$list .= '<span style="font-size:10px; font-weight:bold; margin-botton:5px;">'.$r['titulo'].'</span>';
		$list .= '<br/>';
		$list .= '<div style="font-size:9px">'.$fechaformated.'</div>';
		$list .= '<p>'.$showmoretext.'</p>';
		$list .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$r['link'].'" data-text="#AdoraloConTodo" data-count="none">Tweet</a> &nbsp; ';
		$list .= '<iframe src="//www.facebook.com/plugins/like.php?href='.urlencode($r['link']).'&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=284281954937902" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe>';
		$list .= '<br/>';
		$list .= '</div>';
	}
	if($r['concurso'] == '1'){ 
		$list .= '<div class="concursante"><img src="images/reto29_badge.png" alt="reto29_badge" width="50"/></div>';
	}
	$list .= '</li>';
	$mcount++;
	
}

?><div id="fb-root"></div>
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
};
        
$("ul.thumb li.thumbmask").hover(function() {
//	$(this).css({'z-index' : '10'});
	$(this).find('#tweetfichainfo').fadeIn(200);
	} , function() {
	$(this).find('#tweetfichainfo').fadeOut(200);
});

$("ul.thumb li.thumbmask").hover(function() {
//	$(this).css({'z-index' : '10'});
	$(this).find('#tweetfichainfo').fadeIn(200);
	} , function() {
	$(this).find('#tweetfichainfo').fadeOut(200);
});

$(function() {
				$().piroBox_ext({
					piro_speed : 700,
					bg_alpha : 0.5,
					piro_scroll : true // pirobox always positioned at the center of the page
				});
			});

</script><?php
echo $list


// ************************************************************************
?>