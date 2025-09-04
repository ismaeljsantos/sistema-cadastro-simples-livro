<?php
// Processa o cadastro do aluno
$caminhoArquivo = __DIR__ . "/alunos.json";
if($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: cadastrar_aluno.php");
    exit();
} else {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    if(empty($nome) || empty($email) || empty($telefone) || empty($data_nascimento)) {
        $mensagem_erro = urlencode("Todos os campos são obrigatórios.");
        header("Location: cadastrar_aluno.php?status=error&mensagem=". $mensagem_erro);
        exit();
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem_erro = urlencode("Formato do Email inválido.");
        header("Location: cadastrar_aluno.php?status=error&mensagem=". $mensagem_erro);
        exit();
    }
    if(file_exists($caminhoArquivo)) {
        $alunos = json_decode(file_get_contents($caminhoArquivo), true);
    } else {
        $alunos = [];
    }

    $proximoId = count($alunos) > 0 ? max(array_column($alunos, 'id')) + 1 : 1;
    $novoAluno = [
        "id" => $proximoId,
        "nome" => $nome,
        "email" => $email,
        "telefone" => $telefone,
        "data_nascimento" => $data_nascimento
    ];

    $alunos[] = $novoAluno;
    $jsonParaSalvar = json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if(file_put_contents($caminhoArquivo, $jsonParaSalvar) !== false){
        header("Location: cadastrar_aluno.php?status=success&nome=".urlencode($nome));
        exit();
    } else {
        $mensagem_erro = urlencode("Erro: Não foi possivel cadastrar o aluno.");
        header("Location: cadastrar_aluno.php?status=error&mensagem=". $mensagem_erro);
        exit();
    }
}