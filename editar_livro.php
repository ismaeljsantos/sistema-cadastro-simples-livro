<?php
$caminhoArquivo = __DIR__ . "/livros.json";
$livro = null;
$id = null;

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
} else if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

if ($id === null) {
    die("ID não fornecido.");
}

$livros = json_decode(file_get_contents($caminhoArquivo), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $ano = trim($_POST['ano']);

    foreach ($livros as &$l) {
        if ($l['id'] === $id) {
            $l['titulo'] = $titulo;
            $l['autor'] = $autor;
            $l['ano'] = $ano;
            break; 
        }
    }
    
    unset($l);

    $jsonParaSalvar = json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if(file_put_contents($caminhoArquivo, $jsonParaSalvar) !== false) {
        header("Location: listar_livros.php?status=updated");
        exit;
    } else {
        die("Erro ao salvar o arquivo.");
    }
}

foreach ($livros as $l) {
    if ($l['id'] === $id) {
        $livro = $l;
        break;
    }
}

if ($livro === null) {
    die("Livro não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <style>
        body {font-family: Arial, sans-serif;margin: 20px;}
        .content {max-width: 600px;margin: auto;}
        h1 {color: #333; text-align: center;}
        form {max-width: 400px;margin: 0 auto;}
        label {display: block;margin-bottom: 8px;}
        input[type="text"],
        input[type="date"] {width: 100%;padding: 8px;margin-bottom: 12px;border: 1px solid #ccc;border-radius: 4px;}
        button {background-color: #4CAF50;color: white;padding: 10px 15px;border: none;border-radius: 4px;cursor: pointer;}
        button:hover {background-color: #45a049;}
    </style>
</head>
<body>
    <div class="content">
        <h1>Editar Livro</h1>
        <form method="POST" action="editar_livro_gemini.php">
            

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
            <br>
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
            <br>
            <label for="ano">Ano de Publicação:</label>
            <input type="date" id="ano" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>
            <br>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>