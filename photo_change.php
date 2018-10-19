<?php
session_name(md5("www.r6club.com.br"));
session_start();
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_FILES['img']) and !empty($_FILES['img']['name'])){
	require('connection.php');
	$id = $_SESSION['login_id'];
	$extensoespermitidas = array('png','jpg','jpeg');
	$busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
	if(mysqli_num_rows($busca_dados_user) == 1){
 
    $arquivo_tmp = $_FILES[ 'img' ][ 'tmp_name' ];
    $nome = $_FILES[ 'img' ][ 'name' ];
    list($largura, $altura) = getimagesize($arquivo_tmp);
    // Pega a extensão
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
 
    // Converte a extensão para minúsculo
    $extensao = strtolower ( $extensao );
 
    // Somente imagens, .jpg; .jpeg; .gif; .png
    // Aqui eu enfileiro as extensões permitidas e separo por ';'
    // Isso serve apenas para eu poder pesquisar dentro desta String
        if (in_array($extensao, $extensoespermitidas) == TRUE) {
            if($largura != "" and $altura != ""){
                if($_FILES['img']['size'] <= 450000){
                    $novoNome = uniqid (rand(), true). '.' . $extensao;
                    // Concatena a pasta com o nome
                    $destino = 'uploads/' . $novoNome;
                    $destino_sql = '/uploads/' . $novoNome;
                    // tenta mover o arquivo para o destino
                    if (@move_uploaded_file ( $arquivo_tmp, $destino )) {
                        $update_img_perfil = mysqli_query($conexao, "UPDATE users SET img_perfil = '$destino_sql' WHERE id = '$id'");
                        if($update_img_perfil == true){
                            $return = array(
                                'status' => 'success',
                                'img' => '/uploads/'.$novoNome,
                            );
                            echo json_encode($return);
                        }
                       
                    } else {
                        echo '{"status":"error"}';
                    }

                }else{
                    echo '{"status":"size"}';
                }
            }else{
                 echo '{"status":"invalid"}';
            }
        }else{
            echo '{"status":"format"}';
        }

}
	
}elseif(isset($_SESSION['login_id']) and !empty($_SESSION['login_id']) and isset($_POST['img'])){
    require('connection.php');
    $id = $_SESSION['login_id'];
    $img_url = $_POST['img'];
    $busca_dados_user = mysqli_query($conexao,"SELECT * FROM users WHERE id = '$id'");
    if(mysqli_num_rows($busca_dados_user) == 1){
        $update_img_perfil = mysqli_query($conexao, "UPDATE users SET img_perfil = '$img_url' WHERE id = '$id'");
        if($update_img_perfil == true){
            echo "success";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
}else{
    echo "Erro [003] - Faltam dados";
}
?>