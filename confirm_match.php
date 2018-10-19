<?php
	session_name(md5("www.r6club.com.br"));
	session_start();
	if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
		require("connection.php");
		$id = $_SESSION['login_id'];
		$busca_user = mysqli_query($conexao, "SELECT id_user FROM users_buscando WHERE id_user = '$id' and ativo = '1' and reservados = '1' and id_lobby != '0'");
		if(mysqli_num_rows($busca_user) == 1){
			$update = mysqli_query($conexao, "UPDATE users_buscando SET click_modal = '1' WHERE id_user = '$id' and ativo = '1' and playing = '0' and reservados = '1'");
			if($update == true){
				echo "success";
			}else{
				echo "error";
			}
		}else{
			echo "error";
		}
	}else{
		header("Location: apresentation");
	}
?>