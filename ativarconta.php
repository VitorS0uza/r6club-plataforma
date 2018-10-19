<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(!isset($_SESSION['login_id']) and isset($_GET['token'])){
	require('connection.php');
	$token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);
	//echo "<script>alert('".$token."');</script>";
	$busca_token = mysqli_query($conexao, "SELECT * FROM confirmar_conta WHERE token = '$token'");
	if(mysqli_num_rows($busca_token) == 1){
	$dados = mysqli_fetch_array($busca_token);
	$id_user = $dados['id_user'];
	$estado = $dados['usado'];
		if($estado == 0){
		$busca_usuario = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id_user'");
			if(mysqli_num_rows($busca_usuario) == 1){
				//$dados_user = mysqli_fetch_array($busca_usuario);
				$ativaconta = mysqli_query($conexao, "UPDATE users SET ativado = '1' WHERE id = '$id_user'");
				$ativaconta .= mysqli_query($conexao, "UPDATE confirmar_conta SET usado = '1' WHERE token = '$token'");
				if($ativaconta == true){
					$msg = "A sua conta foi ativada com sucesso! Você já pode logar clicando logo abaixo.";
				}else{
					$msg = "Ocorreu um erro durante a ativação.";
				}
				
			}else{
				$msg = "Conta inexistente.";
			}
			
		}else{
			$msg = "Token já utilizado.";
		}
		
	}else{
		$msg = "Esse token não existe. Por favor, contate o administrador.";
	}

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
<?php include("meta.php"); ?>
<title>Rainbow 6: Club - By Players. For Players.</title>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<style type="text/css">	
#ativacao {
	width:960px;
	margin:0px auto 30px auto;
	border-radius:5px;
	background-color:#131920;
	border:2px solid #131D26;
	padding:15px;
	box-sizing: border-box;
	
}
#ativacao h2 {
	margin:0;
	color:#FFF;
	font-family: 'Open Sans Condensed', sans-serif;
	font-weight: 300;
	font-size:30px;
	text-align: center;
}
#ativacao p {
	color:#FFF;
	font-family: 'Open Sans', sans-serif;
	font-weight: 300;
	font-size:17px;
	text-align: left;
	}
#ativacao button {
	min-width:150px;
	cursor:pointer;
	background-color:#4175C4;
	color:#FFF;
	font-weight:700;
	font-size:17px;
	outline:none;
	border-radius:7px;
	border:none;
	padding:10px 20px 10px 20px;
}

#ativacao button:focus {
	border:none;
}

#ativacao button:hover {
	background-color:#2E5B9F;
	color:#FFF;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="application/javascript">
	$(document).ready(function(){
		$('#jogaragora').click(function(){
			$(location).attr('href','apresentation');
		});
		$('.login').click(function(){
			$(location).attr('href','apresentation');
		});
		
	});
</script>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>
		
		<div id="ativacao">
		<h2>ATIVAÇÃO DE CONTA</h2>
		<p><?php echo $msg; ?></p>
		<button class="login">FAÇA LOGIN AQUI.</button>
		</div>
	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>
<?php
}else{
	header("Location: index");
}
?>