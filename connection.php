<?php
$hash = 'Pr4k2wq^iJrNAaDqvK39)&HnKxmzCI$';
date_default_timezone_set("America/Sao_Paulo");
$conexao  = mysqli_connect("localhost","root","","r6club");
$utf      = mysqli_query($conexao,"SET NAMES 'utf8'");
$utf     .= mysqli_query($conexao,'SET character_set_connection=utf8');
$utf     .= mysqli_query($conexao,'SET character_set_client=utf8');
$utf     .= mysqli_query($conexao,'SET character_set_results=utf8');

?>