<?php 
$mensagem = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $aluno_cadastrado = isset($_GET['nome']) ? htmlspecialchars(urldecode($_GET['nome'])) : 'Um aluno';
        $mensagem = "Sucesso! " . $aluno_cadastrado . " foi cadastrado.";
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
    <title>Cadastro de Aluno</title>
</head>
<style>
    *{ margin: 0; padding: 0; box-sizing: border-box; }
    body {font-family: Arial, sans-serif;background-color: #f4f4f4;}
    .content {max-width: 600px;margin: 50px auto;padding: 20px;background: #fff;border-radius: 5px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);}
    h1 {text-align: center;color: #333;}
    label {display: block;margin: 10px 0 5px;}
    input{margin-top: 5px;margin-bottom: 5px;}
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"] {width: 100%;padding: 10px;border: 1px solid #ccc;border-radius: 4px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);}
    input[type="submit"] {width: 100%; font-weight: bold; font-size: 16px; background: #5cb85c;color: white;border: none;margin: 20px 0;padding: 10px 15px;border-radius: 4px;cursor: pointer;}
    input[type="submit"]:hover {background: #4cae4c;}
    .btn {display: inline-block;padding: 10px 15px;border: none;border-radius: 4px;cursor: pointer;text-decoration: none;}
    .btn-list {background: #007bff;color: white;}
    .btn-list:hover {background: #0056b3;}
    .botoes {text-align: left; margin: 0 auto; background-color: #f4f4f4; box-shadow: none;}
    .success {display: block; width: 100%; padding: 10px; background-color: #45a049; color: #d4edda; border-radius: 4px; margin-top: 20px;}
    .mensagem {display: block;width: 100%;padding: 10px;border-radius: 4px;margin-top: 20px;border: 1px solid transparent;}
    .mensagem.success {background-color: #d4edda; color: #155724; border-color: #c3e6cb;}
    .mensagem.error {background-color: #f8d7da;color: #721c24;border-color: #f5c6cb;}
</style>
<body>
    <div class="content">
        <h1>Cadastro de Aluno</h1>
        <?php if(!empty($mensagem)): 
            $classe_da_mensagem = ($_GET['status'] == 'success') ? 'success' : 'error';
            ?>
            <p class="mensagem <?php echo $classe_da_mensagem; ?>"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <form action="processa_cadastro_aluno.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
            <br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    <div class="content botoes">
            <a class="btn btn-list" href="listar_alunos.php">Listar Alunos</a>
        </div>
    
</body>
<script>
    document.querySelectorAll('.mensagem').forEach(function(element) {
        setTimeout(function() {
            element.style.display = 'none';
        }, 3000);
    });
</script>
</html>