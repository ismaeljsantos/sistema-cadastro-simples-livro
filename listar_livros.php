<?php
    $caminhoArquivo = __DIR__ . "/livros.json";
    $livros = [];
    $mensagem = "";

    if(file_exists($caminhoArquivo) && is_readable($caminhoArquivo)) {
        $dbjson = file_get_contents($caminhoArquivo);
        $dados_decodificados = json_decode($dbjson, true);
        if(is_array($dados_decodificados)){
            $livros = $dados_decodificados;
        }
    } 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <style>
        body {font-family: Arial, sans-serif;margin: 20px;}
        h1 { color: #333; }
        table {width: 100%;border-collapse: collapse;margin-top: 20px; margin-bottom: 20px;}
        th, td {border: 1px solid #ccc;padding: 10px;text-align: left;}
        th {background-color: #f4f4f4;}
        .acoes {text-align: center; display: flex; justify-content: space-around; align-items: center;}
        a {text-decoration: none;color: #007BFF;}
        a:hover {text-decoration: underline;}
         button { border: none; cursor: pointer; }
        .btn {display: inline-block;padding: 10px 15px;background-color: #007BFF;color: #fff;border-radius: 5px; cursor: pointer;}
        .btn:hover {background-color: #0056b3;}
        .btn-edit {background-color: #28a745; }
        .btn-edit:hover {background-color: #218838; text-decoration: none;}
        .btn-delete {background-color: #dc3545; color: #fff; padding: 12px 15px; border-radius: 4px;}
        .btn-delete:hover {background-color: #c82333; text-decoration: none;}
        .btn-back {background-color: #6c757d;}
        .modal-delete { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 300px; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
        .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }

    </style>
</head>
<body>
    <h1>Livros cadastrados</h1>
    <a class="btn" href="cadastrar_livro.php">Cadastrar Novo Livro</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(empty($livros)){
            ?>
                <tr>
                    <td colspan="5">Nenhum livro cadastrado.</td>
                </tr>
            <?php } else {  foreach($livros as $livro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($livro['id']); ?></td>
                    <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($livro['ano']))); ?></td>
                    <td class="acoes">
                        <a class="btn btn-edit" href="editar_livro_gemini.php?id=<?php echo htmlspecialchars($livro['id']); ?>">Editar</a>
                        <a id="delete" class="btn btn-delete" data-id="<?php echo htmlspecialchars($livro['id']); ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach;} ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-back">Voltar para o início</a>
    <div class="modal-delete">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Tem certeza que deseja excluir este livro?</p>
            <form action="excluir_livro.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
                <button type="submit" class="btn btn-delete">Excluir</button>
            </form>
        </div>
    </div>
</body>
<script>
    document.querySelectorAll('#delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const modal = document.querySelector('.modal-delete');
            const form = this.closest('form');
            modal.style.display = 'block';
            modal.querySelector('form input[name="id"]').value = form.querySelector('input[name="id"]').value;
        });
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.querySelector('.modal-delete').style.display = 'none';
    });

    window.onclick = function(event) {
        const modal = document.querySelector('.modal-delete');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</html>