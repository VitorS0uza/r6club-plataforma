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

	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['type']) and $_POST['type'] === 'recebeMsg' and isset($_POST['lobby']) and is_numeric($_POST['lobby']) == true){
		require('connection.php');
		$id = $_SESSION['login_id'];
			$acao = $_POST['type'];
			$id_lobby = (is_numeric($_POST['lobby'])==true) ? $_POST['lobby'] : NULL;
			$tempo_atual = date("Y-m-d H:i:s");
			$busca_user = mysqli_query($conexao, "SELECT * FROM users WHERE id = '$id'");
			$dados = mysqli_fetch_array($busca_user);

					$tempo_page = (isset($_SESSION['time_chat'])== true) ? $_SESSION['time_chat'] : date("Y-m-d H:i:s");
					$time_now = date("Y-m-d H:i:s");
					$seleciona_msg = mysqli_query($conexao, "SELECT * from chat WHERE id_user != '$id' and id_lobby = '$id_lobby' and timestamp >= '$tempo_page' ORDER BY id ASC");
					if(mysqli_num_rows($seleciona_msg) > 0){
						$_SESSION['time_chat'] = $time_now;
						$msgs = array('status' => 'success', 'msgs'=>mysqli_num_rows($seleciona_msg) );
						while($dados = mysqli_fetch_array($seleciona_msg)){
							$identity = date("YmdHis", strtotime($dados['timestamp'])).$dados['id_user'].$dados['id'];
							$render = array(
								'id_user'=>$dados['id_user'],
								'contente'=>$dados['content'],
								'time'=>$dados['time'],
								'nick'=>$dados['nick'],
								'identity'=>$identity
							);
								array_push($msgs, $render);
						}
						echo json_encode($msgs, JSON_PRETTY_PRINT);
					}else{
						echo Erro('notnew');
					}
	}else{
		echo Erro('erro');
	}
?>