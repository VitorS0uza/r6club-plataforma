<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(!isset($_SESSION['login_id'])){
require("connection.php");

	if(isset($_COOKIE['login']) and isset($_COOKIE['pass'])){
		$email = filter_var($_COOKIE['login'], FILTER_SANITIZE_EMAIL);
		$senha = $_COOKIE['pass'];
		$verifica_user = mysqli_query($conexao, "SELECT id, senha FROM users WHERE email = '$email' and ativado = '1'");
		if(mysqli_num_rows($verifica_user) == 1){
			$dados = mysqli_fetch_array($verifica_user);
			$senha_hash = $dados['senha'];

			if(password_verify($senha, $senha_hash) == true){
				$_SESSION['login_id'] = $dados['id'];
				header("Location: index");
			}else{
				setcookie('login');
				setcookie('pass');
			}
		}else{
			setcookie('login');
			setcookie('pass');
		}
	}

	if(!isset($_COOKIE['lang'])){
		setcookie('lang','br',time()+60*60*24*30);
		include("lang_br.php");
	}

	if(isset($_GET['br'])){
		setcookie('lang','br',time()+60*60*24*30);
		header("Location: apresentation");
	}elseif(isset($_GET['us'])){
		setcookie('lang','us',time()+60*60*24*30);
		header("Location: apresentation");
	}elseif(isset($_GET['es'])){
		setcookie('lang','es',time()+60*60*24*30);
		header("Location: apresentation");
	}

	if(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'br'){
		include("lang_br.php");
	}elseif(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'us'){
		include("lang_us.php");
	}elseif(isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'es'){
		include("lang_es.php");
	}
?>
<!doctype html>
<html lang="br">
<head>
<meta charset="utf-8">
<title>Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<noscript><?php echo $noscript; ?></noscript>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/home.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<script type="text/javascript" src="js/apresentation.js?40021"></script>
<?php
	if(isset($_GET['disable'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#modal_error').iziModal('setSubtitle','<?php echo $modal_error; ?>');
	$('#modal_error').iziModal('open');
});
</script>
<?php
}
?>
</head>

<body>
	<div id="content">
	<?php include("menu_require.php"); ?>
	<div id="space"></div>
	<div id="chamada">
		<div id="chamada-content">
			<div id="icons_language">
				<a title="Português - Brasil" href="?br"><img alt="Português - Brasil" src="img/br.svg" /></a> <a title="Español" href="?es"><img alt="Español" src="img/es.svg" /></a> <a title="English" href="?us"><img alt="English" src="img/us.svg" /></a>
			</div>
		<h1>
		<small><?php echo $chamada_h1_1; ?></small>
		<?php echo $chamada_h1_2; ?><span><?php echo $chamada_h1_3; ?></span>!
		</h1>
		<div id="modal_jogar_agora"></div>
		<div id="cadastro">
			<div id="login-form">
			<h2><i class="fas fa-sign-in-alt" style="margin-right:3px"></i> <?php echo $form_login; ?></h2>
			<form method="post" action="" class="login" autocomplete="on">
			<label>E-MAIL:</label>
			<input type="email"  name="email" />
			<label><?php echo $pass; ?></label>
			<input type="password" name="senha" />
			<label style="margin:0;">
			<input type="checkbox" class="senha" name="acesso" checked="checked" /><span><?php echo $remember; ?></span>
			</label>
			<input type="hidden" name="login_hidden" />
			<input type="submit" class="login_btn" name="logar" value="<?php echo $entrar; ?>" />
			</form>
			</div>
			<div id="cadastro-form">
			<h2><i class="fas fa-user-plus" style="margin-right:3px"></i> <?php echo $form_cadastro; ?></h2>
			<form method="post" action="" class="cadastro">
			<label>E-MAIL:</label>
			<input type="email" class="email_1"  name="email" />
			<label><?php echo $email_confirm; ?></label>
			<input type="email" class="email_2"  name="email" />
			<label style="margin:0;">
			<input type="checkbox" class="termos" name="termos"/><span><?php echo $termos; ?></span>
			</label>
			<input type="submit" class="cadastro_btn" name="cadastrar" value="<?php echo $cadastrar; ?>" />
			</form>
			</div>
		</div>
		</div>
		
		<div id="modal_error">
			<!--<div id="error_content"><h2><span class="oi" data-glyph="warning"></span>Há algo de errado.</h2></div>-->
		</div>
		<div id="modal_success">
			
		</div>
		
		<div id="modal_cadastro">
			<div id="modal_cadastro_content">
			<?php
			if(!isset($_COOKIE['control_l'])){
			?>
			<form method="post" action="" class="cadastro_modal" autocomplete="off">
			<label>E-MAIL:</label>
			<input placeholder="<?php echo $email_placeholder; ?>" type="email" id="email_modal"  name="email" />
			<label><?php echo $pass; ?></label>
			<input placeholder="<?php echo $pass_placeholder; ?>" type="password" name="password" />
			<label><?php echo $repass; ?></label>
			<input placeholder="<?php echo $repass_placeholder; ?>" type="password" name="password_2" />	
			<label>NICK UPLAY (PC):</label>
			<input placeholder="<?php echo $nick_placeholder; ?>" type="text" maxlength="15" name="nick" />
			<input type="hidden" name="cadastro_hidden" />
			<span><input type="checkbox" name="termos" checked disabled/><?php echo $termos; ?></span>
			<input type="submit" name="envia_cadastro" class="envia_cadastro" value="<?php echo $finalizar_cadastro; ?>" />a
			</form>
			<?php
			}else{
				echo "<p style='color:#ddd;'>Você não pode criar uma nova conta.</p>";
			}
			?>
			</div>
		</div>
		
		
	<div id="oquee">
		<div id="oquee-content">
			<div id="nesk"><img alt="Nesk - pro player de R6" style="border-radius: 100%; width:100%; height:100%;" src="img/nesk.jpg"/></div>
			<div id="oquee-description">
				<h2><small><?php echo $oquee; ?></small> <span>RAINBOW 6: CLUB?</span></h2>
				<p><?php echo $oquee_desc; ?></p>
				<p>#ByPlayersForPlayers.</p>
				<a href="https://twitter.com/r6club_oficial?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="true" data-size='large'>Siga @r6club_oficial</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
		</div>
	</div>
	<div id="modos">
		<div id="modos-content">
			<div id="modos-description">
				<h2><small><?php echo $modos; ?></small> <span><?php echo $modos_free; ?></span></h2>
				<p><?php echo $modos_desc; ?></p>
				<p>#ByPlayersForPlayers.</p>
			</div>
			<div id="patentes"><img alt="Patentes do game" style="width:100%; height:100%;" src="img/patentes.png"/></div>
		</div>
	</div>
		
	</div>
	<?php include('foot.php'); ?>
	</div>
</body>
</html>
<?php
}else{
	header("Location: index.php");
}
?>