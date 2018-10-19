<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_POST['cadastro_hidden']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['password_2']) and isset($_POST['nick']) and !isset($_SESSION['login_id'])){
	require('connection.php');
	require_once("email/PHPMailer.php");
	require_once("email/SMTP.php");
	require_once("email/Exception.php");
	
	$email = trim(strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
	$password = $_POST['password'];
	$password_2 = $_POST['password_2'];
	$nick = trim(filter_var($_POST['nick'], FILTER_SANITIZE_STRING));

	if(isset($_COOKIE['control_l'])){
		exit();
	}
	
	if(!empty($email) and !empty($password) and !empty($password_2) and !empty($nick)){
		
			if(filter_var( $email, FILTER_VALIDATE_EMAIL) == true){
			$busca_email = mysqli_query($conexao,"SELECT * FROM users WHERE LCASE(email) = '$email'");

				if(mysqli_num_rows($busca_email) == 0){

						if($password == $password_2){
								
								if(strlen($nick) >= 3 and strlen($nick) <= 15){
									
									if(is_numeric($nick) == false){
									
											if(strlen($password) >= 5 and strlen($password) <= 24){
												
												if(preg_match("/^[a-zA-Z0-9._-]+$/", $nick)){
													$busca_nick = mysqli_query($conexao, "SELECT * FROM users WHERE LCASE(nick) = '".strtolower($nick)."'");
													
													if(mysqli_num_rows($busca_nick) == 0){
												
														$password_crypt = password_hash($password, PASSWORD_DEFAULT);

														$criar_usuario = @mysqli_query($conexao, "INSERT INTO users (email, senha, nick, mouse, teclado, monitor, headset, xp, pontos, vencidas, perdidas, ativado, verificado, premium, idade, sensi_horizontal, sensi_vertical, sensi_ads, dpi_mouse, img_perfil) VALUES ('$email', '$password_crypt', '$nick', 'não cadastrado','não cadastrado','não cadastrado', 'não cadastrado','0','0', '0','0','0','0','0','13','0','0','0','200', '');");

														if($criar_usuario == true){
															$dado = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM users WHERE email = '$email'"));
															$id = $dado['id'];
															$email_md5 = md5($email);
															$criar_confirmacao = @mysqli_query($conexao, "INSERT INTO confirmar_conta (id_user, token, usado) VALUES ('$id', '$email_md5', '0');");

																	 	$mail = new PHPMailer\PHPMailer\PHPMailer();
																	    $mail->IsSMTP(); // enable SMTP
																	    $mail->CharSet = 'UTF-8';
																	    //$mail->SMTPDebug = 3; // debugging: 1 = errors and messages, 2 = messages only
																	    $mail->SMTPAuth = true;
																	    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
																	    $mail->Host = "mail.smtp2go.com";
																	    $mail->Port = 2525; // or 587
																	    $mail->IsHTML(true);
																	    $mail->Username = "rclubco1";
																	    $mail->Password = "w32215608W$";
																	    $mail->SetFrom("suporte@r6club.com.br");
																	    $mail->Subject = "Ativação de conta - Rainbow 6: Club";
																	    $mail->Body = "<h2>Ativação - Rainbow 6: Club</h2><p><b>Olá ".$nick.", seja bem vindo ao Rainbow 6: Club</b></p><p>Clique no link abaixo e ative sua conta: <br/><a href='http://r6club.com.br/ativarconta?token=".$email_md5."'>ATIVAR CONTA</a></p><p style='font-size:12px;'>Caso o link não funcione, cole no navegador: http://r6club.com.br/ativarconta?token=".$email_md5." </p><p style='font-size:12px;'>Se ainda assim não funcionar, contate um administrador.</p>";
																	    $mail->AddAddress($email);
																	     if($mail->Send()) {
																	       echo "success";
																	     } else {
																	       echo "Erro ao enviar o e-mail. Contate nosso suporte.";
																	     }
																															
							




														}else{
															echo "Ocorreu um erro ao finalizar o cadastro";
														}
														
													}else{
														echo "O nick já existe em nosso sistema";
													}
											
												}else{
													echo "Nick pode apenas conter letras de A-Z e a-z; numerais de 0-9, traço inferior (_), hífen (-) e ponto (.)";
												}

											}else{
												echo "A senha deve ter 5 a 24 caracteres";
											}
									
									}else{
										echo "Nick não pode ser somente números";
									}
									
								}else{
									echo "Nick deve ter 3 a 15 caracteres";
								}
							
						}else{
							echo "Senhas não conferem";
						}

				}else{
					echo "E-mail já cadastrado";
				}

			}else{
				echo "E-mail inválido";
			}

	}else{
		echo "Preencha todos os campos";
	}
	
}else{
	echo "Erro";
}
?>