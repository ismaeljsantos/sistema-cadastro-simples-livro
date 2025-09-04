# Sistema de Cadastro de Livros e Alunos

Este é um sistema simples de cadastro de livros e alunos desenvolvido em PHP, com o objetivo de fins educacionais. Ele não utiliza um banco de dados, mas sim arquivos JSON (`livros.json` e `alunos.json`) para armazenar os dados cadastrados. O sistema permite realizar operações básicas de CRUD (Create, Read, Update, Delete) em um ambiente simulado.

## Funcionalidades

### Cadastro de Livros

1. **Cadastrar Livro**  
   Permite adicionar um novo livro ao sistema, informando os seguintes campos:

   - Título
   - Autor
   - Ano de publicação

2. **Listar Livros**  
   Exibe uma tabela com todos os livros cadastrados, mostrando:

   - ID
   - Título
   - Autor
   - Ano de publicação
   - Ações disponíveis (Editar e Excluir)

3. **Editar Livro**  
   Permite alterar as informações de um livro já cadastrado.

4. **Excluir Livro**  
   Remove um livro do sistema.

### Cadastro de Alunos

1. **Cadastrar Aluno**  
   Permite adicionar um novo aluno ao sistema, informando os seguintes campos:

   - Nome
   - Email
   - Telefone
   - Data de nascimento

2. **Listar Alunos**  
   Exibe uma tabela com todos os alunos cadastrados, mostrando:

   - ID
   - Nome
   - Email
   - Telefone
   - Data de nascimento
   - Ações disponíveis (Editar e Excluir)

3. **Editar Aluno**  
   Permite alterar as informações de um aluno já cadastrado (em desenvolvimento).

4. **Excluir Aluno**  
   Remove um aluno do sistema (em desenvolvimento).

## Estrutura do Sistema

- **`index.php`**  
  Página inicial do sistema, com links para acessar as listas de livros e alunos.

- **Cadastro de Livros**:

  - **`listar_livros.php`**: Exibe todos os livros cadastrados em uma tabela.
  - **`cadastrar_livro.php`**: Formulário para cadastrar um novo livro.
  - **`processar_cadastro.php`**: Processa os dados enviados pelo formulário de cadastro de livros.
  - **`editar_livro.php`**: Formulário para editar as informações de um livro existente.
  - **`excluir_livro.php`**: Processa a exclusão de um livro.
  - **`livros.json`**: Arquivo que armazena os dados dos livros em formato JSON.

- **Cadastro de Alunos**:
  - **`listar_alunos.php`**: Exibe todos os alunos cadastrados em uma tabela.
  - **`cadastrar_aluno.php`**: Formulário para cadastrar um novo aluno.
  - **`processa_aluno.php`**: Processa os dados enviados pelo formulário de cadastro de alunos.
  - **`get_aluno.php`**: Retorna os dados de um aluno específico em formato JSON.
  - **`alunos.json`**: Arquivo que armazena os dados dos alunos em formato JSON.

## Como Funciona

### Cadastro de Livros

1. **Cadastro**: O formulário em `cadastrar_livro.php` envia os dados para `processar_cadastro.php`, que valida e salva os dados no arquivo `livros.json`.
2. **Listagem**: A página `listar_livros.php` lê o arquivo `livros.json` e exibe os dados em uma tabela.
3. **Edição**: A página `editar_livro.php` permite alterar os dados de um livro existente.
4. **Exclusão**: A exclusão é processada em `excluir_livro.php`.

### Cadastro de Alunos

1. **Cadastro**: O formulário em `cadastrar_aluno.php` envia os dados para `processa_aluno.php`, que valida e salva os dados no arquivo `alunos.json`.
2. **Listagem**: A página `listar_alunos.php` lê o arquivo `alunos.json` e exibe os dados em uma tabela.
3. **Edição**: A funcionalidade de edição está em desenvolvimento.
4. **Exclusão**: A funcionalidade de exclusão está em desenvolvimento.

## Observações

- Este sistema é **meramente educacional** e não deve ser utilizado em produção.
- Não há conexão com banco de dados; os dados são armazenados em arquivos JSON.
- Não há autenticação ou controle de acesso.
- O sistema não é seguro contra ataques como injeção de código ou manipulação de dados.

## Requisitos

- Servidor web com suporte a PHP (ex.: XAMPP, WAMP, etc.).
- PHP 7.4 ou superior.

## Como Executar

1. Clone ou copie os arquivos para o diretório do servidor web (ex.: `htdocs` no XAMPP).
2. Certifique-se de que os arquivos `livros.json` e `alunos.json` têm permissão de leitura e escrita.
3. Acesse o sistema pelo navegador, utilizando o endereço:  
   `http://localhost/segundo-projeto/`

## Licença

Este projeto é de uso livre para fins educacionais. Não há garantias de funcionamento ou suporte.
