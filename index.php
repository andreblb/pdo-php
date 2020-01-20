<?php
require_once 'Pessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php
    if (isset($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            if (!$p->cadastrarPessoa($nome, $telefone, $email)) {
                echo "Conta de email já cadastrado";
            }
        } else {
            echo "Preencha todos os campos";
        }
    }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoas</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" />
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" />
            <label for="email">Email</label>
            <input type="text" name="email" id="email" />
            <input type="submit" value="Cadastrar">
        </form>
    </section>


    <section id="direita">
        <table>
            <tr id="titulo">
                <th>Nome</th>
                <th>Telefone</th>
                <th colspan="2">Email</th>
            </tr>
            <?php
            $dados = $p->buscarDados();
            if (count($dados) > 0) {
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if ($k != "id") {
                            echo "<td>" . $v . "</td>";
                        }
                        # code...
                    }
            ?>
                    <td><a href="">Editar</a><a href="">Excluir</a></td>
            <?php
                    echo "</tr>";
                }
            } else {
                echo "existe pessoas cadastradas";
            }
            ?>
        </table>

    </section>



</body>

</html>