<?php 
$caminhoArquivo = __DIR__ . "/alunos.json";
$mensagem = "";
$operacao = false;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    if(empty($nome) || empty($email) || empty($telefone) || empty($data_nascimento)) {
        $mensagem = "Erro: Todos os campos são obrigatórios.";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Erro: Formato do Email inválido.";
    } else {
        $dbjson = file_exists($caminhoArquivo) ? file_get_contents($caminhoArquivo) : false;
        $alunos = $dbjson ? json_decode($dbjson, true) : [];
        if(!is_array($alunos)){
            $alunos = [];
        }
        $email_existe = false;
        foreach($alunos as $aluno){
            if(strtolower($aluno['email']) === strtolower($email)){
                $email_existe = true;
                break;
            }
        }
        if($email_existe){
            $mensagem = "Erro: O email ('". $email . "') não pode ser cadastrado.";
        } else {
            $novo_cliente = [
                'id' => count($alunos) > 0 ? max(array_column($aluno, 'id')) + 1 : 1,
                'nome' => trim($nome),
                'email' => trim($email),
                'telefone' => trim($telefone),
                'data_nascimento' => trim($data_nascimento)
            ];
            $alunos[] = $novo_cliente;

            $json_data = json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if(file_put_contents($caminhoArquivo, $json_data) !== false){
                $mensagem = "Aluno cadastrado com sucesso!";
                $operacao = true;
            } else {
                $mensagem = "Erro crítico: Não foi possível salvar os dados.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Cadastro de Alunos</title>
    <style>
        body {font-family: Arial, sans-serif;background-color: #f4f4f4;margin: 0;padding: 20px;}
        .content {background-color: #fff;padding: 20px;border-radius: 5px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);}
        h1 {color: #333;}
        p {color: #666;}
    </style>
</head>

<body>
    <div class="content">
        <h1>Status de  Operações</h1>
        <?php if(!empty($mensagem)): ?>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; 
            if($operacao):
        ?>
        <h1>Cadastro do aluno</h1>
        <p>Nome: <?php echo htmlspecialchars($nome); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($telefone); ?></p>
        <p>Data de Nascimento: <?php echo htmlspecialchars($data_nascimento); ?></p>
        <?php echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=listar_alunos.php'>";
        else: ?>
        <h1>Cadastro não realizado</h1>
        <p>Por favor, verifique os dados e tente novamente.</p>
        <a href="cadastrar_aluno.php">Voltar ao formulário de cadastro</a>
        <?php endif; ?>
    </div>
</body>
</html>