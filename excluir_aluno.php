<?php 
$caminhoArquivo = __DIR__ . "/alunos.json";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pega o ID e converte para um número inteiro
    $id_para_excluir = isset($_POST['id']) ? intval($_POST['id']) : null;

    if ($id_para_excluir) {
        $alunos = [];
        if (file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
            $dbjson = file_get_contents($caminhoArquivo);
            $alunos = json_decode($dbjson, true) ?: [];
        }

        // Filtra o array, mantendo apenas os alunos cujo ID é DIFERENTE do ID a ser excluído
        $alunos_filtrados = array_filter($alunos, fn($aluno) => $aluno['id'] != $id_para_excluir);

        // Re-indexa o array para evitar buracos nos índices (ex: [0 => ..., 2 => ...])
        $alunos_reindexados = array_values($alunos_filtrados);
        
        // Salva o novo array (sem o aluno excluído) de volta no arquivo
        $jsonParaSalvar = json_encode($alunos_reindexados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($caminhoArquivo, $jsonParaSalvar);
        
        // Redireciona de volta para a lista
        header("Location: listar_alunos.php?status=deleted");
        exit;
    }
}

// Se o acesso não for POST ou se o ID não for fornecido, mostra erro.
echo "Acesso inválido ou ID não fornecido.";
http_response_code(400);
exit;
?>