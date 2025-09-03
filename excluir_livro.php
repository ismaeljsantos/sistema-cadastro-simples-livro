<?php
    $caminhoArquivo = __DIR__ . "/livros.json";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"] ?? null;
        if($id) {
            $livros = [];
            if(file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
                $dbjson = file_get_contents($caminhoArquivo);
                $dados_decodificados = json_decode($dbjson, true);
                if(is_array($dados_decodificados)){
                    $livros = $dados_decodificados;
                }
            }
            $livros = array_filter($livros, fn($livro) => $livro['id'] != $id);
            file_put_contents($caminhoArquivo, json_encode($livros));
            header("Location: listar_livros.php");
            exit;
        }
    } else {
        echo "Acesso negado.";
        http_response_code(405);
        exit;
    }