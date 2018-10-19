<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['gamemode']) and isset($_POST['type'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	//DADOS DO USUÁRIO PARA SEREM UTILIZADOS NA PÁGINA
	$nick = $dados_user['nick'];
	$email = $dados_user['email'];
	$gamemode = $_POST['gamemode'];
	$type = $_POST['type'];
	$ativado = $dados_user['ativado'];
	if(isset($_SESSION['qnt_ban']) and $_SESSION['qnt_ban'] >= 3){
		echo "qnt_ban";
		unset($_SESSION['login_id']);
		unset($_SESSION['qnt_ban']);
		setcookie('login');
		setcookie('pass');
		exit();
	}
	if(isset($_SESSION['ban_time'])){
		$tempo_ban = $_SESSION['ban_time'];
		if(strtotime(date("Y-m-d H:i:s")) >= strtotime($tempo_ban)){
			unset($_SESSION['ban_time']);
		}else{
			echo "click_ban";
			exit();
		}
	}
	if($ativado == 2){
		echo "banned";
		exit();
	}
	$busca_config_lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM config_site WHERE config_name = 'lobby_is'"));
	if($busca_config_lobby['valor'] == 'open'){
		$busca_table_search = mysqli_query($conexao, "SELECT id_user, ativo, playing FROM users_buscando WHERE id_user = '$id' and ativo = '1'");
		$busca_table_user = mysqli_fetch_array(mysqli_query($conexao, "SELECT xp FROM users WHERE id = '$id'"));
		if(mysqli_num_rows($busca_table_search) == 0){
			$tempo_atual = date("Y-m-d H:i:s");
			$xp = $busca_table_user['xp'];
			if($gamemode == "rankedopen") {
				if($xp >= 250){
					$insere_busca_match = mysqli_query($conexao, "INSERT into users_buscando (id_user, tempo_inicio, gamemode, ativo, playing, click_modal, reservados, id_lobby, type) VALUES ('$id', '$tempo_atual', '$gamemode', '1', '0', '0', '0', '0', '$type')");
					if($insere_busca_match == true){
						echo "success";
					}else{
					echo "error";
					}
				}else{
					echo "error[jogarmais]";
				}
			}else{
				$insere_busca_match = mysqli_query($conexao, "INSERT into users_buscando (id_user, tempo_inicio, gamemode, ativo, playing, click_modal, reservados, id_lobby, type) VALUES ('$id', '$tempo_atual', '$gamemode', '1', '0', '0', '0', '0', '$type')");
				if($insere_busca_match == true){
					echo "success";
				}else{
					echo "error";
				}
			}
			
				
		
		}else{
			$dados = mysqli_fetch_array($busca_table_search);
			if($dados['playing'] == 1){
				echo "error[jogando]";
			}else{
				echo "error[jabuscando]";
			}
		}
		
	}else{
		echo "error[lobbyfechado]";
	}
	
	
}else{
	header("Location: apresentation");	
}
?>