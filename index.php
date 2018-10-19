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
	$xp = $dados_user['xp'];
	$pontos = $dados_user['pontos'];
	$ativado = $dados_user['ativado'];
	$premium = $dados_user['premium'];
	require('levels.define.php');
	//VERIFICA SE USUÁRIO NÃO ESTÁ BUSCANDO PARTIDA
	if($ativado == 2){
		unset($_SESSION['login_id']);
		setcookie('login');
		setcookie('pass');
		header("Location: apresentation");
	}
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


	//BUSCA NOTICIAS
	$busca_news = mysqli_query($conexao, "SELECT id, title FROM news ORDER BY id DESC LIMIT 6");

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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Rainbow 6: Club - By Players. For Players.</title>
<?php include("meta.php"); ?>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css?v=1.0.0"/>
<link rel="stylesheet" href="css/logged_global.css?v=1.0.0"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/rhinoslider-1.05.css"/>
<link rel="stylesheet" href="css/iziModal.min.css"/>
<link rel="stylesheet" href="css/owl.carousel.min.css"/>
<link rel="stylesheet" href="css/owl.theme.default.min.css"/>
<link rel="stylesheet" href="css/animate.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/rhinoslider-1.05.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<script type="text/javascript" src="js/document.js?500"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/countUp.js"></script>
<noscript><?php echo $noscript; ?></noscript>
<style type="text/css">
	#slide_principal {
		width:960px;
		margin:10px auto;
	}

	#slide_principal div {
		width:960px;
	}
</style>
<?php
if(isset($_GET['cancel'])){
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_cancel').iziModal('open');
	});

</script>
<?php	
}
?>
<?php
if(isset($_GET['cancellobby'])){
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_cancel').iziModal('setTitle', '<?php echo $partida_cancelada; ?>');
		$('#modal_cancel').iziModal('open');
	});

</script>
<?php	
}
?>
<?php
if(isset($_GET['errormatch'])){
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_error').iziModal('open');
	});

</script>
<?php	
}
?>
<?php
	if(!isset($_COOKIE['tutorial_see'])){
		setcookie('tutorial_see',1,time()+4320000);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_tutorial').iziModal('open');
	});

</script>
<?php
	}
?>
</head>

<body>
	<div id="modal_error"></div>
	<div id="modal_cancel"></div>
	<div style="background-color:#0F1319; display: none;" id="modal_tutorial">
		<iframe id="video_tutorial" width="560" height="315" src="https://www.youtube.com/embed/L60YosOCwas?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	</div>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>
		<div id="id_profile"><h1><?php echo $bemvindo; ?> <?php echo $nick;?> <small><?php if($premium == '1'){echo "PREMIUM - ";}?>ID: <?php echo $id; ?></small><i class="fas fa-user-circle config"></i></h1>
		</div>


		<div id="slide_principal" class="owl-carousel owl-theme">
			<?php
			$busca_slides = mysqli_query($conexao, "SELECT * FROM slide ORDER BY id DESC");
			if(mysqli_num_rows($busca_slides) == 0){
			?>
 			<div><a href="#"><img src="img/slider/01.png" alt="SEJA BEM VINDO" title="SEJA BEM VINDO"/></a></div>
			<?php
			}else{
				while($dados_slide = mysqli_fetch_array($busca_slides)){
			?>
			<div><a href="<?php echo $dados_slide['link']; ?>"><img src="<?php echo $dados_slide['img_url']; ?>" alt="<?php echo $dados_slide['title']; ?>" title="<?php echo $dados_slide['title']; ?>"/></a></div>
			<?php
				}
			}
			?>
		  
		</div>

	
		
		<div id="stats">
			<div id="patente"><h2><?php echo $lang_patente; ?>:</h2> <span style="width:50px; height: 50px;"><img title="<?php echo $def_patente[0]; ?>" style="width:50px; height:50px;" src="<?php echo $def_patente[1]; ?>"/></span></div>
			<div id="nivel"><h2><?php echo $lang_nivel; ?>:</h2><span title="<?php echo $xp; ?> XP" style="background-color: <?php echo $badge[0]; ?>; border:3px solid <?php echo $badge[1];?>;" class="badge"><span id='nivel_animate'>0</span></span></div>
			<div id="pontos"><h2><?php echo $lang_pontos; ?>:</h2> <span><span id='pontos_animate'>0</span> <?php echo $lang_pontos; ?></span></div>
		</div>

		<div id="container_two">	
			<div id="noticias">
			<h2><i class="far fa-newspaper"></i> <?php echo $lang_news; ?></h2>
				<?php 
					if(mysqli_num_rows($busca_news) == 0){
							echo "<a href='#'>".$nonews."</a>";
					}else{
						while($noticia = mysqli_fetch_array($busca_news)){
				?>
				<a href="news/<?php echo $noticia['id']; ?>"><?php echo $noticia['title']; ?><i class="fas fa-angle-right"></i></a>
				<?php
					}
				?>
				<a href="/news/all"><?php echo $vermais; ?> <i class="fas fa-caret-down seta_more"></i></a>
				<?php
					}
				?>
			</div>
			<div id="season">
				<?php
			$busca_temporada = mysqli_query($conexao, "SELECT temporada, final FROM temporada ORDER BY id DESC LIMIT 1");
			$dado_temp = mysqli_fetch_array($busca_temporada);
			$temporada = $dado_temp['temporada'];
			$final = date_create($dado_temp['final']);
			$agora = date_create(date("Y-m-d H:i:s"));
			$resultado = date_diff($final, $agora);
				?>
				<h2><i class="fas fa-trophy"></i> <?php echo $lang_temp; ?> <?php echo $temporada;?></h2>
				<div>
					<p style="font-size:17px;"><?php echo $terminaem; ?></p>
					<p class="termina"><i class="far fa-clock"></i> <?php echo $resultado->d.'d '.$resultado->h.'h '.$resultado->i.'min'; ?></p>
				</div>
			</div>
		</div>
		<?php include('gamemode_modal.php'); ?>
<?php
if(isset($_GET['errormatch'])){
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modal_gamemode').iziModal('open');
	});

</script>
<?php	
}
?>

	
	<?php include('foot.php'); ?>
	</div>
	<script type="text/javascript">
	var options = {
		useEasing: true, 
		useGrouping: true,
		separator: ',', 
		decimal: '.', 
		};
		var nivelAnimate = new CountUp('nivel_animate', 0, <?php echo $nivel; ?>, 0, 8, options);
		if (!nivelAnimate.error) {
		nivelAnimate.start();
		} else {
		console.error(nivelAnimate.error);
		}
		var pontosAnimate = new CountUp('pontos_animate', 0, <?php echo $pontos; ?>, 0, 5, options);
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
	header("Location: /apresentation");
}
?>