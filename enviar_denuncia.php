<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['motivo']) and isset($_POST['id_denunciado'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$id_denunciado = $_POST['id_denunciado'];
	$motivo = $_POST['motivo'];
	$provas = trim(filter_var($_POST['provas'], FILTER_SANITIZE_STRING));
	$busca_denuncia = mysqli_query($conexao, "SELECT id FROM denuncias WHERE id_quem_denunciou = '$id' and id_denunciado = '$id_denunciado' ");
	if($id != $id_denunciado){
		if(mysqli_num_rows($busca_denuncia) == 0){
			$data = date("Y-m-d H:i:s");
			$insere_denuncia = mysqli_query($conexao, "INSERT INTO denuncias (id_denunciado, id_quem_denunciou, motivo, provas, data) VALUES ('$id_denunciado', '$id', '$motivo', '$provas', '$data')");
			if($insere_denuncia == true){
				echo "success";
			}else{
				echo "error";
			}
		}else{
			echo "try";
		}
	}else{
		echo "you";
	}
	
	
	
}else{
	echo "Erro [003]: Você não está logado ou falta dados para a denúncia.";
}
?>