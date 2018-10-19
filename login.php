<?php
session_name(md5("www.r6club.com.br"));
session_start();
	if(isset($_POST['login_hidden']) and isset($_POST['email']) and isset($_POST['senha']) and !isset($_SESSION['login_id'])){
		require('connection.php');
		$email = trim(strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
		$password = $_POST['senha'];
		$remember = (isset($_POST['acesso'])) ? true : false;
		
			if(!empty($email) and !empty($password)){
				
				if(filter_var($email,FILTER_VALIDATE_EMAIL) == true){
					
					$busca_conta = mysqli_query($conexao,"SELECT id, email, senha, ativado FROM users WHERE email = '$email'");
					
					if(mysqli_num_rows($busca_conta) == 1){
						
						$dados = mysqli_fetch_array($busca_conta);
						$id = $dados['id'];
						$senha_hash = $dados['senha'];
						$ativacao = $dados['ativado'];

						if(password_verify($password, $senha_hash) == true){

							if($ativacao == 1){
								if($remember == true){
									setcookie('login',$email,time()+259200);
									setcookie('pass',$password,time()+259200);
								}else{
									setcookie('login');
									setcookie('pass');
								}
								$_SESSION['login_id'] = $id;
								echo "success";
							}elseif($ativacao == 0){
								echo "Esta conta não foi ativada";
							}elseif($ativacao == 2){
								$busca_motivo = mysqli_query($conexao, "SELECT * FROM banimento_motivo WHERE id_user = '$id'");
								if(mysqli_num_rows($busca_motivo) == 1){
									$dado_ban = mysqli_fetch_array($busca_motivo);
									$motivo = $dado_ban['motivo'];
									$tempo = $dado_ban['tempo'];
									if($tempo == '0'){
									echo "Esta conta foi banida permanentemente. MOTIVO: ".$motivo;	
									}else{
										$tempo_atual = date("Y-m-d H:i:s");
										if(strtotime($tempo_atual) >= strtotime($tempo)){
											$desbane_conta = mysqli_query($conexao, "DELETE FROM banimento_motivo WHERE id_user = '$id'");
											$desbane_conta .= mysqli_query($conexao, "UPDATE users SET ativado = '1' WHERE id = '$id'");
											if($desbane_conta == true){
												if($remember == true){
													setcookie('login',$email,time()+259200);
													setcookie('pass',$password,time()+259200);
												}else{
													setcookie('login');
													setcookie('pass');
												}
												$_SESSION['login_id'] = $id;
												echo "success";
											}else{
												echo "Erro ao desbanir sua conta";
											}
										}else{
											setcookie("control_l","1",time()+25920000);
											echo "Esta conta foi banida até ".date("H:i d/m/Y", strtotime($tempo)).". MOTIVO: ".$motivo;
										}
									}
								}else{
									setcookie("control_l","1",time()+25920000);
									echo "Esta conta foi banida.";
								}
								
							}

						}else{
							echo "Senha incorreta.";
						}
						
					}else{
						echo "E-mail incorreto.";
					}	
						
				}else{
					echo "E-mail inválido";
				}
				
			}else{
				echo "Preencha todos os campos";
			}
	}else{
		echo "Ocorreu um erro. Tente novamente mais tarde";
	}
?>