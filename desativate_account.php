<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$busca_jogando = mysqli_query($conexao, "SELECT id_user FROM users_buscando WHERE id_user = '$id' and ativo = '1'");
	if(mysqli_num_rows($busca_dados_user) == 1 and mysqli_num_rows($busca_jogando) == 0){
		$deleta_conta = mysqli_query($conexao, "DELETE FROM confirmar_conta WHERE id_user = '$id'");
		$deleta_conta .= mysqli_query($conexao, "DELETE FROM users_buscando WHERE id_user = '$id'");
		$deleta_conta .= mysqli_query($conexao, "DELETE FROM users WHERE id = '$id'");
		$deleta_conta .= mysqli_query($conexao, "DELETE FROM denuncias WHERE id_quem_denunciou = '$id'");
		if($deleta_conta == true){
			unset($_SESSION['login_id']);
			header("Location: apresentation.php?disable");
		}else{
			echo "Erro [002]: Não foi possível deletar sua conta.";
		}
	}else{
		echo "Erro [001]: Interrompa a busca de partida ou termine a partida atual para desativar sua conta.";
	}
	
	
	
}else{
	echo "Erro [003]: Você não está logado.";
}
?>