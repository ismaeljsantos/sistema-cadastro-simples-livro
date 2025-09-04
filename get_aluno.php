<?php
// Define que a resposta será no formato JSON
header('Content-Type: application/json');

$caminhoArquivo = __DIR__ . "/alunos.json";

// Verifica se um ID foi fornecido na URL
if (!isset($_GET['id'])) {
    // Se não, retorna uma mensagem de erro em JSON e encerra o script
    echo json_encode(['error' => 'ID do aluno não foi fornecido.']);
    exit();
}

$id = intval($_GET['id']);
$alunoEncontrado = null;

// Verifica se o arquivo de alunos existe
if (file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
    $dbjson = file_get_contents($caminhoArquivo);
    $alunos = json_decode($dbjson, true);

    // Procura pelo aluno com o ID correspondente
    if (is_array($alunos)) {
        foreach ($alunos as $aluno) {
            if ($aluno['id'] === $id) {
                $alunoEncontrado = $aluno;
                break;
            }
        }
    }
}

// Se o aluno foi encontrado, retorna seus dados em JSON
if ($alunoEncontrado) {
    echo json_encode($alunoEncontrado);
} else {
    // Se não, retorna uma mensagem de erro em JSON
    echo json_encode(['error' => 'Aluno não encontrado.']);
}
?>