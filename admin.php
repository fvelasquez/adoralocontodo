<?php
include 'checkauth.php';
include 'includes/config.php';
include 'includes/functions.php';
// ************************************************************************
// Trae la media que se solicita onDEMAND
// ************************************************************************
$sizecanvas = 800;
$maxperpage = 29;

$pagina 	= (isset($_GET['page']) && $_GET['page'] != '')?$_GET['page']:0;
if($pagina == ''){ $pagina = 1; }
$top 		= ($pagina-1) * 29;


$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
mysql_select_db(BD_NAME);
//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
$res = mysql_query("SELECT * FROM media ORDER BY concurso desc, fecha_crea DESC LIMIT $top,$maxperpage");

$list = '';
$mcount = 0;
$bigthumb = '';
$bigthumb2 = '';
$moveup = '';
?>
<head>
	<style>
		body { font-family: Helvetica, Arial; font-size: 11px; color: #303030}
		ul li { list-style: none; display:block; }
		#thumbmasktrail li { border-bottom: 3px solid #a0a0a0; padding: 10px; }
		#numcount li { display: inline; }
	</style>
</head>
<body>
<ul id="thumbmasktrail">
<?php
$cc = 0;
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
while($r = mysql_fetch_assoc($res)){
	$cc++;
	$fformated = new DateTime($r['fecha_crea']);
	$fechaformated = $fformated->format('d/m/Y H:i:s');
	$showmoretext = $r['descripcion'];
	if($showmoretext == ''){ 
		$showmoretext = $r['tweet_text'];
		if(preg_match($reg_exUrl, $showmoretext, $url))
		{ 
			$showmoretext = preg_replace($reg_exUrl, "<a href=".$url[0].">{$url[0]}</a> ", $showmoretext);
		}
	}
	
	$color =(($cc % 2) == 0)?'background-color:#f0f0f0':'background-color:#ffffff';
	
	if($r['media_provider'] == 'Twitter'){
		if($r['link'] != ''){
			
			$list .= '<li style="'.$color.'">';
			if($r['media_tipo'] == 'photo'){ $lnk_media = $r['media']; }
			if($r['media_tipo'] == 'tweet'){ $lnk_media = $r['link']; }
			if($r['media_tipo'] == 'video'){ $lnk_media = $r['link']; }
		
			$list .= '<a href="'.$lnk_media.'" title="'.$r['titulo'].'"><img src="'.$r['media'].'" alt="'.$r['titulo'].'" border="0"  width="100"></a>';
			$list .= '<div id="tweetfichainfo">';
			$list .= '<span>'.$r['titulo'].'</span>';
			$list .= '<p>'.$showmoretext.'</p>';
			$list .= '<div>'.$fechaformated.'</div>';
			$list .= '</div>';
		
		}else{
		
		$list .= '<li style="'.$color.'">';
		$list .= '<div id="tweetficha">';
			$list .= '<div id="tweetfichaheader">';
				$list .= '<div id="tweetfichaimg">';
					$list .= '<a href="getTweet.php?tid='.$r['tweet_id'].'">';
					$list .= '<img src="'.$r['media'].'" border="0" width="40" />';
					$list .= '</a>';
				$list .= '</div>';
				$list .= '<div id="tweetfichauser">';
					$list .= '<a href="getTweet.php?tid='.$r['tweet_id'].'">';
					$list .= $r['tweet_user'];
					$list .= '</a>';
				$list .= '</div>';
				$list .= '<div id="tweetfichatext">'.$showmoretext.'</div>';
			$list .= '</div>';
			$list .= '<div style="font-size:9px">'.$fechaformated.'</div>';
		$list .= '</div>';
			
		}
	}else{
		$list .= '<li style="'.$color.'">';
		
		if($r['media_tipo'] == 'photo'){ $lnk_media = $r['media']; }
		if($r['media_tipo'] == 'video'){ $lnk_media = $r['link']; }
		
		$list .= '<a href="'.$lnk_media.'" title="'.$r['titulo'].'"><img src="'.$r['media'].'" alt="'.$r['titulo'].'" border="0"  width="100"></a>';
		$list .= '<div id="tweetfichainfo">';
		$list .= '<span style="font-size:12px; font-weight:bold; margin-top:5px; margin-botton:5px;">'.$r['titulo'].'</span>';
		$list .= '<div style="font-size:9px">'.$fechaformated.'</div>';
		$list .= '<p>'.$showmoretext.'</p>';
		$list .= '</div>';
	}

	$list .= '<a href="admin_ax.php?ax=concursante&id='.$r['id'].'"><img src="images/add.png" alt="Agregar al Reto29" /> Reto29</a> &nbsp; ';
	$list .= '<a href="admin_ax.php?ax=delete&id='.$r['id'].'"><img src="images/cross.png" alt="Eliminar" /> Eliminar</a> &nbsp; ';
	$list .= '<a href="admin_ax.php?ax=bloquear&id='.$r['id'].'&tid='.$r['tweet_user'].'"><img src="images/delete.png" alt="Bloquear" /> Bloquear</a>';
	
	$list .= '</li>';
	$mcount++;
	
}
echo $list;


// ************************************************************************
$tot = totalpages();

?>
</ul>
<div>
	<ul id="numcount">
		<?php for($i = 1;$i <= $tot;$i++) { ?>
		<li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		<?php } ?>
	</ul>
</div>
</body>