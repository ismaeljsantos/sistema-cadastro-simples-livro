<?php
$caminhoArquivo = __DIR__ . "/alunos.json";

// 1. Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Acesso inválido."));
    exit;
}

// 2. Recebe e valida os dados do formulário
$id_para_editar = isset($_POST['id']) ? intval($_POST['id']) : null;
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
$data_nascimento = isset($_POST['data_nascimento']) ? trim($_POST['data_nascimento']) : '';

if (!$id_para_editar || empty($nome) || empty($email) || empty($telefone) || empty($data_nascimento)) {
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Todos os campos são obrigatórios para edição."));
    exit;
}

// 3. Carrega os dados do arquivo JSON
$alunos = [];
if (file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
    $dbjson = file_get_contents($caminhoArquivo);
    $alunos = json_decode($dbjson, true) ?: [];
}

// 4. Encontra o aluno e atualiza os dados usando uma referência (&)
$aluno_encontrado = false;
foreach ($alunos as &$aluno) { // O '&' permite modificar o array original
    if ($aluno['id'] === $id_para_editar) {
        $aluno['nome'] = $nome;
        $aluno['email'] = $email;
        $aluno['telefone'] = $telefone;
        $aluno['data_nascimento'] = $data_nascimento;
        $aluno_encontrado = true;
        break; // Para o loop assim que encontrar e atualizar
    }
}
unset($aluno); // Remove a referência por segurança

// Se o aluno não foi encontrado, redireciona com erro
if (!$aluno_encontrado) {
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Aluno com o ID fornecido não foi encontrado."));
    exit;
}

// 5. Salva o array modificado de volta no arquivo
$jsonParaSalvar = json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($caminhoArquivo, $jsonParaSalvar) !== false) {
    // 6. Redireciona de volta para a lista com mensagem de sucesso
    header("Location: listar_alunos.php?status=updated");
    exit;
} else {
    // Redireciona com mensagem de erro se não conseguir salvar
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Erro ao salvar as alterações no arquivo."));
    exit;
}
?>