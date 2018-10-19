<?php
	session_name(md5("www.r6club.com.br"));
	session_start();
	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
		require("connection.php");
		$id = $_SESSION['login_id'];
		$busca_db = mysqli_query($conexao, "SELECT id_lobby FROM users_buscando WHERE id_user = '$id' AND ativo = '1' AND reservados = '1' and id_lobby != '0'");
		if(mysqli_num_rows($busca_db) == 1){
			$dados = mysqli_fetch_array($busca_db);
			$id_lobby = $dados['id_lobby'];
			$busca_lobby = mysqli_query($conexao, "SELECT time_azul, time_laranja, cancelado FROM lobby WHERE id = '$id_lobby'");
			if(mysqli_num_rows($busca_lobby) == 1){
				$dados_lobby = mysqli_fetch_array($busca_lobby);
				$time_azul = $dados_lobby['time_azul'];
				$time_laranja = $dados_lobby['time_laranja'];
				$cancelado = $dados_lobby['cancelado'];
				$times = $time_azul.','.$time_laranja;
				$verifica_click_modal = mysqli_query($conexao, "SELECT click_modal FROM users_buscando WHERE id_user IN ($times) AND ativo = '1' and reservados = '1' and id_lobby = '$id_lobby'");
				$click_modal_array = array();
				while($click_modal = mysqli_fetch_array($verifica_click_modal)){
					array_push($click_modal_array, $click_modal['click_modal']);
				}
				
				if(array_sum($click_modal_array) == 10){
					$atualiza = mysqli_query($conexao, "UPDATE users_buscando SET playing = '1' WHERE id_user IN ($times) and ativo = '1' and reservados = '1' and id_lobby = '$id_lobby'");
					if($atualiza == true){
						echo "success";
					}else{
						echo "error";
					}
				}else{
					$tempo_atual = date("Y-m-d H:i:s");
					$click = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM users_buscando WHERE id_user = '$id' and ativo = '1' and reservados = '1'"));
					if($click['click_modal'] == 0){
						$_SESSION['ban_time'] = date("Y-m-d H:i:s", strtotime("+4 minutes", strtotime(date("Y-m-d H:i:s"))));
						if(isset($_SESSION['qnt_ban'])){
							$_SESSION['qnt_ban'] = $_SESSION['qnt_ban'] + 1;
						}else{
							$_SESSION['qnt_ban'] = 1;
						}
					}

					$retira_registros = mysqli_query($conexao, "DELETE FROM users_buscando WHERE id_user = '$id' AND ativo = '1'");
					if($cancelado == 0){
						$retira_registros .= mysqli_query($conexao, "UPDATE lobby SET cancelado = '1', tempo_final = '$tempo_atual' WHERE id = '$id_lobby'");
					}else{
						$retira_registros .= mysqli_query($conexao, "UPDATE lobby SET tempo_final = '$tempo_atual' WHERE id = '$id_lobby'");
					}
						if($retira_registros == true){
							echo "no";
						}else{
							echo "error";
						}
				}
			}else{
				echo "error";
			}
		}else{
			echo "error";
		}
	}else{
		header('Location: apresentation.php');
	}