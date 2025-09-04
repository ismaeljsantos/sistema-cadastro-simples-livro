<?php
$caminhoArquivo = __DIR__ . "/alunos.json";
$alunos = [];

if(file_exists($caminhoArquivo) && is_readable($caminhoArquivo)){
    $dbjson = file_get_contents($caminhoArquivo);
    $dados_decodificados = json_decode($dbjson, true);
    if(is_array($dados_decodificados)){
        $alunos = $dados_decodificados;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <style>
        body {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding-bottom: 50px;}
        .content {max-width: 1300px; margin: 50px auto 0; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        h1 {text-align: center; color: #333;}
        table {width: 100%; border-collapse: collapse; margin: 20px 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        th, td {padding: 12px 15px; border: 1px solid #ccc; text-align: left;}
        th {background-color: #007bff; color: white;}
        tr:nth-child(even) {background-color: #f2f2f2;}
        td.acoes { text-align: center; }
        .btn {display: inline-block; padding: 10px 15px; color: white; border: none; border-radius: 5px; text-decoration: none; cursor: pointer; text-align: center;}
        .btn:hover {opacity: 0.9;}
        .btn-add { background-color: #007bff; float:right; margin-bottom: 20px; }
        .btn-edit {background-color: #28a745; margin-right: 5px;}
        .btn-delete {background-color: #dc3545;}
        .btn-back {background-color: #6c757d; margin-top: 20px;}
        
        /* Estilos para ambas as modais */
        .modal {display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; padding-top: 100px;}
        .modal-content {background: white; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; position: relative;}
        .modal-content h2 { margin-top: 0; }
        .modal-content p { margin-bottom: 20px; }
        .modal-content .close {cursor: pointer; position: absolute; top: 10px; right: 15px; font-size: 28px; font-weight: bold;}
        .modal-content .close:hover { color: #888; }
        .modal-content label { display: block; margin-top: 10px; }
        .modal-content input { width: 95%; padding: 8px; margin-top: 5px; }
        .modal-content button[type="submit"] { width: 100%; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="content">
        <h1>Lista de Alunos</h1>
        <a class="btn btn-add" href="cadastrar_aluno.php">Cadastrar Novo Aluno</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($alunos)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhum Aluno Cadastrado</td>
                </tr>
            <?php else: ?>
                <?php foreach($alunos as $aluno): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aluno['id']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['telefone']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($aluno['data_nascimento']))); ?></td>
                        <td class="acoes">
                            <a class="btn btn-edit js-edit-btn" href="#" data-id="<?php echo $aluno['id']; ?>">Editar</a>
                            <a class="btn btn-delete js-delete-btn" href="#" data-id="<?php echo htmlspecialchars($aluno['id']); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-back">Voltar para a pagina inicial</a>
    </div>

    <div id="modal-delete" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Tem certeza que deseja excluir este aluno?<br><i>Esta ação não pode ser desfeita.</i></p>
            <form action="excluir_aluno.php" method="POST">
                <input type="hidden" name="id" id="delete-aluno-id" value="">
                <button type="submit" class="btn btn-delete">Sim, Excluir</button>
            </form>
        </div>
    </div>

    <div id="modal-edit" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Aluno</h2>
            <form action="editar_aluno.php" method="POST">
                <input type="hidden" name="id" id="edit-aluno-id" value="">
                
                <label for="edit-nome">Nome:</label>
                <input type="text" name="nome" id="edit-nome" required>
                
                <label for="edit-email">Email:</label>
                <input type="email" name="email" id="edit-email" required>
                
                <label for="edit-telefone">Telefone:</label>
                <input type="text" name="telefone" id="edit-telefone" required>
                
                <label for="edit-data_nascimento">Data de Nascimento:</label>
                <input type="date" name="data_nascimento" id="edit-data_nascimento" required>
                
                <button type="submit" class="btn btn-edit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        // Seleciona as duas modais
        const modalEdit = document.getElementById('modal-edit');
        const modalDelete = document.getElementById('modal-delete');

        // --- LÓGICA PARA ABRIR AS MODAIS ---

        // Adiciona evento para todos os botões de EDITAR
        document.querySelectorAll('.js-edit-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const alunoId = this.getAttribute('data-id');

                // Preenche o ID no formulário da modal de edição
                modalEdit.querySelector('#edit-aluno-id').value = alunoId;

                // Busca os dados do aluno para preencher o formulário
                // (Certifique-se de que você tem um arquivo get_aluno.php que retorna os dados em JSON)
                fetch(`get_aluno.php?id=${alunoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }
                        // Preenche os campos do formulário com os dados recebidos
                        modalEdit.querySelector('#edit-nome').value = data.nome;
                        modalEdit.querySelector('#edit-email').value = data.email;
                        modalEdit.querySelector('#edit-telefone').value = data.telefone;
                        modalEdit.querySelector('#edit-data_nascimento').value = data.data_nascimento;
                        
                        // Exibe a modal de edição
                        modalEdit.style.display = 'block';
                    })
                    .catch(error => console.error('Erro ao buscar dados do aluno:', error));
            });
        });

        // Adiciona evento para todos os botões de EXCLUIR
        document.querySelectorAll('.js-delete-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const alunoId = this.getAttribute('data-id');
                // Preenche o ID no formulário da modal de exclusão
                modalDelete.querySelector('#delete-aluno-id').value = alunoId;
                // Exibe a modal de exclusão
                modalDelete.style.display = 'block';
            });
        });

        // --- LÓGICA UNIFICADA PARA FECHAR AS MODAIS ---

        // Adiciona evento para TODOS os botões de fechar (ícone '×')
        document.querySelectorAll('.close').forEach(button => {
            button.addEventListener('click', function() {
                // Encontra a modal pai mais próxima e a esconde
                this.closest('.modal').style.display = 'none';
            });
        });

        // Adiciona um único evento de clique na janela para fechar a modal ao clicar fora dela
        window.onclick = function(event) {
            if (event.target == modalEdit) {
                modalEdit.style.display = "none";
            }
            if (event.target == modalDelete) {
                modalDelete.style.display = "none";
            }
        }
    </script>
</body>
</html>