# Sistema de Cadastro de Livros

Este é um sistema simples de cadastro de livros desenvolvido em PHP, com o objetivo de fins educacionais. Ele não utiliza um banco de dados, mas sim um arquivo JSON (`livros.json`) para armazenar os dados dos livros cadastrados. O sistema permite realizar operações básicas de CRUD (Create, Read, Update, Delete) em um ambiente simulado.

## Funcionalidades

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

## Estrutura do Sistema

- **`index.php`**  
  Página inicial do sistema, com um link para acessar a lista de livros.

- **`listar_livros.php`**  
  Exibe todos os livros cadastrados em uma tabela. Permite acessar as opções de edição e exclusão.

- **`cadastrar_livro.php`**  
  Formulário para cadastrar um novo livro. Após o cadastro, o sistema redireciona para esta página com uma mensagem de sucesso ou erro.

- **`processar_cadastro.php`**  
  Processa os dados enviados pelo formulário de cadastro e salva o novo livro no arquivo `livros.json`.

- **`editar_livro.php`**  
  Formulário para editar as informações de um livro existente. Os dados são carregados com base no ID do livro.

- **`excluir_livro.php`**  
  Processa a exclusão de um livro com base no ID fornecido.

- **`livros.json`**  
  Arquivo que armazena os dados dos livros em formato JSON. Este arquivo simula um banco de dados.

## Como Funciona

1. **Cadastro de Livro**

   - O formulário em `cadastrar_livro.php` envia os dados para `processar_cadastro.php`.
   - O sistema valida os campos e adiciona o novo livro ao arquivo `livros.json`.

2. **Listagem de Livros**

   - A página `listar_livros.php` lê o arquivo `livros.json` e exibe os dados em uma tabela.

3. **Edição de Livro**

   - A página `editar_livro.php` carrega os dados do livro com base no ID e permite alterá-los.
   - Após a edição, os dados são atualizados no arquivo `livros.json`.

4. **Exclusão de Livro**
   - A exclusão é processada em `excluir_livro.php`, removendo o livro do arquivo `livros.json`.

## Observações

- Este sistema é **meramente educacional** e não deve ser utilizado em produção.
- Não há conexão com banco de dados; os dados são armazenados em um arquivo JSON.
- Não há autenticação ou controle de acesso.
- O sistema não é seguro contra ataques como injeção de código ou manipulação de dados.

## Requisitos

- Servidor web com suporte a PHP (ex.: XAMPP, WAMP, etc.).
- PHP 7.4 ou superior.

## Como Executar

1. Clone ou copie os arquivos para o diretório do servidor web (ex.: `htdocs` no XAMPP).
2. Certifique-se de que o arquivo `livros.json` tem permissão de leitura e escrita.
3. Acesse o sistema pelo navegador, utilizando o endereço:  
   `http://localhost/segundo-projeto/`

## Licença

Este projeto é de uso livre para
