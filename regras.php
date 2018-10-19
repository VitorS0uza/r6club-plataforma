<?php
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
<title>Regras e Condutas de criação de partidas | Rainbow 6: Club - By Players. For Players.</title>
<link rel="icon" href="favicon.ico"/>
<link rel="stylesheet" href="css/global.css"/>
<link rel="stylesheet" href="css/logged_global.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="css/iziModal.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/iziModal.min.js"></script>
<noscript><?php echo $noscript; ?></noscript>
<script type="text/javascript">
$(document).ready(function(){
	$('#jogaragora').click(function(){
		$(location).attr('href','index');
	});
});
</script>
<style type="text/css">
#regras {
	width:960px;
	margin:40px auto 0px auto;
	background-color:#131920;
}

#regras h2 {
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

#regras_content {
	width:100%;
	padding:20px;
	box-sizing: border-box;
	color:#FFF;
}

#regras_content a {
	color:#FFF;
}

h3 {
	font-size:30px;
	font-weight: 800;
}
h4 {
	font-size:25px;
	font-weight:400;
	margin-top:35px;
	margin-bottom:10px;
}

p {
	text-align: justify;
	color:#FFF;
	line-height:1.8;
	font-weight:300;
	font-size:16px;
}

.indice li {
	margin-top:5px;
	margin-bottom: 5px;
	font-weight:400;
}
.indice a {
	text-decoration: none;
}
.title {
	text-decoration: underline;
}
.configs {
	list-style:circle outside none;
	margin:5px;
	font-size:15px;
}
.configs li {
	margin:3px;
}
.top_list{
	font-size:16px;
	list-style:none;
	font-weight:700;
	margin-top:30px!important;
}
</style>
</head>

<body>
	<div id="content">
		<?php include("menu_require.php"); ?>
		<div id="space"></div>

		<div id="regras">
			<h2><i class="fas fa-book-open"></i> Regras e condutas de criação de partidas</h2>
			<div id="regras_content">
			<p>Seja bem vindo ao nosso livro de regras. Todas as regras e condutas aqui expressas devem ser estritamente seguidas, sendo passíveis de punições como banimento e perca de pontos de seu rankeamento. Leia também com atenção nossos <a target="_blank" href="termos.html">Termos de Uso.</a></p>
			<ul class="indice">
				<li class="title"><a href="#">1. Apresentação</a></li>
				<li class="title"><a href="#video_tutorial">Vídeo-tutorial</a></li>
				<li class="title"><a href="#lobbyepartida">2. Lobby e partida</a></li>
				<li style="margin-left:30px;"><a href="#modosdejogo">2.1 Modos de jogo</a></li>
				<li style="margin-left:30px;"><a href="#lobby">2.2 Lobby no R6: Club</a></li>
				<li style="margin-left:60px;"><a href="#lobby">2.2.1 Capitão</a></li>
				<li style="margin-left:60px;"><a href="#lobby">2.2.2 Usuários verificados</a></li>
				<li style="margin-left:60px;"><a href="#lobby">2.2.3 Usuários Premium</a></li>
				<li style="margin-left:30px;"><a href="#jogadorausente">2.3 Jogador ausente</a></li>
				<li style="margin-left:30px;"><a href="#mappool">2.4 Map Pool</a></li>
				<li style="margin-left:30px;"><a href="#hospedagem">2.5 Hospedagem da partida</a></li>
				<li style="margin-left:30px;"><a href="#configuracoesdecriacao">2.6 Configurações de criação</a></li>
				<li style="margin-left:30px;"><a href="#resultadodapartida">2.7 Resultado da partida</a></li>
				<li style="margin-left:30px;"><a href="#remake">2.8 Remake</a></li>
				<li style="margin-left:30px;"><a href="#desconexoeseabandonos">2.9 Desconexões e abandonos</a></li>
				<li class="title"><a href="#infracoes">3. Infrações</a></li>
				<li style="margin-left:30px;"><a href="#spam">3.1 Spam</a></li>
				<li style="margin-left:30px;"><a href="#resultadosfalsos">3.2 Resultados falsos</a></li>
				<li class="title"><a href="#outrasregras">4. Outras regras</a></li>
				<li style="margin-left:30px;"><a href="#usuarioseregioes">4.1 Usuários e regiões</a></li>
				<li style="margin-left:30px;"><a href="#livestreamsegravacoes">4.2 Livestream e gravações</a></li>
				<li style="margin-left:30px;"><a href="#suporteviachat">4.3 Suporte via chat</a></li>
			</ul>
			<h3>Vídeo-tutorial básico</h3>
			<iframe id="video_tutorial" width="560" height="315" src="https://www.youtube.com/embed/L60YosOCwas?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			<h3 id="lobbyepartida" style="margin-top:50px;">2. Lobby e partida</h3>
			<p>Antes de buscar uma partida, verifique seu hardware, software, conexões, roteadores, componentes do computador, problemas de energia, etc. Você poderá ser banido caso seja desconectado por algum dos itens anteriores. Busque uma partida com o <b>JOGO ABERTO</b> para agilizar o processo.</p>
			<h4 id="modosdejogo">2.1 Modos de jogo</h4>
			<p>As partidas são organizadas em 2 modos de jogo: 4 FUN e RANKED. Conheça-os:</p>
			<p><b>RANKED: </b> jogando nesse modo você ganha pontos e pode upar sua patente. Além disso, você ganha 2X mais XP do que em partidas 4FUN, permitindo upar seu nível rapidamente.</p>
			<p><b>4 FUN:</b> como o nome já diz, jogue esse modo por diversão, ou então para treinar. Não dá pontos, mas você ganha XP para upar seu nível.</p>
			<h4 id="lobby">2.2 Lobby no R6: Club</h4>
			<p>Logo após encontrar o lobby no R6: Club, você poderá notar 3 diferentes marcadores após o nick de alguns jogadores:</p>
				<p><span style="font-size:10px;padding:2px 5px 2px 5px;color:#FFF;background-color:#284251;border-radius:5px;">CAPITÃO</span>: o capitão da equipe em que pertence.</p>
				<p><span style="font-size:10px;padding:2px 5px 2px 5px;color:#FFF;background-color:#384654;border-radius:5px;">VOCÊ</span>: o seu usuário.</p>
				<p><i style="background-color:#6ba94a;padding:3px;font-size:9px;margin-left:4px;border-radius: 50%;color:#fff;" title="Verificado" class="fas fa-check"></i>: usuário com conta verificada.</p>
				<p><i style="padding:3px;font-size:16px;margin-left:4px;border-radius: 50%;color:#ff9914;" title="Premium" class="fas fa-fire"></i>: usuário que adquiriu nosso <a href="premium">plano Premium</a>.</p>
			<h4 style="margin-left:30px;">2.2.1 Capitão</h4>
			<p style="margin-left:30px;">O capitão de cada equipe tem o papel de adicionar e convidar os membros da sua equipe para a partida personalizada. Um dos capitães deve ser responsável por criar a partida personalizada configurada de acordo com as regras do tópico 2.6. Caso o capitão não consiga convidar ou criar a partida para os jogadores, os outros da equipe podem faze-lo. O capitão também tem o dever de enviar os resultados da partida no R6:Club quando a mesma acabar no jogo.</p>
			<h4 style="margin-left:30px;">2.2.2 Usuários verificados</h4>
			<p style="margin-left:30px;">Usuários verificados são usuários que tiveram sua conta confirmada pela equipe do Rainbow 6: Club. Geralmente, são pessoas com influência no cenário do game, como jogadores profissionais, coachs, streamers, etc.</p>
			<h4 style="margin-left:30px;">2.2.3 Usuários Premium</h4>
			<p style="margin-left:30px;">Usuários Premium são usuários que adquiriram nosso plano Premium, que oferece uma série de benefícios. Você pode saber mais, clicando <a href="premium">aqui</a>.</p>
			<h4 id="jogadorausente">2.3 Jogador ausente</h4>
			<p>Se um jogador, após encontrar a partida no R6: Club, não aparecer dentro de 5 minutos, o lobby deve ser reportado. Se o lobby for reportado por 70% dos jogadores, o mesmo é cancelado e uma nova busca começa. Você também pode optar por conversar com o suporte no chat ao vivo.</p>
			<h4 id="mappool">2.4 Map Pool</h4>
			<p>No modo de jogo RANKED Open: apenas os mapas do meta do game estão liberados para serem votados. Já no modo 4FUN, todos os mapas com excessão de Torre, podem ser escolhidos. O formato de todas partidas na plataforma é MD1 (melhor de 1 mapa).</p>
			<h4 id="hospedagem">2.5 Hospedagem da partida</h4>
			<p>Todas as partidas devem ser hospedadas nos servidores dedicados da Ubisoft na região SA (South America). A criação da partida deve ser realizada por um dos capitães das equipes, assim como a tarefa de convidar os jogadores da equipe. A troca de servidor só é permitida com o consentimento de todos os jogadores da partida.</p>
			<p><b>OBS: Caso algum(s) jogador(es) não entre no lobby ou não aceite o pedido de amizade do capitão de sua equipe, deve ser aberto um chamado no suporte em chat para que o lobby seja fechado e o(s) jogador(es) sejam punidos.</b></p>
			<h4 id="configuracoesdecriacao">2.6 Configurações de criação</h4>
			<p><b>Todos os jogadores do R6: Club devem ter essas configurações já salvas em uma partida personalizada.</b></p>
			<p>No jogo, clique em JOGAR, depois em MULTIPLAYER, em seguida clique em JOGO PERSONALIZADO (ONLINE). Caso possua a configuração do R6:CLUB abaixo já salva, selecione-a trocando somente o mapa da partida. Caso não, clique em CRIAR NOVAS CONDIÇÕES DE JOGO. Selecione o MODO NORMAL e clique em ADICIONAR UMA PARTIDA. Configure como abaixo (PADRÃO ESL):</p>
			<ul class="configs">
				<li class="top_list">Configuração do jogo:</li>
				<li>Hora do dia: Dia</li>
				<li>Configurações de display de navegação: Pro League</li>
				<li>Modo de Jogo: TDM - Bomba</li>
				<li class="top_list">Configuração da partida:</li>
				<li style="font-weight:700;">Banimentos</li>
				<li>Número de banimentos: 4</li>
				<li>Tempo de banimento: 30</li>
				<li style="font-weight:700; margin-top:20px;">Rodadas</li>
				<li>Número de rodadas: 10</li>
				<li>Inverter atacante/defensor: 5</li>
				<li>Rodadas de prorrogação: 3</li>
				<li>Dif. Pontos prorrogação: 2</li>
				<li>Inv. Papéis prorrogação: 1</li>
				<li>Parâmetro de Rotação de Objetivo: 2</li>
				<li>Rotação do Tipo de Objetivo: Rodadas jogadas</li>
				<li>Spawn exclusivo para atacantes: Ligado</li>
				<li>Tempo da fase de escolha: 25</li>
				<li>Fase da 6ª escolha: Ligado</li>
				<li>Tempo da fase da 6ª escolha: 20</li>
				<li style="font-weight: 700; margin-top:20px;">Saúde e Danos</li>
				<li>Ajuste de níveis de dano: 100</li>
				<li>Dano de fogo amigo: 100</li>
				<li>Ferido: 20</li>
				<li style="font-weight: 700; margin-top:20px;">Controle de Personagem</li>
				<li>Corrida: Ligado</li>
				<li>Inclinar: Ligado</li>
				<li style="font-weight: 700; margin-top:20px;">Morte</li>
				<li>Replay da eliminação: Ligado</li>
				<li class="top_list">Configuração de modo de jogo:</li>
				<li style="font-weight:700; margin-top:20px;">Parâmetros para bombas</li>
				<li>Duração da instalação: 7</li>
				<li>Duração da desativação: 7</li>
				<li>Tempo de fusão: 45</li>
				<li>Seleção do Tipo de Desativador: Ligado</li>
				<li style="font-weight:700; margin-top:20px;">Fases</li>
				<li>Duração da fase de preparação: 45</li>
				<li>Duração da fase de ação: 180</li>
			</ul>
			<p>OBS: A alteração das condições inicias da partida no lobby in-game é estritamente proibido (como o banimento de operadores antes do ínicio). Todas as configurações com excessão das acima devem ser mantidas padrão e não sofrer alterações.</p>
			<h4 id="resultadodapartida">2.7 Resultado da partida</h4>
			<p>Após o término da partida, os capitães devem imediatamente enviar o resultado da partida para o R6:Club (clicando no botão verde abaixo do chat). Caso o placar de um capitão não seja igual ao do outro, a partida será dada como empate e um membro da equipe do R6: Club irá setar o resultado manualmente. O capitão que enviou o resultado incorreto não receberá os pontos e nem o XP da partida.</p>
			<p>Caso você não concorde com o resultado de uma partida, reporte o lobby ou converse com nosso suporte via chat.</p>
			<h4 id="remake">2.8 Remake</h4>
			<p>O limite de remakes é 2. Os remakes são permitidos nos seguintes casos:</p>
			<ul>
				<li>Perca de conexão de 2 ou mais jogadores.¹</li>
				<li>Bugs que não permitem a continuação da partida, como carregamento infinito.</li>
				<li>Bugs do game que prejudiquem uma das equipes.</li>
				<li>Falhas no servidor.</li>
				<li>Violação grave de alguma das regras deste livro.</li>
			</ul>
			<p>¹: jogadores que desconectam-se propositalmente são passíveis de punição. Denuncie clicando no nick e acessando o perfil.</p>
			<p>A partida que sofrer remake, deve continuar de onde parou. Todas as rodadas totalmente concluídas antes do incidente contam na pontuação final do jogo. Os jogadores podem escolher diferentes loadouts ou operadores, mas precisam selecionar o mesmo local de bombas. Nas rodadas seguintes, os locais de bombas já usados antes do remake não poderão ser selecionados novamente.</p>
			<h4 id="desconexoeseabandonos">2.9 Desconexões e abandonos</h4>
			<p>Caso um jogador se desconecte de uma partida durante a fase de preparação, o round onde a desconexão ocorreu continuará ininterrupto. O jogador poderá voltar quando quiser. Caso não retorne, a partida deve continuar até a apresentação de um ganhador.</p>
			<h3 id="infracoes">3. Infrações</h3>
			<h4 id="spam">3.1 Spam</h4>
			<p>O envio de mensagens ofendendo, denegrindo, ou assediando alguém é considerado spam (tanto in-game, quanto no R6: Club).</p>
			<h4 id="resultadosfalsos">3.2 Resultados falsos</h4>
			<p>O envio de informações falsas da partida à plataforma Rainbow 6: Club é infração grave, e pode acarretar o banimento de sua conta.</p>
			<h3 id="outrasregras">4. Outras regras</h3>
			<h4 id="usuarioseregioes">4.1 Usuários e regiões</h4>
			<p>Usuários de todo o globo são bem vindos ao R6: Club. Mas, devem se adaptar ao idioma (Português), à cultura local, e ao servidor SA no jogo.</p>
			<h4 id="livestreamsegravacoes">4.2 Livestreams e gravações</h4>
			<p>Os usuários são livres para transmitir e gravar as partidas organizadas através do Rainbow 6: Club desde que estes materiais não sejam usados para ofender ou denegrir as imagens dos jogadores.</p>
			<h4 id="suporteviachat">4.3 Suporte via chat</h4>
			<p>O suporte via chat pode ser acionado clicando no botão azul no canto inferior direito em qualquer página do R6: Club. Entretanto, o suporte pode não funcionar ou pode haver demora na resposta no seguinte horário: 00h até 10h.</p>
			<p>Reservamos-nos no direito de alterar, excluir e adicionar regras quando for necessário, utilizando o bom senso e a ética.</p>
			<a href="#regras_content">Voltar ao topo</a>
			</div>
		</div>
	
	<?php include('foot.php'); ?>
	</div>
</body>
</html>