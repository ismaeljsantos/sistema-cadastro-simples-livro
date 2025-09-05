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
        header("Location: editar_livro.php?id=" . $id . "&status=updated");
        exit;
    } else {
        header("Location: editar_livro.php?id=" . $id . "&status=error");
        exit;
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

    $mensagem = "";
    if(isset($_GET['status'])){
        if($_GET['status'] == 'updated'){
            $livro_cadastrado = isset($_GET['titulo']) ? htmlspecialchars(urldecode($_GET['titulo'])) : 'Um livro';
            $mensagem = "Sucesso! " . $livro_cadastrado . " foi atualizado.";
        } else if ($_GET['status'] == 'error') {
            $mensagem_erro = isset($_GET['mensagem']) ? htmlspecialchars(urldecode($_GET['mensagem'])) : 'Ocorreu um erro.';
            $mensagem = "Erro: " . $mensagem_erro;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <style>
        *{ margin: 0; padding: 0; box-sizing: border-box; }
        body {font-family: Arial, sans-serif;margin: 20px;background-color: #f4f4f4;}
        .content {max-width: 600px;margin: 50px auto;padding: 20px;background: #fff;border-radius: 5px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);}
        h1 {color: #333; text-align: center;}
        label {display: block;margin-bottom: 8px;}
        input[type="text"],
        input[type="date"] {width: 100%;padding: 8px;margin-bottom: 12px;border: 1px solid #ccc;border-radius: 4px;}
        button {background-color: #4CAF50;color: white;padding: 10px 15px;border: none;border-radius: 4px;cursor: pointer;}
        button:hover {background-color: #45a049;}
        .mensagem {display: block;width: 100%;padding: 10px;border-radius: 4px;margin: 20px auto 10px;border: 1px solid transparent;}
        .mensagem.updated {background-color: #d4edda; color: #155724; border-color: #c3e6cb;}
        .mensagem.error {background-color: #f8d7da;color: #721c24;border-color: #f5c6cb;}
    </style>
</head>
<body>
    <div class="content">
        <h1>Editar Livro</h1>
        <?php if(!empty($mensagem)):
        $classe_da_mensagem = ($_GET['status'] == 'updated') ? 'updated' : 'error';
        ?>
        <p class="mensagem <?php echo $classe_da_mensagem; ?>"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <form method="POST" action="editar_livro.php">

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
<script>
    document.querySelectorAll('.mensagem').forEach(function(element){
        setTimeout(function(){
            element.style.opacity = '0';
            setTimeout(function(){
                element.style.display = 'none';
            }, 600);
        }, 2000);
    });
</script>
</html>