<?php
session_name(md5("www.r6club.com.br"));
session_start();
require('connection.php');
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	$id_user = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id_user'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$img_perfil = $dados_user['img_perfil'];

	//LINGUAGEM

	if(!isset($_COOKIE['lang'])){
	 	setcookie('lang','br',time()+60*60*24*30);
		include("lang_br.php");
	}

	if(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'br'){
		include("lang_br.php");
	}elseif(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'us'){
		include("lang_us.php");
	}elseif(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'es'){
		include("lang_es.php");
	}


	//FIM LINGUAGEM
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Todas Notícias | Rainbow 6: Club</title>
<meta name="description" content="Participe do Rainbow 6: Club e encontre partidas ONLINE! Estatísticas, patentes e tudo sobre Rainbow Six: Siege." />
<meta name="keywords" content="rb6, rainbow six siege, rainbow 6, tom clancys, esports, nesk, zigueira, cherrygumms, liquid, e-sports, pro league, r6tm,  latam" />
<meta name="Copyright" content="Rainbow 6: Club" />
<meta name="Title" content="Rainbow 6: Club - By Players. For Players." />
<meta name="autor" content="Rainbow 6: Club" />
<meta name="company" content="Rainbow 6: Club" />
<meta name="Distribution" content="Global" />
<meta name="Language" content="Portuguese" />
 <!-- Facebook -->
<meta property="og:title" content="Todas Notícias | Rainbow 6: Club">
<meta property="og:site_name" content="Rainbow 6: Club">
<meta property="og:url" content="https://r6clubtest.000webhostapp.com/news/all">
<meta property="og:image" content="https://r6clubtest.000webhostapp.com/123.png">
<meta property="og:description" content="Notícias de Rainbow Six Siege.">
<meta property="og:type" content="website">
<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@r6club_oficial">
<meta name="twitter:title" content="Todas Notícias | Rainbow 6: Club">
<meta name="twitter:description" content="Participe do Rainbow 6: Club e encontre partidas ONLINE!">
<meta name="twitter:creator" content="@r6club_oficial">
<meta name="twitter:image" content="https://r6clubtest.000webhostapp.com/123.png">
<link rel="icon" href="/favicon.ico"/>
<link rel="stylesheet" href="/css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="/css/iziModal.min.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/iziModal.min.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
<script type="text/javascript">
$(document).ready(function(){
	$('#jogaragora').click(function(){
		$(location).attr('href','index');
	});
});
</script>
<style type="text/css">
#news {
	width:960px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#news h2 {
	background-color:#101417;
	color:#FFF;
	font-family: 'Open Sans Condensed', sans-serif;
	font-weight:300;
	text-transform: uppercase;
	font-size:30px;
	padding:10px 10px 10px 20px;
	box-sizing: border-box;
	margin:0;
}

#news_content {
	width:100%;
	padding:20px;
	box-sizing: border-box;
}

#news_content p {
	color:#FFF;
	font-size:15px;
	text-align: justify;
}

#news_content a {
	color:#3278cd;
	display: block;
	margin-bottom:10px;
	text-decoration: none;
	}
</style>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="news">
			<h2><i style="margin-right:5px;" class="far fa-newspaper"></i> Notícias (últimas 50)</h2>
			<div id="news_content">
			<?php
			$busca_noticias = mysqli_query($conexao, "SELECT * FROM news LIMIT 50");
			if(mysqli_num_rows($busca_noticias) > 0){
				while($dados = mysqli_fetch_array($busca_noticias)){

			?>
			<a href="/news/<?php echo $dados['id']; ?>">>> <?php echo $dados['title']; ?></a>
			<?php
				}
			}
			?>
			</div>
		</div>

		<?php include('foot.php'); ?>
	</div>

</body>
</html>