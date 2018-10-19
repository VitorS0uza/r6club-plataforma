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
		// VERIFICA SE USER ESTÁ BUSCANDO PARTIDA
		$busca_searching = mysqli_query($conexao, "SELECT * FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0'");
		if(mysqli_num_rows($busca_searching) == 1){
			$dados_busca = mysqli_fetch_array($busca_searching);
			

			// ALTERAR CASO ADICIONE MAIS GAMEMODES
			$gamemode = ($dados_busca['gamemode'] == 'rankedopen') ? 'RANKED OPEN' : '4 FUN';
			$users_buscando = mysqli_num_rows(mysqli_query($conexao, "SELECT id FROM users_buscando WHERE gamemode = '{$dados_busca['gamemode']}' AND playing = '0' AND reservados = '0'"));


			$tempo_inicio = strtotime($dados_busca['tempo_inicio']);
			$timeWatchInitial = time()-$tempo_inicio;
			$timeWatch = (time()-$tempo_inicio)*1000;

			if(isset($_GET['cancel'])){
				$busca_searching1 = mysqli_query($conexao, "SELECT * FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0' and reservados = '0'");
				if(mysqli_num_rows($busca_searching1)){
				$deleta_busca = mysqli_query($conexao, "DELETE FROM users_buscando WHERE id_user ='$id' and ativo = '1'");
				header("Location: index?cancel");
				echo "<script type='text/javascript'>window.location.href='index?cancel';</script>";
				exit();
				}
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
<title>Buscando... | Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
<link rel="stylesheet" href="css/search.css?1"/>
<link rel="stylesheet" href="css/loaders.css"/>
<link rel="stylesheet" href="css/iziModal.min.css"/>
<link rel="stylesheet" href="css/TimeCircles.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<script type="text/javascript" src="js/TimeCircles.js"></script>
<script type="text/javascript" src="js/push_notification.min.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
</head>

<body>
	<audio id="corneta" controls style="display: none;">
    	<source src="audio/found.mp3" type="audio/mp3">
	</audio>
	<div id="modal_init"></div>
	<div id="content">
	<?php include("menu_require.php"); ?>
		<div id="space"></div>
		<div id="id_profile"><h1><?php echo $gamemode; ?> <small>ID: <?php echo $id; ?></small><i class="fas fa-search config"></i></h1>
		</div>
		<div id="search_content">
			<div id="timer">
				<h2>TEMPO DECORRIDO <i class="far fa-clock"></i></h2>
				<h3><?php echo gmdate('H:i:s', $timeWatchInitial); ?></h3>
			</div>
			<div id="search_stats"><h2>BUSCANDO...</h2>
								<div class="loader">
						        <div class="loader-inner line-scale">
						          <div></div>
						          <div></div>
						          <div></div>
						          <div></div>
						          <div></div>
						        </div>
						        </div>
  			</div>
		</div>
		<div class="users_on" style="color:#ddd; text-align: center; margin-bottom:15px; font-family: 'Open Sans Condensed'; font-size:22px; text-transform: uppercase;">Usuários nesta fila: <span><?php echo $users_buscando; ?></span> usuários.</div>
		<div id="button_cancel"><button onclick="window.location.href='?cancel';">CANCELAR BUSCA <i class="fas fa-ban"></i></button></div>
		

		<div style="margin-top:150px;"></div>
		<div id="modal_info_time"></div>
		<div id="modal_error"></div>
		<?php
		$busca_user = mysqli_query($conexao, "SELECT id_user FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0' and click_modal = '1' and reservados = '1'");
		$id_lobby = ($dados_busca['id_lobby'] == 0) ? NULL : $dados_busca['id_lobby'];
		if($id_lobby != NULL){
		$busca_lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE id = '$id_lobby'"));
		$tempo_inicio = $busca_lobby['tempo_inicio'];
		$Tempo_Counter = 30 - (time() - strtotime($tempo_inicio));
		}else{
			$Tempo_Counter = 30;
		}
		?>
		<div id="modal_check">
			<div id="modal_check_content">
				<div id="Counter" style="width:150px; height:150px; margin:0px auto; color:#FFF;" data-timer="<?php echo $Tempo_Counter; ?>"></div>
				<?php
				if(mysqli_num_rows($busca_user) == 1){
				?>
				<div id="player">
				<div style="background-color: #5a9c40!important;"></div>
				</div>
				<?php
				}else{
				?>
				<div id="player">
				<div></div>
				</div>

				<?php
				}
				if(mysqli_num_rows($busca_user) == 1){
					echo "<p>AGUARDANDO JOGADORES...</p>";
				}elseif(mysqli_num_rows($busca_user) == 0){
				?>
				<button id="confirm_match">CONFIRMAR</button>
				<?php
				}
				?>
			</div>
		</div>


	
	<?php include('foot.php'); ?>
	</div>
<script type="text/javascript" src="js/jquery.stopwatch.js"></script>
<script type="text/javascript" src="js/buscando.js?10000"></script>
<script type="text/javascript">
$(document).on('opening', '#modal_check', function () {
	$('#Counter').TimeCircles({count_past_zero: false, time: {Days: {show: false}, Hours: {show:false}, Minutes: {show:false}, Seconds: {text: 'Segundos', color: '#6dd045'}}});
	function VerificaTimeCircle() {
		var Verificacao2 = setInterval(function(){
			if($('#Counter').TimeCircles().getTime() < 0){
				$.ajax({
					url: 'match.php',
					success: function(data){
						if(data === 'success'){
							$(location).attr('href','play#choosemap');
						}
						if(data === 'no'){
							$(location).attr('href','index?errormatch');
						}
						if(data === 'error'){
							$('#modal_error').iziModal('setSubtitle','Desculpe-nos, mas ocorreu um erro :(');
							$('#modal_error').iziModal('open');
						}
					},
					error: function(){
						alert("ERRO: Tente novamente mais tarde.");
					}
				});
				clearInterval(Verificacao2);
			}
		}, 1000);
	}
	VerificaTimeCircle();
});
$(document).ready(function(){

	$('#timer h3').stopwatch({startTime: <?php echo $timeWatch; ?>}).stopwatch('start');


	function VerificaCronometro() {
		var Verificacao = setInterval(function() {
		if($('#timer h3').text() === '00:05:00' && $('#modal_check').iziModal('getState') === 'closed'){
				$('#modal_info_time').iziModal('open');
				clearInterval(Verificacao);
		}
		}, 1000);
	}
	VerificaCronometro();
});
</script>

<?php 
if(isset($_GET['init'])){
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_init').iziModal('open');
	});
</script>
<?php
}
?>

</body>
</html>
<?php
	}else{
		header("Location: index");
	}
}else{
	header("Location: apresentation");
}
?>