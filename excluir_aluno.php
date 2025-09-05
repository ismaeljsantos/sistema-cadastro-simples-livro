<?php
$caminhoArquivo = __DIR__ . "/alunos.json";

// 1. Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Se não for, redireciona com erro de acesso negado
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Acesso inválido."));
    exit;
}

// 2. Pega o ID e converte para um número inteiro
$id_para_excluir = isset($_POST['id']) ? intval($_POST['id']) : null;

if (!$id_para_excluir) {
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("ID do aluno não fornecido."));
    exit;
}

// 3. Carrega os dados do arquivo JSON
$alunos = [];
if (file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
    $dbjson = file_get_contents($caminhoArquivo);
    $alunos = json_decode($dbjson, true) ?: [];
}

// 4. Filtra o array, mantendo apenas os alunos cujo ID é DIFERENTE do ID a ser excluído
$alunos_filtrados = array_filter($alunos, fn($aluno) => $aluno['id'] != $id_para_excluir);

// 5. Re-indexa o array para evitar "buracos" nos índices após a filtragem
$alunos_reindexados = array_values($alunos_filtrados);

// 6. Salva o novo array (sem o aluno excluído) de volta no arquivo
$jsonParaSalvar = json_encode($alunos_reindexados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($caminhoArquivo, $jsonParaSalvar) !== false) {
    // 7. Redireciona de volta para a lista com mensagem de sucesso
    header("Location: listar_alunos.php?status=deleted");
    exit;
} else {
    // Redireciona com mensagem de erro se não conseguir salvar
    header("Location: listar_alunos.php?status=error&mensagem=" . urlencode("Erro ao salvar as alterações no arquivo."));
    exit;
}
?>