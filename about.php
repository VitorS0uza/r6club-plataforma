<?php
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
<title>Rainbow 6: Club - By Players. For Players.</title>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
<link rel="stylesheet" href="css/logged_global.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
<script type="text/javascript">
$(document).ready(function(){
	$('#jogaragora').click(function(){
		$(location).attr('href','index');
	});
});
</script>
<style type="text/css">
#about {
	width:960px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#about h2 {
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

#about_content {
	width:100%;
	padding:20px;
	box-sizing: border-box;
}

#about_content p {
	color:#FFF;
	font-size:15px;
	text-align: justify;
}
</style>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="about">
			<h2>Sobre</h2>
			<div id="about_content">
			<p>Rainbow 6: Club é uma plataforma de matchmaking online para o jogo Rainbow Six: Siege.</p>
			<p>Criada e desenvolvida por um jogador, foi disponibilizada em Agosto de 2018 e continua oferecendo um serviço de qualidade para os usuários e, além disso, totalmente gratuito. Obteve como inspirações R6TMs, da Europa e EUA, e a Gamers Club, famoso clube de Counter Strike: GO.</p>
			<p>Agradecemos aos colaboradores Ricardo 'ikeda' Ikeda e João Pedro 'Venen0' Rezende, e também a comunidade StackOverflow pela grande ajuda.</p>
			</div>
		</div>
	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>