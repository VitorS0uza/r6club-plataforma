<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$email = $dados_user['email'];
	$img_perfil = $dados_user['img_perfil'];
	$pass_atual_crypt = $dados_user['senha'];
	//VERIFICA SE USUÁRIO NÃO ESTÁ BUSCANDO PARTIDA
	$busca_searching = mysqli_query($conexao, "SELECT id_user, ativo FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0'");
	$busca_playing = mysqli_query($conexao, "SELECT id_user, ativo FROM users_buscando WHERE id_user = '$id' AND ativo = '1' AND playing = '1' AND id_lobby != '0'");
		if(mysqli_num_rows($busca_searching) == 1){
			header("Location: buscando");
			echo "<script type='text/javascript'>window.location.href='buscando';</script>";
			exit();
		}
		if(mysqli_num_rows($busca_playing) == 1){
			header("Location: play");
			echo "<script type='text/javascript'>window.location.href='play';</script>";
			exit();
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
<title>Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
<style type="text/css">
	/* PASS */
@charset "utf-8";

#modal_gamemode {
	background-color:#0F1319;
	display:none;
}

#modal_gamemode_content {
	padding:30px; 
	box-sizing: border-box;
}

#gamemode {
	width:100%;
	padding:15px;
	box-sizing: border-box;
	background-image: url(../img/bg_gamemode.jpg);
	background-size:100%;
	background-repeat: no-repeat;
	border-radius:5px;
	border:2px solid #212e3a;
	margin-bottom:15px;
	display: flex;
  	flex-direction: row;
  	justify-content: space-between;
  	align-items: center;
	cursor:pointer;
}

#gamemode h2 {
	margin:0;
	color:#FFF;
	font-weight:300;
	font-size:25px;
	width:100%;
}

#gamemode h2 small {
	font-size:17px;
}

#gamemode i {
	color:#FFF;
	font-size:18px;
}

#gamemode:hover {
	opacity:0.6;
}

#pass {
	width:470px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#pass h2 {
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

#pass_content {
	width:100%;
	padding:20px;
	box-sizing: border-box;
}

#pass_content form {
	width:400px;
	margin:0px auto;
}

#pass_content input {
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

#pass_content input:focus {
	border:1px solid #979797;
	background-color:#FFF;
	color:#000;
}

#pass_content label {
	display:block;
	margin-bottom:10px;
	color:#FFF;
	font-weight:500;
	font-size:13px;
	text-transform: uppercase;
	margin-top:10px;
}

#pass_content input[type=submit] {
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

#msg_success {
	width:400px;
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
	width:400px;
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

		<div id="pass">
			<h2><i style="margin-right:5px;" class="fas fa-key"></i> Alterar senha</h2>
			<div id="pass_content">
				<form method="post" action="">
				<label>Senha atual:</label>
				<input type="password" name="pass_atual" required/>
				<label>Senha nova:</label>
				<input type="password" name="pass_new" required/>
				<label>Repita a senha nova:</label>
				<input type="password" name="repass_new" required/>
				<input type="submit" value="ALTERAR SENHA" name="alterar_senha" />
				</form>
				<?php
				if(isset($_POST['alterar_senha'])){
					$pass_atual = hash("sha256", $_POST['pass_atual']);
					$pass_new = $_POST['pass_new'];
					$repass_new = $_POST['repass_new'];
					if($pass_new == $repass_new){
						if($pass_atual == $pass_atual_crypt){
						if(hash("sha256", $pass_new) != $pass_atual_crypt){
								if(strlen($pass_new) >= 5 and strlen($pass_new) <= 24){
									$muda_senha = mysqli_query($conexao,"UPDATE users SET senha = '".hash("sha256", $pass_new)."' WHERE id = '$id'");
									if($muda_senha == true){
										$msg = 'success';
									}else{
										$msg = 'erro';
									}
								}else{
									$msg = 'tamanho_senha';
								}
							}else{
								$msg = 'senha_atual_igual';
							}
						}else{
							$msg = 'senha_atual_incorreta';
						}
					}else{
						$msg = "repass";
					}
				}
				?>
				<div style="clear:both;"></div>
				<?php
				if(isset($msg)){
					switch($msg){
						case 'success';
						echo "<div id='msg_success'>Senha alterada com sucesso.</div>";
						break;

						case 'erro';
						echo "<div id='msg_erro'>Ocorreu um erro ao alterar sua senha.</div>";
						break;

						case 'tamanho_senha';
						echo "<div id='msg_erro'>Senha deve ter entre 5 e 24 caracteres.</div>";	
						break;

						case 'senha_atual_incorreta';
						echo "<div id='msg_erro'>Senha atual está incorreta.</div>";		
						break;

						case 'senha_atual_igual';
						echo "<div id='msg_erro'>A sua senha atual já é esta.</div>";
						break;

						case 'repass';
						echo "<div id='msg_erro'>Digite novamente a nova senha.</div>";
						break;
					}
				}
				?>
				<div style="clear:both;"></div>
			</div>
		</div>
		

		<?php include('gamemode_modal.php'); ?>
	<?php include('foot.php'); ?>
	</div>

</body>
</html>
<?php
}else{
	header("Location: apresentation");
}
?>