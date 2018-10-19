<?php
	session_name(md5("www.r6club.com.br"));
	session_start();
	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){

		require("connection.php");
		$id = $_SESSION['login_id'];
		$busca_db = mysqli_query($conexao, "SELECT id_user, ativo, gamemode, reservados FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0' and reservados = '0' and id_lobby = '0'");
		$busca_user = mysqli_query($conexao, "SELECT id_user FROM users_buscando WHERE id_user = '$id' and ativo = '1' and playing = '0' and reservados = '1' and id_lobby != '0'");
		if(mysqli_num_rows($busca_user) == 1){
			echo "found";
			exit();
		}

			if(mysqli_num_rows($busca_db) == 1){
				$dados = mysqli_fetch_array($busca_db);
				$gamemode = $dados['gamemode'];
				$busca_db_qtd = mysqli_query($conexao, "SELECT ativo, gamemode, playing, id_user FROM users_buscando WHERE ativo = '1' and gamemode = '$gamemode' and playing = '0' and reservados = '0' and id_user != '$id' ORDER BY id ASC LIMIT 9");
				if(mysqli_num_rows($busca_db_qtd) == 9){

						$users_id = array();
						while($player = mysqli_fetch_array($busca_db_qtd)){
							array_push($users_id, $player['id_user']);
						}
						array_push($users_id, $id);
						shuffle($users_id);
						$implode_id_user = implode(",", $users_id);
						$reserva_player = mysqli_query($conexao, "UPDATE users_buscando SET reservados = '1' WHERE id_user IN ($implode_id_user) AND ativo = '1' AND playing = '0'");

						$time_azul = implode(",",array_slice($users_id, 0, 5));
						$time_laranja = implode(",",array_slice($users_id, 5, 5));
						$tempo_inicio = date("Y-m-d H:i:s");
						//$time_azul_capitao = explode(",",$time_azul);
						//$time_laranja_capitao = explode(",",$time_laranja);

						$verifica_capitao_azul = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM users WHERE id IN ($time_azul) ORDER BY xp DESC LIMIT 1"));
						$verifica_capitao_laranja = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM users WHERE id IN ($time_laranja) ORDER BY xp DESC LIMIT 1"));

						//$capitao_azul = array_rand(explode(",",$time_azul), 1);
						//$capitao_laranja = array_rand(explode(",",$time_laranja), 1);
						$cria_lobby = @mysqli_query($conexao, "INSERT INTO lobby (time_laranja, time_azul, tempo_inicio, capitao_azul, capitao_laranja, placar, finalizado, tempo_final, mapa, cancelado, type, map_vote_tempo) VALUES ('$time_laranja', '$time_azul', '$tempo_inicio', {$verifica_capitao_azul['id']}, {$verifica_capitao_laranja['id']}, '0', '0', '0000-00-00 00:00:00', '', '0', '$gamemode', '0000-00-00 00:00:00')");
						if($reserva_player == true and $cria_lobby == true){
							$busca_id_lobby = mysqli_fetch_array(mysqli_query($conexao,"SELECT id FROM lobby WHERE time_laranja = '$time_laranja' AND time_azul = '$time_azul' AND finalizado = '0'"));
							$id_lobby = $busca_id_lobby['id'];
							$update = mysqli_query($conexao, "UPDATE users_buscando SET id_lobby = '$id_lobby' WHERE id_user IN ($implode_id_user) AND ativo = '1' AND playing = '0'");
							
							if($update == true){
								echo "found";
							}else{
								echo "error";
							}
						}else{
							echo "error";
						}
						/*if(in_array($id, $users_id)){
							echo "found";
						}*/
						/*$time_azul = json_encode(array_slice($users_id, 0, 5));
						$time_laranja = json_encode(array_slice($users_id, 5, 5));
						$cria_lobby = @mysqli_query($conexao, "INSERT INTO lobby (time_laranja, time_azul) VALUES ('$time_laranja', '$time_azul')");

						if($cria_lobby == true){
								$implode_id_user = implode(",", $users_id);
								$update = @mysqli_query($conexao, "UPDATE users_buscando SET playing = '1' WHERE id_user IN ($implode_id_user) AND ativo = '1' AND playing = '0'");
								if($update == true){
									echo "found";
								}
							}*/
							
						

				}elseif(mysqli_num_rows($busca_db_qtd) < 10){
					echo "research-".(mysqli_num_rows($busca_db_qtd)+1);
				}
			}else{
				echo "error";
			}

	}else{
		header("Location: apresentation");
	}
?>