<?php

include('conexao/conexao.php');

$db = new Conexao();

class Usuario{
    private $conn;
    private $table_name="usuarios";
    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($nome, $email, $senha, $confSenha)
    {
        if($senha == $confSenha){
            
            $nomeExistente = $this->verificacaoNomeExistente($nome);
            $emailExistente = $this->verificacaoEmailExistente($email);
            
            if(($nomeExistente) && ($emailExistente)){
                print "<script>alert('Usuário já cadastrado')</script>";
                return false;
            }

            

        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindValue(1, $nome);
        $stmt -> bindValue(2, $email);
        $stmt -> bindValue(3, $senhaCriptografada);
        $result = $stmt -> execute();

        return $result;

        }else{
            return false;
        }
    }


    private function verificacaoNomeExistente($nome){
        $sql = "SELECT COUNT(*) from usuario WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$nome);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    } 

    private function verificacaoEmailExistente($email){
        $sql = "SELECT COUNT(*) from usuario WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    } 

    public function logar($nome, $senha){
        $sql = "SELECT * FROM usuario WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();

    if($stmt->rowCount() == 1){
        $usuario= $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($senha,$usuario['senha'])){
            return true;
        }
    }
    }
}


?>