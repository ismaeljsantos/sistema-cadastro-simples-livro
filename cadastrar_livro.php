<?php
$mensagem = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $titulo_cadastrado = isset($_GET['titulo']) ? htmlspecialchars(urldecode($_GET['titulo'])) : 'Um livro';
        $mensagem = "Sucesso! " . $titulo_cadastrado . " foi cadastrado.";
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
    <title>Cadastro de Livro</title>
</head>
<style>
    body {font-family: Arial, sans-serif;margin: 20px;}
    .container {max-width: 500px;margin: auto;}
    h1 { color: #333; }
    form {margin-top: 20px;}
    label {display: block;margin-bottom: 5px;}
    input[type="text"],
    input[type="date"] {width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] {background-color: #4CAF50;color: white;padding: 10px 15px;border: none;border-radius: 4px;cursor: pointer;}
    input[type="submit"]:hover {background-color: #45a049;}
    .btn {display: inline-block;margin-top: 20px;padding: 10px 15px;background-color: #007BFF;color: #fff;border-radius: 5px;text-decoration: none;}
    .btn:hover {background-color: #0056b3;}
    .success {display: block; width: 100%; padding: 10px; background-color: #45a049; color: #d4edda; border-radius: 4px; margin-top: 20px;}
</style>
<body>
    <div class="container">
    <h1>Cadastrar Novo Livro</h1>
    <a href="listar_livros.php" class="btn">Voltar para a lista de livros</a>
    <?php if (!empty($mensagem)): ?>
        <p class="success"><?php echo $mensagem; ?></p>
    <?php endif; ?>
        <form action="processar_cadastro.php" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>

            <label for="ano">Ano:</label>
            <input type="date" id="ano" name="ano" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
</body>
<script>
    document.querySelectorAll('.success').forEach(function(element) {
        setTimeout(function() {
            element.style.display = 'none';
        }, 3000);
    });
</script>
</html>