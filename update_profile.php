<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	$dados_user = mysqli_fetch_array($busca_dados_user);
	
	if(isset($_POST['atualizar_geral'])){
		$nome = trim(filter_var($_POST['nome'], FILTER_SANITIZE_STRING));
		$email = trim(strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
		$nick = trim(filter_var($_POST['nick'], FILTER_SANITIZE_STRING));
		$idade = trim($_POST['idade']);
		$mostrar_email = (isset($_POST['mostrar_email'])) ? '1' : '0';
		$update = '';	
		if(!empty($email) and !empty($nick) and !empty($idade)){
			 //VERIFICA NOME
				if($nome != $dados_user['nome']){
					
					if(strlen($nome) >= 3 and strlen($nome) <= 20){
						
						if(is_numeric($nome) == false ){
							
							$update .= mysqli_query($conexao, "UPDATE users SET nome = '$nome' WHERE id = '$id'");
							
						}else{
							echo "Nome não pode ter números. ";
						}
						
					}else{
						echo "Nome deve ter entre 3 à 20 caracteres. ";
					}
					
				}
			//FIM VERIFICA NOME
			//VERIFICA MOSTRAR_EMAIL
				if($dados_user['mostrar_email'] != $mostrar_email){
					$update .= mysqli_query($conexao, "UPDATE users SET mostrar_email = '$mostrar_email' WHERE id = '$id'");
				}

			//
			//VERIFICA EMAIL
				if($email != strtolower($dados_user['email'])){
					if(filter_var( $email, FILTER_VALIDATE_EMAIL) == true){
					$busca_email = mysqli_query($conexao,"SELECT * FROM users WHERE LCASE(email) = '$email'");

						if(mysqli_num_rows($busca_email) == 0){
							$data_cadastro = strtotime($dados_user['data_cadastro']);
							$data_15dias = strtotime("+15 day", $data_cadastro);
							if($data_15dias < time()){
							     $update .= mysqli_query($conexao, "UPDATE users SET email = '$email' WHERE id = '$id'");
							}else{
								echo "Email só pode ser alterado 15 dias após o cadastro. ";
							}
						   
						}else{
							echo "Email já existe em nosso sistema. ";
						}
						
					}else{
						echo "Email inválido. ";
					}
					
				}
			//FIM VERIFICA EMAIL
			//VERIFICA NICK
				if(strtolower($nick) != strtolower($dados_user['nick'])){
					
					if(strlen($nick) >= 3 and strlen($nick) <= 15){

						if(is_numeric($nick) == false){

							if(preg_match("/^[a-zA-Z0-9._-]+$/", $nick)){

								$busca_nick = mysqli_query($conexao, "SELECT * FROM users WHERE LCASE(nick) = '".strtolower($nick)."'");

								if(mysqli_num_rows($busca_nick) == 0){
									
									$update .= mysqli_query($conexao, "UPDATE users SET nick = '$nick' WHERE id = '$id'");
									
								}else{
									echo "Nick já existe em nosso sistema. ";
								}

							}else{
								echo "Nick pode apenas conter letras de A-Z e a-z; numerais de 0-9, traço inferior (_), hífen (-) e ponto (.). ";
							}

						}else{
							echo "Nick não pode ser só números. ";
						}

					}else{
						echo "Nick deve ter entre 3 à 15 caracteres. ";
					}
					
				}
			// FIM VERIFICA NICK
			//VERIFICA IDADE
			if($idade != $dados_user['idade']){
				if(is_numeric($idade) == true ){
					if($idade >= 13 and $idade <= 100){
						$update .= mysqli_query($conexao, "UPDATE users SET idade = '$idade' WHERE id = '$id'");
					}else{
						echo "Você precisa ter entre 13 e 65+ anos para utilizar R6: Club. ";
					}
				}else{
					echo "Idade precisa ser um número. ";
				}
			}
			//FIM VERIFICA IDADE
			
		if($update != ''){
			if($update == true){
				echo "";
			}else{
				echo "Erro ao atualizar. ";
			}
		}
			/*if(filter_var( $email, FILTER_VALIDATE_EMAIL) == true){
				$busca_email = mysqli_query($conexao,"SELECT * FROM users WHERE email = '$email'");
				
				if(mysqli_num_rows($busca_email) == 0){
					
						if(is_numeric($idade) == true and $idade >= 13 and $idade <= 110){
					
							if(strlen($nick) >= 3 and strlen($nick) <= 15){

								if(is_numeric($nick) == false){

									if(preg_match("/^[a-zA-Z0-9._-]+$/", $nick)){
									$busca_nick = mysqli_query($conexao, "SELECT * FROM users WHERE nick = '$nick'");

										if(mysqli_num_rows($busca_nick) == 0){

										}else{
											echo "Nick já existe em nosso sistema";
										}

									}else{
										echo "Nick pode apenas conter letras de A-Z e a-z; numerais de 0-9, traço inferior (_), hífen (-) e ponto (.)";
									}

								}else{
									echo "Nick não pode ser só números";
								}

							}else{
								echo "Nick deve ter 3 a 15 caracteres";
							}

					}else{
						echo "Idade inválida";
					}
						
				}else{
					echo "Email já existe em nosso sistema";
				}
				
			}else{
				echo "Email inválido";
			}
			
			
			
			
			
			
			*/
			
		}else{
			echo "Preencha todos os campos. ";
		}
		
		
	}elseif(isset($_POST['atualizar_perifericos'])){
		
		$mouse = (trim(filter_var($_POST['mouse'], FILTER_SANITIZE_STRING)) != "") ? trim(filter_var($_POST['mouse'], FILTER_SANITIZE_STRING)) : "não cadastrado";
		$teclado = (trim(filter_var($_POST['teclado'], FILTER_SANITIZE_STRING)) != "") ? trim(filter_var($_POST['teclado'], FILTER_SANITIZE_STRING)) : "não cadastrado";
		$monitor = (trim(filter_var($_POST['monitor'], FILTER_SANITIZE_STRING)) != "") ? trim(filter_var($_POST['monitor'], FILTER_SANITIZE_STRING)) : "não cadastrado";
		$headset = (trim(filter_var($_POST['headset'], FILTER_SANITIZE_STRING)) != "") ? trim(filter_var($_POST['headset'], FILTER_SANITIZE_STRING)) : "não cadastrado";
		$sensi_horizontal = trim($_POST['sensi_horizontal']);
		$sensi_vertical = trim($_POST['sensi_vertical']);
		$sensi_ads = trim($_POST['sensi_ads']);
		$dpi_mouse = trim($_POST['dpi_mouse']);
		$update = '';
		//VERIFICA MOUSE
		if($mouse != $dados_user['mouse']){
			if(strlen($mouse) <= 25){
				$update .= mysqli_query($conexao, "UPDATE users SET mouse = '$mouse' WHERE id = '$id'");
			}else{
				echo "Mouse deve possuir até 25 caracteres. ";
			}
		}
		//FIM VERIFICA MOUSE
		//VERIFICA TECLADO
		if($teclado != $dados_user['teclado']){
			if(strlen($teclado) <= 25){
				$update .= mysqli_query($conexao, "UPDATE users SET teclado = '$teclado' WHERE id = '$id'");
			}else{
				echo "Teclado deve possuir até 25 caracteres. ";
			}
		}
		//FIM VERIFICA TECLADO
		//VERIFICA MONITOR
		if($monitor != $dados_user['monitor']){
			if(strlen($monitor) <= 25){
				$update .= mysqli_query($conexao, "UPDATE users SET monitor = '$monitor' WHERE id = '$id'");
			}else{
				echo "Monitor deve possuir até 25 caracteres. ";
			}
		}
		//FIM VERIFICA MONITOR
		//VERIFICA HEADSET
		if($headset != $dados_user['headset']){
			if(strlen($headset) <= 25){
				$update .= mysqli_query($conexao, "UPDATE users SET headset = '$headset' WHERE id = '$id'");
			}else{
				echo "Headset deve possuir até 25 caracteres. ";
			}
		}
		//FIM VERIFICA HEADSET
		//VERIFICA SENSI_HORIZONTAL
		if($sensi_horizontal != $dados_user['sensi_horizontal']){
			if(is_numeric($sensi_horizontal) == true and $sensi_horizontal >= 0 and $sensi_horizontal <= 100){
				$update .= mysqli_query($conexao, "UPDATE users SET sensi_horizontal = '$sensi_horizontal' WHERE id = '$id'");
			}else{
				echo "Sensibilidade Horizontal inválida. ";
			}
		}
		//FIM VERIFICA SENSI_HORIZONTAL
		//VERIFICA SENSI_VERTICAL
		if($sensi_vertical != $dados_user['sensi_vertical']){
			if(is_numeric($sensi_vertical) == true and $sensi_vertical >= 0 and $sensi_vertical <= 100){
				$update .= mysqli_query($conexao, "UPDATE users SET sensi_vertical = '$sensi_vertical' WHERE id = '$id'");
			}else{
				echo "Sensibilidade Vertical inválida. ";
			}
		}
		//FIM VERIFICA SENSI_VERTICAL
		//VERIFICA SENSI_ADS
		if($sensi_ads != $dados_user['sensi_ads']){
			if(is_numeric($sensi_ads) == true and $sensi_ads >= 0 and $sensi_ads <= 100){
				$update .= mysqli_query($conexao, "UPDATE users SET sensi_ads = '$sensi_ads' WHERE id = '$id'");
			}else{
				echo "Sensibilidade ADS inválida. ";
			}
		}
		//FIM VERIFICA SENSI_ADS
		//VERIFICA DPI_MOUSE
		if($dpi_mouse != $dados_user['dpi_mouse']){
			if(is_numeric($dpi_mouse) == true and $dpi_mouse >= 0 and $dpi_mouse <= 15000){
				$update .= mysqli_query($conexao, "UPDATE users SET dpi_mouse = '$dpi_mouse' WHERE id = '$id'");
			}else{
				echo "Mouse DPI inválida. ";
			}
		}
		//FIM VERIFICA DPI_MOUSE
		if($update != ''){
			if($update == true){
				echo "";
			}else{
				echo "Erro ao atualizar. ";
			}
		}
		

		
	}
	
	
	
}else{
	header("Location: apresentation");	
}
?>