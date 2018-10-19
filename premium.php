<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
	$id_user = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id_user'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$img_perfil = $dados_user['img_perfil'];
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
<title>Seja Premium | Rainbow 6: Club - By Players. For Players.</title>
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
#plans {
	width:660px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#plans h2 {
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

#plans_content {
	width:100%;
	padding:25px;
	box-sizing: border-box;
}

#plans_content h3 {
	margin:0;
	font-size:16px;
	color:#ddd;
}

.beneficios {
	list-style:none;
	margin:18px 0 5px 10px;
	padding:0;
}

.beneficios li i {
	color:#2eb82e;
	margin-right:5px;
}

.beneficios li {
	margin-bottom:15px;
	color:#fff;
}

#plan_premium {
	width:80%;
	margin:40px auto 20px auto;
	display:flex;
	flex-direction: row;
	justify-content: space-around;
	align-items: center;
}

#mensal {
	width:180px;
	height:180px;
	background-color:#1e2732;
	border:1px solid #283443;
	padding:10px;
	box-sizing: border-box;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	cursor: default;
}

#bimestral {
	width:180px;
	height:180px;
	background-color:#1e2732;
	border:1px solid #e98b10;
	padding:10px;
	box-sizing: border-box;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	cursor: default;
	position:relative;
}

#plan_premium h3 {
	color:#FFF;
	font-family: 'Open Sans';
	font-weight:400;
	font-size:20px;
	text-align: center;
}

#mensal:hover, #bimestral:hover{
	border:1px solid #e98b10;
	box-shadow: 0px 0px 35px rgba(0,0,0,0.4);
}

.bombando {
	background-color:#e98b10;
	border-radius: 0px 0px 0px 200px;
	-moz-border-radius: 0px 0px 0px 200px;
	-webkit-border-radius: 0px 0px 0px 200px;
	border: 0px solid #000000;
	color:#5f3907;
	position:absolute;
	right:-1px;
	top:-1px;
	font-size:17px;
	padding-bottom:5px;
	padding-left:7px;
	padding-right:2px;
	padding-top:2px;
	box-sizing: border-box;
}

#mensal a, #bimestral a {
	width:160px;
	height: 40px;
}

#plans_content small{
	font-size:10px;
	color:#ddd;
	text-align: center;
}

#modal_1mes, #modal_2meses {
	background-color:#0F1319;
	display:none;
}

#modal_1mes form input, #modal_2meses form input{
	outline:none;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
			$("#modal_1mes").iziModal({
				width: 530,
				title: 'ESCOLHA UMA FORMA DE PAGAMENTO',
				headerColor: '#131920',
				overlayColor: 'rgba(0, 0, 0, 0.9)',
				closeButton: true,
				transitionOut: 'bounceOutDown',
				timeout: false
			});

			$("#modal_2meses").iziModal({
				width: 530,
				title: 'ESCOLHA UMA FORMA DE PAGAMENTO',
				headerColor: '#131920',
				overlayColor: 'rgba(0, 0, 0, 0.9)',
				closeButton: true,
				transitionOut: 'bounceOutDown',
				timeout: false
			});

			$(".open_1mes").click(function(){
				$("#modal_1mes").iziModal('open');
				return false;
			});

			$(".open_2meses").click(function(){
				$("#modal_2meses").iziModal('open');
				return false;
			});

	});
</script>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="modal_1mes">
			<div style="padding: 40px; display:flex; flex-direction: row; justify-content: space-around;">

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="KGUWDLRBSW6Q2">
				<input type="image" src="img/paypal_logo.png" border="0" name="submit" alt="PayPal - A maneira fácil e segura de enviar pagamentos online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
			</form>
			
			<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
			<form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
			<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
			<input type="hidden" name="code" value="2E03859BF0F08E2EE4D69F827928D460" />
			<input type="hidden" name="iot" value="button" />
			<input type="image" src="img/pagseguro_logo.png" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
			</form>
			<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
			<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

			</div>
		</div>

		<div id="modal_2meses">
			<div style="padding: 40px; display:flex; flex-direction: row; justify-content: space-around;">

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="MZNAJ28G6UE44">
			<input type="image" src="img/paypal_logo.png" border="0" name="submit" alt="PayPal - A maneira fácil e segura de enviar pagamentos online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
			</form>


			<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
			<form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
			<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
			<input type="hidden" name="code" value="CDD7D805DBDBD08004F62F8FF4DC9771" />
			<input type="hidden" name="iot" value="button" />
			<input type="image" src="img/pagseguro_logo.png" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
			</form>
			<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
			<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

			</div>
		</div>

		<div id="plans">
			<h2><i style="color:#ff9914;" class="fas fa-fire"></i> PLANO PREMIUM</h2>
			<div id="plans_content">
			<h3>Benefícios:</h3>
			<ul class="beneficios">
			<li><i class="fas fa-check-circle"></i>3500 XP (nível) no momento da ativação do plano.</li>
			<li><i class="fas fa-check-circle"></i>Ícone <i style="color:#ff9914;" class="fas fa-fire"></i>ao lado do nick.</li>
			<li><i class="fas fa-check-circle"></i>Cargo PREMIUM em nosso Discord Oficial.</li>
			<li><i class="fas fa-check-circle"></i>Suporte direto com os administradores.</li>
			</ul>
			<div id="plan_premium">
				<div id="mensal">
					<h3>Mensal</h3>
					<h3 style="font-weight:600; font-size: 22px;">R$7,00/mês</h3>
					<a class="open_1mes" href="#"><img src="https://i.imgur.com/sz6ytdb.png" /></a>

				</div>
				<div id="bimestral">
					<div class="bombando"><i class="fas fa-star"></i></div>
					<h3>Bimestral</h3>
					<h3 style="font-weight:600; font-size: 22px;">R$5,25/mês</h3>
					<a class="open_2meses" href="#"><img src="https://i.imgur.com/sz6ytdb.png" /></a>
				</div>
			</div>
			<small>*A ativação do plano acontece até 5 horas após a confirmação do pagamento. Caso queira o cargo em nosso Discord, contate-nos via e-mail ou pelo Discord. Se seu e-mail no Paypal/PagSeguro não for o mesmo da plataforma, contate-nos para efetuar a ativação.</small>
			<div style="display:block">
			<img style=" margin-top:10px;" src="img/paypal_min.png"/>
			<img style="width:70px; height: 14px; margin-top:10px; margin-left:10px;" src="img/pagseguro_logo.png"/>
		</div>
			</div>
		</div>
	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>
<?php
	}else{
		header("Location: apresentation");
	}
?>