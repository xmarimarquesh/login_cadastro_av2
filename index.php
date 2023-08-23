<?php
session_start();
require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$usuario = new Usuario($db);

if(isset($_POST['logar'])){
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if($usuario->logar($nome,$senha)){
        $_SESSION['nome']=$nome;

        header("Location: dashboard.php");
        exit();
    }else{
        print "<script>alert('Credenciais inválidas')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@10..48,300&family=Josefin+Slab&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
        <title>Login</title>
</head>

<body>
    <form action="" method="POST">
        <H1>Login</H1><br>
        <label for="Nome">Nome</label><input type="text" name="nome" placeholder="Digite seu nome..." required>
        <label for="Senha">Senha</label><input type="password" name="senha" placeholder="Digite sua senha..." required>

        <button type="submit" name="logar">Logar</button><br>
        <a href="cadastrar.php">Não tem uma conta? Cadastre-se!</a>
    </form>
    
</body>
</html>