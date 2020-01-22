<?php

class Pessoa
{
    private $pdo;
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
        }
    }
    //------------------Dados da Tabela no lado direito--------------------
    public function buscarDados()
    {
        try {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {
            echo "Erro ao buscar os dados" . $e->getMessage();
        }
    }
    public function cadastrarPessoa($nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if ($cmd->rowCount() > 0) {
            return false;
        } else {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome,telefone,email)VALUES(:n,:t,:e)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
    }
    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarDados($id, $nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
    }
}
