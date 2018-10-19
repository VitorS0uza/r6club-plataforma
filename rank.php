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
<title>Placar de Líderes | Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="css/rank.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<noscript>Precisamos de JavaScript para funcionar.</noscript>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="rank">
			<?php
			$busca_temporada = mysqli_query($conexao, "SELECT temporada FROM temporada ORDER BY id DESC LIMIT 1");
			$dado_temp = mysqli_fetch_array($busca_temporada);
			$temporada = $dado_temp['temporada'];
			?>
			<h2><i style="margin-right:5px;" class="fas fa-trophy"></i> Placar de Líderes - Temporada <?php echo $temporada; ?></h2>
			<div id="rank_content">
				<?php
				$busca_users = mysqli_query($conexao, "SELECT * FROM users ORDER BY pontos DESC, vencidas DESC LIMIT 50");
				if(mysqli_num_rows($busca_users) /*==50*/>1){
				?>
				<table id="leaderboard">
					<tr class="header">
						<th>Posição</th>
						<th>Jogador</th>
						<th>Nível</th>
						<th>Partidas</th>
						<th>Vencidas</th>
						<th>Vitórias/Derrotas</th>
						<th>Pontos</th>
					</tr>
					<tbody>
					<?php
					$num = 1;
					while($dados = mysqli_fetch_array($busca_users)){

						if($dados['perdidas'] != 0 and $dados['vencidas'] != 0){
						$VD = number_format($dados['vencidas']/$dados['perdidas'], 2);
						}elseif($dados['perdidas'] == 0 and $dados['vencidas'] != 0){
							$VD = number_format($dados['vencidas']/1, 2);
						}elseif($dados['perdidas'] != 0 and $dados['vencidas'] == 0){
							$VD = number_format(1/$dados['perdidas'], 2);
						}elseif($dados['perdidas'] == 0 and $dados['vencidas'] == 0){
							$VD = 'N/D';
						}
						$xp = $dados['xp'];
						$pontos = $dados['pontos'];
						require("levels.define.php");
					?>
					<tr>
						<td><?php echo $num++; ?>º</td>
						<td><a target="_blank" href="/profile/<?php echo $dados['id']; ?>"><?php echo $dados['nick']; if($dados['verificado'] == 1){echo '<i title="Verificado" class="fas fa-check verificado"></i>';} if($dados['premium'] == 1){echo '<i title="Premium" class="fas fa-fire premium"></i>';}?></a></td>
						<td><?php echo $nivel; ?></td>
						<td><?php echo $dados['vencidas'] + $dados['perdidas']; ?></td>
						<td><?php echo $dados['vencidas']; ?></td>
						<td><?php echo $VD; ?></td>
						<td><?php echo number_format($dados['pontos']); ?></td>
					</tr>
					<?php
					}
					?>
					</tbody>
				</table>
				<?php
				}else{
					echo "<p style='color:#ddd; padding:20px;'>Não há dados suficientes para mostrar os líderes.</p>";
				}
				?>
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