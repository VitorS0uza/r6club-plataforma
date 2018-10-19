<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formação de Squad | Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
<link rel="stylesheet" href="css/squad.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<script type="text/javascript" src="js/squad.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>
		
		<div id="squad">
			<h2>FORMAÇÃO DE ESQUADRÃO</h2>
			<div id="squad_content">
				<div id="action_squad">
					<form>
						<label>CONVIDE SEUS AMIGOS:</label>
						<input type="text" value="https://r6club.com.br/go/5511" />
						<span>Envie o link acima para seus amigos para que eles possam entrar em seu esquadrão.</span>
					</form>
					
					<div id="buttons_action">
						<div id="button_sair"><button>SAIR DO ESQUADRÃO</button></div>
						<div id="button_iniciar"><button>BUSCAR PARTIDA</button></div>
					</div>

				</div>

				<div id="squad_players">
					<ul>
						<li><a href="#">sadsadsa</a></li>
						<li><a href="#">sadsadsa</a></li>
						<li><a href="#">sadsadsa</a></li>
						<li>sadsadsa</li>
						<li><a href="#">sadsadsa</a></li>
					</ul>
				</div>
			</div>
		</div>	
	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>
<?php
	}else{
		header("Location: apresentation");
	}
?>