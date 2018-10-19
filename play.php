<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
	$_SESSION['time_chat'] = date("Y-m-d H:i:s");
	$id = $_SESSION['login_id'];

	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$email = $dados_user['email'];
	$img_perfil = $dados_user['img_perfil'];
	//VERIFICA SE USUÁRIO NÃO ESTÁ BUSCANDO PARTIDA
	$busca_searching = mysqli_query($conexao, "SELECT * FROM users_buscando WHERE id_user = '$id' and playing = '0'");
	$busca_playing = mysqli_query($conexao, "SELECT * FROM users_buscando WHERE id_user = '$id' and playing = '1'");
		if(mysqli_num_rows($busca_searching) == 1){
			header("Location: buscando");
			echo "<script type='text/javascript'>window.location.href='buscando';</script>";
			exit();
		}
		if(mysqli_num_rows($busca_playing) == 0){
			header("Location: index");
			echo "<script type='text/javascript'>window.location.href='index';</script>";
			exit();
		}else{
	
	$dados = mysqli_fetch_array($busca_playing);

	if($dados['data_entrou_lobby'] == NULL){
		$data_entrou_lobby = date("Y-m-d H:i:s");
		$update = mysqli_query($conexao, "UPDATE users_buscando SET data_entrou_lobby = '$data_entrou_lobby' WHERE id_user = '$id'");
	}

	$id_lobby = $dados['id_lobby'];
	$busca_lobby = mysqli_query($conexao, "SELECT * FROM lobby WHERE id = '$id_lobby' and cancelado = '0' and finalizado = '0'");
	if(mysqli_num_rows($busca_lobby) == 1){
		$dados_lobby = mysqli_fetch_array($busca_lobby);

		$time_azul = $dados_lobby['time_azul'];
		$time_laranja = $dados_lobby['time_laranja'];

		$time_azul_array = explode(',',$dados_lobby['time_azul']);
		$time_laranja_array = explode(',', $dados_lobby['time_laranja']);

		$type = $dados_lobby['type'];
		$capitao_azul = $dados_lobby['capitao_azul'];
		$capitao_laranja = $dados_lobby['capitao_laranja'];

		$tempo_inicio = $dados_lobby['tempo_inicio'];

		$mapa = $dados_lobby['mapa'];

			if($dados_lobby['tempo_countdown'] === NULL){
				$tempo_atual = date("Y-m-d H:i:s");
				$update = mysqli_query($conexao, "UPDATE lobby SET tempo_countdown = '$tempo_atual' WHERE id = '$id_lobby'");

			}else{
				$tempo_atual = $dados_lobby['tempo_countdown'];
			}

	}else{
			header("Location: index?cancellobby");
			echo "<script type='text/javascript'>window.location.href='index?cancellobby';</script>";
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
<title>Lobby <?php echo $id_lobby; ?> | Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="css/play.css?v=1.0.0"/>
<link rel="stylesheet" href="css/iziModal.min.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<style type="text/css">
#chat_box::-webkit-scrollbar         {width:8px; background:none;}
#chat_box::-webkit-scrollbar-thumb   {background:rgba(38,56,73,0.2); border-radius:10px;}
</style>
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<script type="text/javascript" src="js/jquery.preload.min.js?v=1.0.0"></script>
<script type="text/javascript" src="js/play.js?v=1.0.0"></script>
</head>

<body>
	<?php
	$busca_votos = mysqli_query($conexao, "SELECT id FROM map_votes WHERE id_user = '$id' AND id_lobby = '$id_lobby'");
	?>
	<div id="content">
	<?php include("menu_require.php"); ?>
		<div id="space"></div>
		

		<div id="play_content">
			<div id="info">
				<div>
				<p>Nº LOBBY <?php echo $id_lobby; ?></p>
				<p>GAMEMODE: <?php if($dados_lobby['type'] == '4fun'){echo "4FUN";}elseif($dados_lobby['type'] == 'rankedopen'){echo "RANKED open";} ?> - MD1</p>
				</div>
				<div>
				<a target="_blank" title="Regras do lobby e criação de partidas" href="regras">Regras do lobby e criação de partidas</a>
				</div>
			</div>
			<div id="time_azul">
				<div id="head_time_azul">
				<h2>EQUIPE <span>AZUL</span></h2>
				</div>	
				
				<div id="players_time_azul">
				<ul>
				<?php
				$busca_capitao_azul = mysqli_query($conexao, "SELECT * FROM users WHERE id = '$capitao_azul'");
				$dados_capitao_azul = mysqli_fetch_array($busca_capitao_azul);
				?>
				<li><a target="_blank" href="/profile/<?php echo $dados_capitao_azul['id']; ?>"><?php echo $dados_capitao_azul['nick']; ?></a><?php if($dados_capitao_azul['premium'] == 1){ echo '<i title="Premium" class="fas fa-fire premium"></i>';}?><?php if($dados_capitao_azul['verificado']== 1){echo '<i title="Verificado" class="fas fa-check verificado"></i>';} ?><?php if($dados_capitao_azul['nick'] == $nick){ $time = 'azul'; echo '<span id="you">VOCÊ</span>';}?> <span class="capitao">CAPITÃO</span></li>
				<?php
				$busca_user_azul = mysqli_query($conexao, "SELECT * FROM users WHERE id IN ($time_azul) and id != '$capitao_azul' LIMIT 5");
				while($dados_azul = mysqli_fetch_array($busca_user_azul)){
					$nick_azul = $dados_azul['nick'];
					$verificado_azul = $dados_azul['verificado'];
					$premium_azul = $dados_azul['premium'];
				?>
				<li><a target="_blank" href="/profile/<?php echo $dados_azul['id']; ?>"><?php echo $nick_azul; ?></a><?php if($premium_azul == 1){echo '<i title="Premium" class="fas fa-fire premium"></i>';} ?><?php if($verificado_azul == 1){echo '<i title="Verificado" class="fas fa-check verificado"></i>';} ?><?php if($nick_azul == $nick){ $time = 'azul'; echo '<span id="you">VOCÊ</span>';}?> <?php if($dados_azul['id'] == $capitao_azul){echo '<span class="capitao">CAPITÃO</span>'; } ?></li>
				<?php
				}
				?></ul>
				</div>

			</div>
			<?php
			$maps_array = array(
					'arranhaceu'=> 'Arranha Céu',
					'aviao'=> 'Avião Presidencial',
					'banco'=> 'Banco',
					'canal'=> 'Canal',
					'chale'=> 'Chalé',
					'clubhouse'=> 'Casa de Campo',
					'consulado'=> 'Consulado',
					'favela'=> 'Favela',
					'fronteira'=> 'Fronteira',
					'hereford'=> 'Base Hereford',
					'iate'=> 'Iate',
					'kafe'=> 'Kafe Dostoyevsky',
					'litoral'=> 'Litoral',
					'oregon'=> 'Oregon',
					'residencia'=> 'Residência',
					'park'=> 'Parque Temático',
					'bartlett'=> 'U. Bartlett',
					'villa'=> 'Villa'
					);
			?>
			<div id="chat_map">
					<div id="map">
						<?php 
							if($mapa == ""){
						?>
						<div id="map_img"></div>
						<p>Aguardando a escolha do mapa.</p>
						<?php
							}else{ 
						?>
						<div style="background-image: url(img/maps/<?php echo $mapa; ?>.jpg); display:block;" id="map_img"></div>
						<p style="color:#e1e1e1;"><?php echo "Mapa: ".$maps_array[$mapa]; ?></p>
						<?php
							}
						?>
						
					</div>
					<div id="chat">
						<div id="chat_box">
							<div class="msg msg_atencao">Divirta-se! Qualquer problema, contate nosso suporte online.</div>
							<?php
							if($mapa == ""){
							?>
							<div class="msg msg_atencao"><b>Vote no mapa da partida logo abaixo</b>.</div>
							<?php
							}
							?>
						</div>
						<form autocomplete="off" class="form_chat">
						<input class="time_user" type="hidden" name="time" value="<?php echo (isset($time) == true) ? $time : 'laranja'; ?>"/>
						<input class="nick_user" type="hidden" name="nick_user" value="<?php echo $nick; ?>"/>
						<input class="lobbyid" type="hidden" name="lobby" value="<?php echo $id_lobby; ?>"/>
						<input maxlength="150" class="envia_chat" id="envia_chat_id" type="text" placeholder="Chat..." />	
						</form>
					</div>
					<?php
					if($capitao_azul == $id or $capitao_laranja == $id){
					?>
					<div id="button_finaliza"><button class="button_finaliza">FINALIZAR PARTIDA <i class="fa fa-check"></i></button></div>
					<?php
					}
					?>
					<div id="choosemap"></div>
					<div id="button_report"><button class="button_report">DENÚNCIAR LOBBY <i class="far fa-flag"></i></button></div>
			</div>
			
			<div id="time_laranja">
				<div id="head_time_laranja">
				<h2>EQUIPE <span>LARANJA</span></h2>
				</div>	
				
				<div id="players_time_laranja">
				<ul>
				<?php
				$busca_capitao_laranja = mysqli_query($conexao, "SELECT * FROM users WHERE id = '$capitao_laranja'");
				$dados_capitao_laranja = mysqli_fetch_array($busca_capitao_laranja);
				?>
				<li><a target="_blank" href="/profile/<?php echo $dados_capitao_laranja['id']; ?>"><?php echo $dados_capitao_laranja['nick']; ?></a><?php if($dados_capitao_laranja['premium'] == 1){echo '<i title="Premium" class="fas fa-fire premium"></i>';} ?><?php if($dados_capitao_laranja['verificado']== 1){echo '<i title="Verificado" class="fas fa-check verificado"></i>';} ?><?php if($dados_capitao_laranja['nick'] == $nick){ $time = 'laranja'; echo '<span id="you">VOCÊ</span>';}?> <span class="capitao">CAPITÃO</span></li>
				<?php
				$busca_user_laranja = mysqli_query($conexao, "SELECT * FROM users WHERE id IN ($time_laranja) and id != '$capitao_laranja' LIMIT 4");
				while($dados_laranja = mysqli_fetch_array($busca_user_laranja)){
					$nick_laranja = $dados_laranja['nick'];
					$verificado_laranja = $dados_laranja['verificado'];
					$premium_laranja = $dados_laranja['premium'];
				?>
				<li><a target="_blank" href="/profile/<?php echo $dados_laranja['id']; ?>"><?php echo $nick_laranja; ?></a><?php if($premium_laranja == 1){echo '<i title="Premium" class="fas fa-fire premium"></i>';} ?><?php if($verificado_laranja == 1){echo '<i title="Verificado" class="fas fa-check verificado"></i>';} ?><?php if($nick_laranja == $nick){ $time = 'laranja'; echo '<span id="you">VOCÊ</span>';}?> <?php if($dados_laranja['id'] == $capitao_laranja){echo '<span class="capitao">CAPITÃO</span>'; } ?></li>
				<?php
				}
				?></ul>
				</div>

			</div>
		</div>
	
	<?php
	if($mapa == ""){
	?>

	<div id="map_choice">
		<h2>VOTE NO MAPA <small>QUE DESEJA JOGAR</small><span class="count_map"></span><span>*caso você não escolha um mapa durante o tempo definido, um voto aleatório será computado.</span></h2>

	<?php
	if(mysqli_num_rows($busca_votos) == 0){
	?>
		<div id="maps">
			<div data-name="Arranha Céu" data-map="arranhaceu" class="maps_fig arranha-ceu"><h3>Arranha Céu</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="Avião Presidencial" data-map="aviao" class="maps_fig aviao"><h3>Avião Presidencial</h3></div>
			<?php
			}
			?>
			<div data-name="Banco" data-map="banco" class="maps_fig banco"><h3>Banco</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="Canal" data-map="canal" class="maps_fig canal"><h3>Canal</h3></div>
			<?php
			}
			?>
			<div data-name="Chalé" data-map="chale" class="maps_fig chale"><h3>Chalé</h3></div>
			<div data-name="Casa de Campo" data-map="clubhouse" class="maps_fig club-house"><h3>Casa de Campo</h3></div>
			<div data-name="Consulado" data-map="consulado" class="maps_fig consulado"><h3>Consulado</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="Favela" data-map="favela" class="maps_fig favela"><h3>Favela</h3></div>
			<?php
			}
			?>
			<div data-name="Fronteira" data-map="fronteira" class="maps_fig fronteira"><h3>Fronteira</h3></div>
			<div data-name="Base Hereford" data-map="hereford" class="maps_fig hereford"><h3>Base Hereford</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="Iate" data-map="iate" class="maps_fig iate"><h3>Iate</h3></div>
			<?php
			}
			?>
			<div data-name="Kafe Dostoyevsky" data-map="kafe" class="maps_fig kafe"><h3>Kafe Dostoyevsky</h3></div>
			<div data-name="Litoral" data-map="litoral" class="maps_fig litoral"><h3>Litoral</h3></div>
			<div data-name="Oregon" data-map="oregon" class="maps_fig oregon"><h3>Oregon</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="Residência" data-map="residencia" class="maps_fig residencia"><h3>Residência</h3></div>
			<?php
			}
			?>
			<div data-name="Parque Temático" data-map="park" class="maps_fig park"><h3>Parque Temático</h3></div>
			<?php
			if($type != 'rankedopen'){
			?>
			<div data-name="U. Bartlett" data-map="bartlett" class="maps_fig bartlett"><h3>U. Bartlett</h3></div>
			<?php
			}
			?>
			<div data-name="Villa" data-map="villa" class="maps_fig villa"><h3>Villa</h3></div>
		</div>
	<?php
	}
	?>
	</div>
	<?php
	}
	?>

	<div id="modal_report">
			<div id="modal_report_content">
			<form method="post" class="frm_report">
			<label>CONTE-NOS O QUE ACONTECEU:</label>
			<textarea required="required" minlength="5" maxlength="300" name="motivo" placeholder="Descreva o ocorrido no lobby ou in-game. Denúncias de jogador não devem ser feitas neste canal, somente no perfil do usuário."></textarea>
			<input type="hidden" name="id_lobby" value="<?php echo $id_lobby; ?>" />
			<input type="submit" name="envia_report" class="envia_report" value="REPORTAR LOBBY" />
			</form>
			</div>
	</div>

	<div id="modal_finaliza">
		<div id="modal_finaliza_content">
			<div id="modal_times">
				<div id="modal_time_azul">
					<h1>EQUIPE <span>AZUL</span></h1>
					<form>
						<input class="numb" maxlength="1" type="text" name="result_azul" />
					</form>
				</div>
				<div id="modal_time_laranja">
					<h1>EQUIPE <span>LARANJA</span></h1>
					<form>
						<input class="numb" maxlength="1" type="text" name="result_laranja" />
					</form>
				</div>
			</div>
			<p style="color:#ddd; margin:10px 0 0 0 ; text-align: center;">SOMENTE CLIQUE NO BOTÃO ABAIXO CASO TENHA CERTEZA DO RESULTADO.</p>
			<div style="width:100%; text-align: center;">
			<button name="enviar_result" class="button_finaliza_submit">FINALIZAR <i class="fa fa-check"></i></button>
			</div>
		</div>
	</div>

	<div id="modal_success"></div>
	<div id="modal_error"></div>
	<div id="modal_map"></div>

	
	<?php include('foot.php'); ?>
	<?php
		$sec = date('Y/m/d H:i:s', strtotime('+50 seconds', strtotime($tempo_atual))); 
	 ?>
	</div>

	<?php
	if($mapa == ''){
	?>
<script type="text/javascript">
$(document).ready(function(){
				var ScrollChat = function(){
					$('#chat_box').scrollTop($('#chat_box').prop("scrollHeight"));
				}

				var maps = {
					arranhaceu: 'Arranha Céu',
					aviao: 'Avião Presidencial',
					banco: 'Banco',
					canal: 'Canal',
					chale: 'Chalé',
					clubhouse: 'Casa de Campo',
					consulado: 'Consulado',
					favela: 'Favela',
					fronteira: 'Fronteira',
					hereford: 'Base Hereford',
					iate: 'Iate',
					kafe: 'Kafe Dostoyevsky',
					litoral: 'Litoral',
					oregon: 'Oregon',
					residencia: 'Residência',
					park: 'Parque Temático',
					torre: 'Torre',
					bartlett: 'U. Bartlett',
					villa: 'Villa'
							};

				$('.count_map').countdown('<?php echo $sec; ?>')
					.on('update.countdown', function(event) {
  						$(this).html(event.strftime('Termina em <b style="color:#5b97f2;">%S</b> segundos.'));
  					})
  					.on('finish.countdown', function(event) {
  						$('.count_map').text('Finalizando votação...');
							$.ajax({
								url: 'map_vote.php',
								type: 'POST',
								dataType: 'JSON',
								data: 'finaliza_votacao=1&lobby=<?php echo $id_lobby; ?>',
								success: function(data){
									console.log(data);
									if(data['status'] === 'success'){
										$('#map_choice').fadeOut();
										$('#map_img').fadeIn('slow').css('background-image','url(img/maps/' + data['map'] + '.jpg');
										$('#map p').css('color','#e1e1e1');
										$('#map p').text('Mapa: ' + maps[data['map']]).fadeIn('slow');
										$('#chat_box').append('<div class="msg msg_sucesso">Mapa da partida: <b>'+ maps[data['map']] +'</b></div>');
										$('#chat_box').append('<div class="msg msg_sucesso">Ao finalizar a partida, o capitão de cada time deve clicar no botão <b>FINALIZAR PARTIDA</b> abaixo desta mensagem.</div>');
										ScrollChat();
										
									}
									if(data['status'] === 'error'){
										$('.count_map').text('Erro ao finalizar. Tentando novamente.');
									}
								},
								error: function(){
									alert('ERRO: Falha ao finalizar a votação de mapas. Atualize a página.');
								}
							});
  					});

				function trim(str) {
					return str.replace(/^\s+|\s+$/g,"");
				}


				
});
</script>

<?php
	}
?>
<script type="text/javascript" src="js/chat.js?v=1.0.0"></script>
</body>
</html>
<?php
	}
}else{
	header("Location: apresentation");
}
?>