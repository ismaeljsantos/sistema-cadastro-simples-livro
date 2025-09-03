<?php
$caminhoArquivo = __DIR__ . "/livros.json";
if($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: cadastrar_livro.php");
    exit();
} else {

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    if(empty($titulo) || empty($autor) || empty($ano)) {
        $mensagem_erro = urlencode("Todos os campos são obrigatórios.");
        header("Location: cadastrar_livro.php?status=error&mensagem=". $mensagem_erro);
        exit();
    }
    if(file_exists($caminhoArquivo)) {
        $livros = json_decode(file_get_contents($caminhoArquivo), true);
    } else {
        $livros = array();
    }

    $proximoId = count($livros) > 0 ? max(array_column($livros, 'id')) + 1 : 1;

    $novoLivro = array(
        "id" => $proximoId,
        "titulo" => $titulo,
        "autor" => $autor,
        "ano" => $ano
    );

    $livros[] = $novoLivro;
    $jsonParaSalvar = json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if(file_put_contents($caminhoArquivo, $jsonParaSalvar) !== false) {
        header("Location: cadastrar_livro.php?status=success&titulo=".urlencode($titulo));
        exit();
    } else {
        $mensagem_erro = urlencode("Erro: Não foi possivel cadastrar o livro.");
        header("Location: cadastrar_livro.php?status=error&mensagem=". $mensagem_erro);
        exit();
    }
}