<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['result_azul']) and isset($_POST['result_laranja']) and isset($_POST['id_lobby']) and isset($_POST['nick'])){
	if(is_numeric($_POST['result_azul']) and is_numeric($_POST['result_laranja']) and is_numeric($_POST['id_lobby'])){
		require('connection.php');
		$id = $_SESSION['login_id'];
		$id_lobby = $_POST['id_lobby'];
		$nick = $_POST['nick'];
		$result_azul = (int) $_POST['result_azul'];
		$result_laranja = (int) $_POST['result_laranja'];
		$busca_lobby = mysqli_query($conexao, "SELECT * FROM lobby WHERE id = '$id_lobby'");
		if(mysqli_num_rows($busca_lobby) == 1){
			$dados = mysqli_fetch_array($busca_lobby);
			if($dados['cancelado'] != '1' and $dados['finalizado'] != '1'){
			$gamemode = $dados['type'];
			$time_azul = $dados['time_azul'];
			$time_laranja = $dados['time_laranja'];
			$times = $time_laranja.','.$time_azul;
			$tempo_inicio = strtotime($dados['tempo_inicio']);
			$tempo_atual = strtotime(date("Y-m-d H:i:s"));
			$tempo_inclusao = date("Y-m-d H:i:s", strtotime("+3 seconds"));
			$subTempos = $tempo_atual - $tempo_inicio;
			if($subTempos/60 >= 10){
				$busca_placar = mysqli_query($conexao, "SELECT id FROM lobby_placar WHERE id_user = '$id' AND id_lobby = '$id_lobby'");
				if(mysqli_num_rows($busca_placar) == 0){
					$busca_placar_unic = mysqli_query($conexao, "SELECT id, result_azul, result_laranja FROM lobby_placar WHERE id_lobby = '$id_lobby'");
								if(mysqli_num_rows($busca_placar_unic) == 1){
								$msg = "finalizou a partida com o resultado <br/><span>TIME AZUL:</span> ".$result_azul. " <span>TIME LARANJA:</span> ".$result_laranja;
								$insere_resultado = mysqli_query($conexao, "INSERT INTO lobby_placar (id_lobby, result_azul, result_laranja, id_user, tempo_inclusao) VALUES ('$id_lobby','$result_azul','$result_laranja','$id', '$tempo_inclusao')");
								$insere_resultado .= mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('0', '$msg', '$id_lobby', '$tempo_inclusao', 'ambos', '$nick')");
								$insere_resultado .= mysqli_query($conexao, "UPDATE lobby SET tempo_final = '$tempo_inclusao', finalizado = '1' WHERE id = '$id_lobby'");
								$insere_resultado .= mysqli_query($conexao, "DELETE FROM users_buscando WHERE id_user IN ($times)");
								$dados_placar = mysqli_fetch_array($busca_placar_unic);

									if($dados_placar['result_azul'] == $result_azul and $dados_placar['result_laranja'] == $result_laranja){
										$msg = "PARTIDA FINALIZADA.<br/> Pontos/XP contabilizados. Você já pode sair desta página.";
										$insere_resultado .= mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('0', '$msg', '$id_lobby', '$tempo_inclusao', 'ambos', 'SERVIDOR: ')");
										$placar = $result_azul.'x'.$result_laranja;
										$insere_resultado .= mysqli_query($conexao, "UPDATE lobby SET placar = '$placar' WHERE id = '$id_lobby'");
										
										if($result_laranja > $result_azul){
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET vencidas = vencidas+1 WHERE id IN ($time_laranja)");
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET perdidas = perdidas+1 WHERE id IN ($time_azul)");
											// XP PARA O TIME LARANJA E AZUL
											$xpGanho = ($gamemode == 'rankedopen') ? $result_laranja * 40 : $result_laranja * 20;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET xp = xp + $xpGanho WHERE id IN ($time_laranja)");
											$xpGanho = ($gamemode == 'rankedopen') ? $result_azul * 40 : $result_azul * 20;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET xp = xp + $xpGanho WHERE id IN ($time_azul)");

											if($gamemode != '4fun'){
											$pontosGanho = $result_laranja * 15;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET pontos = pontos + $pontosGanho WHERE id IN ($time_laranja)");
											$pontosPerdidos = $result_azul * 15;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET pontos = pontos - $pontosPerdidos WHERE id IN ($time_azul) AND pontos - $pontosPerdidos >= 0");
											}

										}elseif($result_azul > $result_laranja){
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET vencidas = vencidas+1 WHERE id IN ($time_azul)");
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET 
											 perdidas = perdidas+1 WHERE id IN ($time_laranja)");

											// XP PARA O TIME LARANJA E AZUL
											$xpGanho = ($gamemode == 'rankedopen') ? $result_azul * 40 : $result_azul * 20;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET xp = xp + $xpGanho WHERE id IN ($time_azul)");
											$xpGanho = ($gamemode == 'rankedopen') ? $result_laranja * 40 : $result_laranja * 20;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET xp = xp + $xpGanho WHERE id IN ($time_laranja)");

											if($gamemode != '4fun'){
											$pontosGanho = $result_azul * 15;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET pontos = pontos + $pontosGanho WHERE id IN ($time_azul)");
											$pontosPerdidos = $result_laranja * 15;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET pontos = pontos - $pontosPerdidos WHERE id IN ($time_laranja) AND pontos - $pontosPerdidos >= 0");
											}
										}elseif($result_azul == $result_laranja){
											$xpGanho = ($gamemode == 'rankedopen') ? ($result_azul + $result_laranja)/2 * 40 : ($result_azul + $result_laranja)/2 * 20;
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET vencidas = vencidas+1 WHERE id IN ($times)");
											$insere_resultado .= mysqli_query($conexao, "UPDATE users SET xp = xp + $xpGanho WHERE id IN ($times)");

											if($gamemode != '4fun'){
												$pontosGanho = $result_azul * 15;
												$insere_resultado .= mysqli_query($conexao, "UPDATE users SET pontos = pontos + $pontosGanho WHERE id IN ($times)");
											}
											
										}
									}else{
										$msg = "PARTIDA FINALIZADA.<br/> Os resultados não coincidiram. Um administrador irá validar o resultado. Você já pode sair desta página.";
										$insere_resultado .= mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('0', '$msg', '$id_lobby', '$tempo_inclusao', 'ambos', 'SERVIDOR: ')");
										$placar_final = '0x0';
										$insere_resultado .= mysqli_query($conexao, "UPDATE lobby SET placar = '$placar_final' WHERE id = '$id_lobby'");
									}

								}elseif(mysqli_num_rows($busca_placar_unic) == 0){
								$msg = "finalizou a partida com o resultado <br/><span>TIME AZUL:</span> ".$result_azul. " <span>TIME LARANJA:</span> ".$result_laranja;

								$insere_resultado = mysqli_query($conexao, "INSERT INTO lobby_placar (id_lobby, result_azul, result_laranja, id_user, tempo_inclusao) VALUES ('$id_lobby','$result_azul','$result_laranja','$id', '$tempo_inclusao')");
								$insere_resultado .= mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('0', '$msg', '$id_lobby', '$tempo_inclusao', 'ambos', '$nick')");
								}
									if($insere_resultado == true){
										echo "success";
									}else{
										echo "error";
									}
				}else{
					echo "error[jaadicionou]";
				}
			}else{
				echo "error[10minutos]";
			}

		}else{
			echo "error[cancelado]";
		}

		}else{
			echo "error";
		}

	}else{
		echo "error[naonumerico]";
	}
}else{
	echo "error[faltamdados]";
}
?>