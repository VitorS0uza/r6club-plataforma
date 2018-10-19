<?php
	session_name(md5("www.r6club.com.br"));
	session_start();
	function Erro($texto){
		$array = array('status' => $texto);
		return json_encode($array, JSON_PRETTY_PRINT);
	}
	function Sucesso($texto){
		$array = array('status' => $texto);
		return json_encode($array, JSON_PRETTY_PRINT);
	}
	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['type']) and isset($_POST['lobby']) and is_numeric($_POST['lobby']) == true){
		require('connection.php');
		$id = $_SESSION['login_id'];
			$acao = $_POST['type'];
			$id_lobby = (is_numeric($_POST['lobby'])==true) ? $_POST['lobby'] : NULL;
			$tempo_atual = date("Y-m-d H:i:s");
					$msg = (isset($_POST['msg'])==true and $_POST['msg'] != '') ? filter_var($_POST['msg'], FILTER_SANITIZE_SPECIAL_CHARS) : NULL;
					$time = (isset($_POST['time']) == true and $_POST['time'] == 'azul' or $_POST['time'] == 'laranja' or $_POST['time'] == 'ambos') ? $_POST['time'] : NULL;
					$nick = (isset($_POST['nick']) == true) ? $_POST['nick'] : NULL;
					if(trim($msg) != NULL and $time != NULL and $nick != NULL){
						$insere_msg = mysqli_query($conexao, "INSERT INTO chat (id_user, content, id_lobby, timestamp, time, nick) VALUES ('$id', '$msg', '$id_lobby', '$tempo_atual', '$time', '$nick')");
						if($insere_msg === true){
						echo Sucesso('success');
						}
					}else{
						echo Erro('erro_null');
					}
	}else{
		echo Erro('erro_faltam');
	}
?>