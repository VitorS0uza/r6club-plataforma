<?php
session_name(md5("www.r6club.com.br"));
session_start();
require('connection.php');
$id = (is_numeric($_GET['id']) == true) ? $_GET['id'] : NULL;
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	$id_user = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id_user'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$img_perfil = $dados_user['img_perfil'];
}
$busca_noticia = mysqli_query($conexao, "SELECT * FROM news WHERE id = '$id'");
if(mysqli_num_rows($busca_noticia) == 1){
	$dados = mysqli_fetch_array($busca_noticia);
	$titulo = $dados['title'];
	$content = $dados['content'];
	$data = date("H:i d/m/Y", strtotime($dados['date']));
	$autor = $dados['autor'];	
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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $titulo; ?> | Rainbow 6: Club</title>
<meta name="description" content="Participe do Rainbow 6: Club e encontre partidas ONLINE! Estatísticas, patentes e tudo sobre Rainbow Six: Siege." />
<meta name="keywords" content="rb6, rainbow six siege, rainbow 6, tom clancys, esports, nesk, zigueira, cherrygumms, liquid, e-sports, pro league, r6tm,  latam, r6 club" />
<meta name="Copyright" content="Rainbow 6: Club" />
<meta name="Title" content="Rainbow 6: Club - By Players. For Players." />
<meta name="autor" content="Rainbow 6: Club" />
<meta name="company" content="Rainbow 6: Club" />
<meta name="Distribution" content="Global" />
<meta name="Language" content="Portuguese" />
 <!-- Facebook -->
<meta property="og:title" content="<?php echo $titulo; ?>">
<meta property="og:site_name" content="Rainbow 6: Club">
<meta property="og:url" content="https://r6club.com.br/news/<?php echo $id; ?>">
<meta property="og:image" content="https://r6club.com.br/img/og_img.png">
<meta property="og:description" content="Notícias de Rainbow Six Siege.">
<meta property="og:type" content="website">
<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@r6club_oficial">
<meta name="twitter:title" content="<?php echo $titulo; ?>">
<meta name="twitter:description" content="Participe do Rainbow 6: Club e encontre partidas ONLINE!">
<meta name="twitter:creator" content="@r6club_oficial">
<meta name="twitter:image" content="https://r6club.com.br/img/og_img.png">
<link rel="icon" href="/favicon.ico"/>
<link rel="stylesheet" href="/css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="/css/news.css"/>
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
	$('#news_content a').attr('target','_blank');
});
</script>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="news">
			<h2><i style="margin-right:5px;" class="far fa-newspaper"></i> <?php echo $titulo; ?></h2>
			
			<div id="news_content">
				<div id="date"><?php echo $data; ?> - POR <?php echo strtoupper($autor); ?></div>
				<?php echo $content; ?>
				</div>
		</div>
		
	<?php include('foot.php'); ?>
	</div>

</body>
</html>
<?php
}else{
	header("Location: /index");
}
?>