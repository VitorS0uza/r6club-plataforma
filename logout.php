<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	unset($_SESSION['login_id']);
	setcookie('login');
	setcookie('pass');
	header("Location: apresentation");
}else{
	echo "Você não está logado";
}
?>