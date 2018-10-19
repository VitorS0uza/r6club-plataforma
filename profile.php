<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_GET['profile']) and is_numeric($_GET['profile']) == true){
	require('connection.php');
	$id_profile = $_GET['profile'];
	$id = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$dados_user_logged = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user_logged['nick'];
	$img_perfil = $dados_user_logged['img_perfil'];

	$busca_dados_user_profile = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id_profile'");

		if(mysqli_num_rows($busca_dados_user_profile) == 1){

			$dados_user = mysqli_fetch_array($busca_dados_user_profile);
			//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
			$nome_profile = $dados_user['nome'];
			$nick_profile = $dados_user['nick'];
			$img_perfil_profile = $dados_user['img_perfil'];
			$email = $dados_user['email'];
			$pontos = $dados_user['pontos'];
			$xp = (int) $dados_user['xp'];
			require('levels.define.php');
			$ativado = $dados_user['ativado'];
			$vencidas = $dados_user['vencidas'];
			$perdidas = $dados_user['perdidas'];
			$mouse = $dados_user['mouse'];
			$teclado = $dados_user['teclado'];
			$monitor = $dados_user['monitor'];
			$headset = $dados_user['headset'];
			$idade = $dados_user['idade'];
			$sensi_horizontal = $dados_user['sensi_horizontal'];
			$sensi_vertical = $dados_user['sensi_vertical'];
			$sensi_ads = $dados_user['sensi_ads'];
			$dpi_mouse = $dados_user['dpi_mouse'];
			$verificado = $dados_user['verificado'];
			$premium = $dados_user['premium'];
			$mostrar_email = $dados_user['mostrar_email'];
			//VERIFICA SE USUÁRIO NÃO ESTÁ BUSCANDO PARTIDA
			$busca_searching = mysqli_query($conexao, "SELECT id_user, ativo FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0'");
				if(mysqli_num_rows($busca_searching) == 1){
					header("Location: /buscando");
					echo "<script type='text/javascript'>window.location.href='/buscando';</script>";
					exit();
				}

	//VERIFICA NÍVEL E DEFINE COR .BADGE
	if($nivel == 0){
		$badge = array('#b7b7b7', '#6c6c6c');
	}elseif($nivel > 0 and $nivel <= 30){
		$badge = array('#6c9cbb', '#2F556E');
	}elseif($nivel > 30 and $nivel <= 60){
		$badge = array('#6CADBB', '#367380');
	}elseif($nivel > 60){
		$badge = array('#c45959', '#6e2f2f');
	}
			
	
	//VERIFICA PATENTE E DEFINE IMAGEM
	if($patente == 0){
		$def_patente = array('Sem patente','/img/patente/no-patente.png');
	}elseif($patente == 1){
		$def_patente = array('Prata 3','/img/patente/prata_3.png');
	}elseif($patente == 2){
		$def_patente = array('Prata 2','/img/patente/prata_2.png');
	}elseif($patente == 3){
		$def_patente = array('Prata 1','/img/patente/prata_1.png');
	}elseif($patente == 4){
		$def_patente = array('Ouro 3','/img/patente/ouro_3.png');
	}elseif($patente == 5){
		$def_patente = array('Ouro 2','/img/patente/ouro_2.png');
	}elseif($patente == 6){
		$def_patente = array('Ouro 1','/img/patente/ouro_1.png');
	}elseif($patente == 7){
		$def_patente = array('Platina 3','/img/patente/platina_3.png');
	}elseif($patente == 8){
		$def_patente = array('Platina 2','/img/patente/platina_2.png');
	}elseif($patente == 9){
		$def_patente = array('Platina 1','/img/patente/platina_1.png');
	}elseif($patente == 10){
		$def_patente = array('Diamante','/img/patente/diamante.png');
	}elseif($patente == 11){
		$def_patente = array('Challenger','/img/patente/challenger.png');
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
<title>Jogador: <?php echo $nick_profile; ?> - Rainbow 6: Club</title>
<?php include("meta.php"); ?>
<link rel="icon" href="/favicon.ico"/>
<link rel="stylesheet" href="/css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="/css/profile.css?v=1.0.0"/>
<link rel="stylesheet" href="/css/logged_global.css?v=1.0.0"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="/css/iziModal.min.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/iziModal.min.js"></script>
<script type="text/javascript" src="/js/profile.js?v=1.0.0"></script>
<script type="text/javascript" src="/js/countUp.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>

</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>
		
		<div id="profile_head">
			<div id="profile_transition"></div>
			<?php
			if($img_perfil_profile === ""){
				$url_img = "/uploads/default/default-user.jpg";
			}else{
				$url_img = $img_perfil_profile;
			}
			?>
			<div id="img_profile" style="background-image:url(<?php echo $url_img; ?>); background-size:cover; background-position: center;">
				<?php if($id === $id_profile) { ?><div id="img_config"><form class="frm_trocar_foto"><button class="trocar_foto" type="submit"><i style="margin-right:5px; margin-left:10px;" class="fas fa-camera"></i> Mudar sua foto</button></form></div><?php } ?>
			</div>
			<div id="nick_profile"><h1><?php echo $nick_profile; ?> <?php if($premium == 1){ ?><i title="Premium" class="fas fa-fire premium"></i><?php } ?> <?php if($verificado == 1){ ?><i title="Verificado" class="fas fa-check verificado"></i><?php } ?><small><?php if($ativado == 2){echo "BANIDO - ";}?>ID: <?php echo $id_profile; ?> </small></h1></div>
			<div id="action_profile">Denunciar</div>
		</div>
		
		<div id="stats">
			<div id="patente"><h2>PATENTE:</h2><span style="width:50px; height: 50px;"><img title="<?php echo $def_patente[0]; ?>" style="width:50px; height:50px;" src="<?php echo $def_patente[1]; ?>"/></span></div>
			<div id="nivel"><h2>NÍVEL:</h2><span style="background-color: <?php echo $badge[0]; ?>; border:3px solid <?php echo $badge[1];?>;" title="<?php echo $xp; ?> XP" class="badge"><span id='nivel_animate'>0</span></span></div>
			<div id="pontos"><h2>PONTOS:</h2> <span><span id='pontos_animate'>0</span> PONTOS</span></div>
		</div>

		<div id="dados_profile">
			<ul>
			<li class="table_inicial">GERAL <i class="fas fa-bars"></i></li>
			<li class="table_perifericos">PERIFÉRICOS / IN-GAME <i class="fas fa-gamepad"></i></li>
			<li class="table_partidas">PARTIDAS <i class="fas fa-trophy"></i></li>
			<?php if($id == $id_profile){ ?><li class="table_desativar">DESATIVAR CONTA <i class="fas fa-power-off"></i></li><?php } ?>
			</ul>
			
			<div id="table_geral">
				<div id="table_geral__geral">
					<?php 
					if($id == $id_profile){

					?>
					<form method="post" class="update_geral" action="">
						<div id="form-coluna1">
						<label><i class="fas fa-user"></i> Nome:</label>
						<input type="text" value="<?php echo $nome_profile; ?>" placeholder="Primeiro nome" maxlength="20" name="nome"/>

						<label><i class="fas fa-at"></i> E-mail:</label>
						<input type="email" value="<?php echo $email; ?>" name="email"/>
						<label><i class="fas fa-info-circle"></i> Informações:</label>
						<p style="font-size:14px;">Criado em: <?php echo date("d/m/y", strtotime($dados_user['data_cadastro'])); ?></p>
						<?php
						if($premium == 1){
							$busca_premium = mysqli_query($conexao, "SELECT * FROM users_premium WHERE id_user = '$id_profile' and finalizado = '0'");
							if(mysqli_num_rows($busca_premium) > 0){
								$dados_premium = mysqli_fetch_array($busca_premium);
						?>
						<p style="font-size:14px;">
							<span style="color:#ff9914; font-weight: 600;">PREMIUM</span> até: <?php echo date("d/m/y H:i:s", strtotime($dados_premium['acaba_em'])); ?>
						</p>
						<?php
							}
						}
						?>
						<button class="changepass" name="change_pass" type="button">ALTERAR SENHA</button>
						<button class="privacidade" name="privacidade" type="button">CONFIG. DE PRIVACIDADE</button>
							<div class="config_privacidade priv_display">
								<label>
								<input type="checkbox" name="mostrar_email" <?php if($mostrar_email == '1') { echo "checked";} ?>/>Mostrar seu e-mail para todos
								</label>
							</div>
						</div>
						<div id="form-coluna2">
						<label><i class="fas fa-gamepad"></i> Nick Uplay:</label>
						<input type="text" value="<?php echo $nick_profile; ?>" placeholder="Evite erros no nick." name="nick"/>
							
						<label><i class="fas fa-birthday-cake"></i> Idade:</label>
						<input type="number" value="<?php echo $idade; ?>" name="idade"/>
						
						<input type="hidden" name="atualizar_geral" />
						<button name="atualizar_geral" type="submit">ATUALIZAR <i class="fas fa-check"></i></button>
						</div>	
					</form>
					<?php
					}else{
					?>
					<div id="form-coluna1">
						<h4><i class="fas fa-user"></i> Nome:</h4>
						<p><?php echo $nome_profile; ?></p>
						<h4><i class="fas fa-gamepad"></i> Nick UPLAY:</h4>
						<p><?php echo $nick_profile; ?></p>
					</div>

					<div id="form-coluna2">
						<h4><i class="fas fa-at"></i> E-mail:</h4>
						<?php
						if($mostrar_email == '1'){
						?>
						<p><?php echo $email; ?></p>
						<?php
						}else{
						?>
						<p>********************</p>
						<?php
						}
						?>
						<h4><i class="fas fa-birthday-cake"></i> Idade:</h4>
						<p><?php echo $idade; ?></p>
					</div>
					<?php
					}
					?>
				</div>
					
				<div id="table_geral__perifericos">
					<?php 
					if($id == $id_profile){
					?>
					<form method="post" class="update_perifericos" action="">
						<div id="form-coluna1">
						<label><i class="fas fa-mouse-pointer"></i> Mouse:</label>
						<input type="text" value="<?php echo $mouse; ?>" placeholder="Mouse que você utiliza" name="mouse"/>

						<label><i class="far fa-keyboard"></i> Teclado:</label>
						<input type="text" value="<?php echo $teclado; ?>" placeholder="Teclado que você utiliza" name="teclado"/>	

						<label><i class="fas fa-desktop"></i> Monitor:</label>
						<input type="text" value="<?php echo $monitor; ?>" placeholder="Monitor que você utiliza" name="monitor"/>

						<label><i class="fas fa-headphones"></i> Headset:</label>
						<input type="text" value="<?php echo $headset; ?>" placeholder="Headset que você utiliza" name="headset"/>
						</div>

						<div id="form-coluna2">
						<label>Sensibilidade horizontal do mouse (no jogo):</label>
						<input type="number" value="<?php echo $sensi_horizontal; ?>" placeholder="Sua Sensibilidade Horizontal no jogo" min="1" max="100" name="sensi_horizontal"/>		
						<label>Sensibilidade vertical do mouse (no jogo):</label>
						<input type="number" value="<?php echo $sensi_vertical; ?>" placeholder="Sua Sensibilidade Vertical no jogo" min="1" max="100" name="sensi_vertical"/>
						
						<label>Atirar com Mira - ADS (no jogo):</label>
						<input type="number" value="<?php echo $sensi_ads; ?>" placeholder="Sua Sensibilidade ADS no jogo" min="1" max="100" name="sensi_ads"/>

						<label>Mouse DPI (no jogo):</label>
						<input type="number" value="<?php echo $dpi_mouse; ?>" placeholder="Seu Mouse DPI no jogo" min="1" max="15000" name="dpi_mouse"/>
						
						<input type="hidden" name="atualizar_perifericos" />
						<button name="atualizar_perifericos" type="submit">ATUALIZAR <i class="fas fa-check"></i></button>
						</div>
					</form>
				<?php }else{ ?>
					<div id="form-coluna1">
						<h4><i class="fas fa-mouse-pointer"></i> Mouse:</h4>
						<p><?php echo $mouse; ?></p>
						<h4><i class="far fa-keyboard"></i> Teclado:</h4>
						<p><?php echo $teclado; ?></p> 
						<h4><i class="fas fa-desktop"></i> Monitor:</h4>
						<p><?php echo $monitor; ?></p>
						<h4><i class="fas fa-headphones"></i> Headset:</h4>
						<p><?php echo $headset; ?></p>
					</div>

					<div id="form-coluna2">
						<h4>Sensibilidade horizontal do mouse (no jogo):</h4>
						<p><?php echo $sensi_horizontal; ?></p>
						<h4>Sensibilidade vertical do mouse (no jogo):</h4>
						<p><?php echo $sensi_vertical; ?></p>
						<h4>Atirar com Mira - ADS (no jogo):</h4>
						<p><?php echo $sensi_ads; ?></p>
						<h4>Mouse DPI (no jogo):</h4>
						<p><?php echo $dpi_mouse; ?></p>
					</div>
				<?php } ?>
				</div>
				
				<div data-id="<?php echo $id_profile; ?>" data-partidas="<?php echo $vencidas + $perdidas; ?>" id="table_geral__partidas">
					<img class="loader_map" src="/img/loader.gif" width="40" height="40" />

					<table id="partidas">
						<p style="margin-bottom: 15px;">Apenas as últimas 50 partidas finalizadas são mostradas.</p>
						<tr class="head_table">
							<th style="width:160px;">Mapa</th>
							<th>Resultado</th>
							<th>Gamemode</th>
							<th>Ínicio</th>
							<th>Duração</th>
						</tr>
					</table>
				</div>

				<?php 
					if($id == $id_profile){
					?>
				<div id="table_geral__desativar">
					
				<form method="post" action="/desativate_account.php">
						<label>*NÃO HÁ COMO REVERTER ESTE PROCESSO CASO CLIQUE NO BOTÃO ABAIXO:</label>

						<button class="desativar_btn" type="submit">DESATIVAR CONTA <i class="fas fa-power-off"></i></button>
				</form>
				</div>
					<?php } ?><div style="clear:both;"></div>
			</div>
		
		</div>
		
		<div id="modal_error">
		</div>
		<div id="modal_success">
		</div>
		<div id="modal_denuncia">
			<div id="modal_denuncia_content">
			<form method="post" class="frm_denuncia">
			<label>SELECIONE O MOTIVO:</label>
			<select name="motivo">
				<option value="cheat/hack">Utilização de cheat/hack.</option>
				<option value="bugs">Abuso de bugs in-game.</option>
				<option value="ragequit">Não jogou a partida.</option>
				<option value="comportamento">Comportamento inadequado no chat de texto ou voz.</option>
				<option value="dados_falsos">Utilização de dados falsos.</option>
				<option value="antiesportivo">Atitude antiesportiva.</option>
				<option value="outros">Outros.</option>
			</select>
			<label>PROVAS/DESCRIÇÃO: (OPCIONAL)</label>
			<textarea name="provas" maxlength="500" placeholder="insira URL's de vídeos e imagens separadas por vírgula ou uma descrição do ocorrido."></textarea>
			<p style="font-size:10px; color:#999; margin:0;">A PUNIÇÃO TEM MAIS CHANCES DE OCORRER CASO VOCÊ ENVIE PROVAS JUNTO A SUA DENÚNCIA.</p>
			<input type="hidden" name="id_denunciado" value="<?php echo $id_profile; ?>" />
			<input type="submit" name="envia_denuncia" class="envia_denuncia" value="ENVIAR DENÚNCIA" />
			</form>
			</div>
		</div>
		<div id="modal_photo">
			<div id="modal_photo_content">
				<p data-type="01">Selecione uma das imagens abaixo:</p>
				<div id="imgs_pre">
					<img class="img_pre" data-name="Ash"  src="/uploads/default/ash_.jpg" />
					<img class="img_pre" data-name="Thermite" src="/uploads/default/thermite_.jpg" />
					<img class="img_pre" data-name="Bandit"src="/uploads/default/bandit_.jpg" />
					<img class="img_pre" data-name="Jager" src="/uploads/default/jager_.jpg" />
				</div>
				<p class="photo_p">Ou envie sua imagem: (dimensão: 180x180)</p>
				<form class="photo_change" method="post" enctype="multipart/form-data">
					<input class="arquivo" accept=".jpg,.png,.jpeg" name="img" type="file" />
					<input type="submit" class="img_envia" name="envia_img" value="SELECIONAR IMAGEM" />
					<img style="display: none; width:22px; height: 22px; margin-left:10px;" src="/img/loader.gif" />
				</form>
			</div>
		</div>
		
		
		<?php include('gamemode_modal.php'); ?>
		
		

	
	<?php include('foot.php'); ?>
	</div>
	<script type="text/javascript">
	var options = {
		useEasing: true, 
		useGrouping: true,
		separator: ',', 
		decimal: '.', 
		};
		var nivelAnimate = new CountUp('nivel_animate', 0, <?php echo $nivel; ?>, 0, 3, options);
		if (!nivelAnimate.error) {
		nivelAnimate.start();
		} else {
		console.error(nivelAnimate.error);
		}
		var pontosAnimate = new CountUp('pontos_animate', 0, <?php echo $pontos; ?>, 0, 3, options);
		if (!pontosAnimate.error) {
		pontosAnimate.start();
		} else {
		console.error(pontosAnimate.error);
		}
	</script>
</body>
</html>
<?php
	}else{
		header("Location: /index?invalid");
	}
}else{
	header("Location: /apresentation");
}
?>