<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['motivo']) and isset($_POST['id_lobby'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$id_lobby = $_POST['id_lobby'];
	$tempo_inclusao = date("Y-m-d H:i:s", strtotime("+3 seconds"));
	$motivo = trim(filter_var($_POST['motivo'], FILTER_SANITIZE_STRING));
	$busca_report = mysqli_query($conexao, "SELECT id FROM lobby_reports WHERE id_quem_reportou = '$id' and id_lobby = '$id_lobby' ");
	$busca_lobby = mysqli_query($conexao, "SELECT cancelado, id, finalizado, time_azul, time_laranja FROM lobby WHERE id = '$id_lobby'");
	$dado_lobby = mysqli_fetch_array($busca_lobby);
	$cancelado = $dado_lobby['cancelado'];
	$finalizado = $dado_lobby['finalizado'];
	$times = $dado_lobby['time_azul'].','.$dado_lobby['time_laranja'];
		if($cancelado == '0'){
			if(mysqli_num_rows($busca_report) == 0){
				$data = date("Y-m-d H:i:s");
				$insere_report = mysqli_query($conexao, "INSERT INTO lobby_reports (id_quem_reportou, id_lobby, motivo, data) VALUES ('$id', '$id_lobby', '$motivo', '$data')");
				$busca_reports = mysqli_query($conexao, "SELECT id FROM lobby_reports WHERE id_lobby = '$id_lobby'");
				if(mysqli_num_rows($busca_reports) >= 7 and $finalizado == '0'){
					$msg = "PARTIDA CANCELADA. <br/> Cancelamento ocorreu pois obteve 70% de denúncias dos jogadores. Leia nossas regras de criação de partidas e saiba mais. <br/> Você já pode sair desta página";
					$insere_report .= mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('0', '$msg', '$id_lobby', '$tempo_inclusao', 'ambos', 'SERVIDOR: ')");
					$insere_report .= mysqli_query($conexao, "UPDATE lobby SET cancelado = '1', tempo_final = '$tempo_inclusao' WHERE id = '$id_lobby'");
					$insere_report .= mysqli_query($conexao, "DELETE FROM users_buscando WHERE id_user IN ($times)");
					if($insere_report == true){
						echo "success";
					}else{
						echo "error";
					}
				}else{
						if($insere_report == true){
							echo "success";
						}else{
							echo "error";
						}
				}
				
			}else{
				echo "try";
			}
		}else{
			echo "cancelado";
		}

	
	
	
}else{
	echo "Erro [003]: Você não está logado ou falta dados para a denúncia.";
}
?>