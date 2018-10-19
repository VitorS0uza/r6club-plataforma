<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['id']) and is_numeric($_POST['id']) == true){
	require('connection.php');
	$id = $_POST['id'];
					$busca_lobby = mysqli_query($conexao, "SELECT * FROM lobby WHERE finalizado = '1' AND cancelado = '0' AND FIND_IN_SET ($id,time_azul) OR finalizado = '1' AND cancelado = '0' AND FIND_IN_SET ($id,time_laranja) ORDER BY tempo_inicio DESC LIMIT 50");
					if(mysqli_num_rows($busca_lobby) > 0){

							$maps = array(
                                'arranhaceu'=> 'Arranha Céu',
                                'aviao'=> 'Avião Presidencial',
                                'banco'=> 'Banco',
                                'canal'=> 'Canal',
                                'chale'=> 'Chalé',
                                'clubhouse'=> 'Casa de Campo',
                                'consulado'=> 'Consulado',
                                'favela'=> 'Favela',
                                'fronteira'=> 'Fronteira',
                                'hereford'=> 'Base Hereford',
                                'iate'=> 'Iate',
                                'kafe'=> 'Kafe Dostoyevsky',
                                'litoral'=> 'Litoral',
                                'oregon'=> 'Oregon',
                                'residencia'=> 'Residência',
                                'park'=> 'Parque Temático',
                                'torre'=> 'Torre',
                                'bartlett'=> 'U. Bartlett',
                                'villa'=> 'Villa'
                            );
							$matchs = array("status" => 'Success', "matchs" => mysqli_num_rows($busca_lobby));
                            while($dados = mysqli_fetch_array($busca_lobby)){
								$img_map = "/img/maps/".$dados['mapa'].".jpg";
								$gamemode = ($dados['type'] == 'rankedopen') ? 'RANKED OPEN' : '4FUN';
								$mapa = $maps[$dados['mapa']];
								$tempo_final = date("H:i:s d/m/Y", strtotime($dados['tempo_final']));
									if($dados['placar'] === 0){
										$placar = array('0','0');
									}else{
										$placar = explode('x',$dados['placar']);
									}
									$duracao = round((strtotime($dados['tempo_final']) - strtotime($dados['tempo_inicio']))/60)." min";
								$return = array(
									'mapa' => $mapa,
									'img_map' => $img_map,
									'placar_azul' => $placar[0],
									'placar_laranja' => $placar[1],
									'gamemode' => $gamemode,
									'tempo_inicio' => date("H:i:s d/m/Y", strtotime($dados['tempo_inicio'])),
									'tempo_final' => $tempo_final,
									'duracao' => $duracao
								);
								array_push($matchs, $return);
							}
							echo json_encode($matchs);
                    }else{
                    	echo json_encode(array('status' =>"Erro1"));
                    }
                
}else{
	echo json_encode(array("Erro"=>"Faltam dados para sua solicitação"));
}
				
?>