<?php
	session_name(md5("www.r6club.com.br"));
	session_start();
	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){

		if(isset($_POST['map'])){
			require('connection.php');
			$id = $_SESSION['login_id'];
			$map = $_POST['map'];
			$busca_db = mysqli_query($conexao, "SELECT id_lobby FROM users_buscando WHERE id_user = '$id' AND playing = '1' AND id_lobby != '0'");
			if(mysqli_num_rows($busca_db) == 1){
				$dados = mysqli_fetch_array($busca_db);
				$id_lobby = $dados['id_lobby'];
				$busca_voto = mysqli_query($conexao, "SELECT * FROM map_votes WHERE id_user = '$id' and id_lobby = '$id_lobby'");
				if(mysqli_num_rows($busca_voto) == 0){
					$insere_voto = mysqli_query($conexao, "INSERT INTO map_votes (id_user, map, id_lobby) VALUES ('$id','$map','$id_lobby')");
					if($insere_voto == true){
						echo "success";
					}else{
						echo "error";
					}
				}else{
					echo "javotado";
				}

			}else{
				echo "error";
			}

		}elseif(isset($_POST['finaliza_votacao']) and isset($_POST['lobby'])){
			require('connection.php');
			$maps_ranked = array('banco', 'chale', 'clubhouse', 'consulado', 'fronteira', 'litoral', 'hereford');
			$maps = array('aviao','banco','canal','chale','clubhouse','consulado','favela','fronteira','hereford','iate','kafe','litoral');
			$id = $_SESSION['login_id'];
			$id_lobby = (is_numeric($_POST['lobby'])== true) ? $_POST['lobby'] : NULL;
			$busca_db = mysqli_query($conexao, "SELECT id_lobby FROM users_buscando WHERE id_user = '$id' AND playing = '1' AND id_lobby != '0'");
			$tempo_agora = date("Y-m-d H:i:s");
			if(mysqli_num_rows($busca_db) == 1){
				$busca_lobby = mysqli_query($conexao, "SELECT id, mapa, type FROM lobby WHERE id = '$id_lobby'");
				if(mysqli_num_rows($busca_lobby) == 1){
						$dados_lobby = mysqli_fetch_array($busca_lobby);
						if($dados_lobby['mapa'] != ""){
							$msg = array('status' => 'success', 'map' => $dados_lobby['mapa']);
							echo json_encode($msg);
							exit();
						}
						$votos = mysqli_query($conexao, "SELECT map, count(map) FROM map_votes WHERE id_lobby = '$id_lobby' GROUP BY map having count(map)=(Select max(A.CNT) from (Select count(map) as CNT from map_votes where id_lobby = '$id_lobby' group by (map)) as A)");
						if($votos == true){
							$atualiza = mysqli_query($conexao, "UPDATE lobby SET map_vote_tempo = '$tempo_agora' WHERE id = '$id_lobby'");
							if(mysqli_num_rows($votos) == 0){
								if($dados_lobby['type'] == 'rankedopen'){
									$mapa_escolhido = array_rand($maps_ranked,1);
									$update = mysqli_query($conexao, "UPDATE lobby SET mapa = '$maps_ranked[$mapa_escolhido]' WHERE id = '$id_lobby'");
									if($update == true){ $msg = array('status' => 'success', 'map' => $maps_ranked[$mapa_escolhido]);echo json_encode($msg);}else{echo json_encode(array('status' => 'error'));}	
								
								}else{
									$mapa_escolhido = array_rand($maps,1);
									$update = mysqli_query($conexao, "UPDATE lobby SET mapa = '$maps[$mapa_escolhido]' WHERE id = '$id_lobby'");
									if($update == true){ $msg = array('status' => 'success', 'map' => $maps[$mapa_escolhido]);echo json_encode($msg);}else{echo json_encode(array('status' => 'error'));}	
								}
								
							}elseif(mysqli_num_rows($votos) == 1){
								$mapa_sql = mysqli_fetch_array($votos);
								$mapa_escolhido = $mapa_sql['map'];
								$update = mysqli_query($conexao, "UPDATE lobby SET mapa = '$mapa_escolhido' WHERE id = '$id_lobby'");
								if($update == true){ $msg = array('status' => 'success', 'map' => $mapa_escolhido);echo json_encode($msg);}else{echo json_encode(array('status' => 'error'));}		
							}elseif(mysqli_num_rows($votos) > 1){
								$votos_again = mysqli_query($conexao, "SELECT map, count(map) FROM map_votes WHERE id_lobby = '$id_lobby' and map != 'oregon' GROUP BY map having count(map)=(Select max(A.CNT) from (Select count(map) as CNT from map_votes where id_lobby = '$id_lobby' group by (map)) as A) ORDER BY rand() LIMIT 1");
								$votos_again_array = mysqli_fetch_array($votos_again);
								$mapa_escolhido = $votos_again_array['map'];
								$update = mysqli_query($conexao, "UPDATE lobby SET mapa = '$mapa_escolhido' WHERE id = '$id_lobby'");
								if($update == true){ $msg = array('status' => 'success', 'map' => $mapa_escolhido);echo json_encode($msg);}else{echo json_encode(array('status' => 'error'));}	
							}
						}else{
							$msg = array('status' => 'error');
							echo json_encode($msg);
						}
					
				}else{
					$msg = array('status' => 'error');
							echo json_encode($msg);
				}
			}else{
				$msg = array('status' => 'error');
				echo json_encode($msg);
			}
		}
	}else{
		header('Location: apresentation.php');
	}