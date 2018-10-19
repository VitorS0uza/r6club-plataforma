<?php
	//LINGUAGEM
	require('connection.php');
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
<title>Contato | Rainbow 6: Club</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
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
#contato {
	width:500px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#contato h2 {
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

#contato_content {
	width:100%;
	padding:20px;
	box-sizing: border-box;
}

#contato_content p {
	color:#FFF;
	font-size:15px;
	text-align: justify;
}

#contato_content form {
	width:100%;
	margin:0px auto;
}

#contato_content input {
	width:100%;
	height:50px;
	border:1px solid #0C1116;
	border-radius:7px;
	background-color:#0B1015;
	padding:10px 20px 10px 20px;
	color:#abb1b3;
	box-sizing:border-box;
	font-size:14px;
	outline: none;
}

#contato_content input:focus {
	border:1px solid #979797;
	background-color:#FFF;
	color:#000;
}

#contato_content label {
	display:block;
	margin-bottom:10px;
	color:#FFF;
	font-weight:500;
	font-size:13px;
	text-transform: uppercase;
	margin-top:10px;
}

#contato_content input[type=submit] {
	width:220px;
	margin-top:15px;
	padding:13px;
	float:right;
	cursor:pointer;
	background-color:#4175C4;
	color:#FFF;
	font-weight:700;
	font-size:17px;
	outline:none;
	border:0;
	border-radius:5px;
}

#contato_content textarea {
	width:100%;
	height:160px;
	border:1px solid #0C1116;
	border-radius:7px;
	background-color:#0B1015;
	padding:10px 20px 10px 20px;
	color:#abb1b3;
	box-sizing:border-box;
	font-size:14px;
	outline: none;
	resize: none;
}

#contato_content textarea:focus {
	border:1px solid #979797;
	background-color:#FFF;
	color:#000;
}


#msg_success {
	width:100%;
	background-color:#478f3d;
	color:#FFF;
	font-size:14px;
	margin:20px auto 0 auto;
	padding:10px;
	box-sizing: border-box;
	border-radius: 5px;
	border:1px solid #8ac982;
}

#msg_erro {
	width:100%;
	background-color:#923a3a;
	color:#FFF;
	font-size:14px;
	margin:20px auto 0 auto;
	padding:10px;
	box-sizing: border-box;
	border-radius: 5px;
	border:1px solid #c56d6d;
}
</style>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="contato">
			<h2>Contato</h2>
			<div id="contato_content">
				<form method="post" action="">
				<label>Nome:</label>
				<input type="text" name="nome" required/>
				<label>Email:</label>
				<input type="email" name="email" required/>
				<label>Mensagem:</label>
				<textarea name="mensagem"><?php
						if(isset($_GET['assunto']) and $_GET['assunto'] == 'Feedback'){
							echo "Olá, tenho um feedback sobre a plataforma:";
						}
					?></textarea>
				<input type="submit" value="Enviar mensagem" name="enviar_msg" />
				</form>
				<div style="clear:both;"></div>
				<?php
					if(isset($_POST['enviar_msg'])){
						$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
						$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
						$mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);
							$insere_contato = mysqli_query($conexao, "INSERT INTO contato (nome, email, msg) VALUES('$nome','$email','$mensagem');");

							if($insere_contato == true) {
								$msg = "Mensagem enviada :)";
							}else{
							$msg = 'Falha ao enviar a mensagem :(';
							}
					}
				?>
				<?php
					if(isset($msg)){
						if($msg == 'Mensagem enviada :)'){
							echo "<div id='msg_success'>Mensagem enviada :)</div>";
						}elseif($msg == 'Falha ao enviar a mensagem :('){
							echo "<div id='msg_erro'>Falha ao enviar a mensagem :(</div>";
						}
					}
				?>
			</div>
		</div>
		
		
		

		

	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>