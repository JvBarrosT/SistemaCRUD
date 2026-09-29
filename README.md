CRUD Estrutura ITI

Projeto desenvolvido como parte de um desafio técnico para criar um sistema CRUD inspirado na estrutura do site do ITI.

O sistema permite cadastrar e gerenciar:

Autoridades Certificadoras (AC)
Autoridades Certificadoras Nível 2 (AC N2)
Autoridades de Registro (AR)

Também possui autenticação de usuários, importação da estrutura através de um arquivo JSON e geração de QRCode para os registros.

Tecnologias utilizadas
PHP 8.4
Laravel 13
Eloquent ORM
SQLite (ambiente de desenvolvimento)
MySQL (compatível)
Laravel Breeze
Tailwind CSS
Composer
chillerlan/php-qrcode
Como rodar o projeto

Depois de clonar o projeto, entre na pasta e instale as dependências:

composer install

Copie o arquivo de configuração:

cp .env.example .env

Gere a chave da aplicação:

php artisan key:generate
Banco de dados

O projeto está configurado inicialmente para utilizar SQLite, facilitando a execução no ambiente de desenvolvimento.

Crie o arquivo do banco:

touch database/database.sqlite

Depois execute as migrations:

php artisan migrate

Instale as dependências do frontend e faça o build:

npm install
npm run build

Por fim, inicie o servidor:

php artisan serve

A aplicação estará disponível em:

http://localhost:8000

Após acessar o sistema, é possível criar um usuário pela tela de cadastro.

Principais funcionalidades
Autenticação

O sistema possui login e cadastro de usuários. As áreas de gerenciamento ficam disponíveis somente para usuários autenticados.

CRUD de AC

Permite:

Listar ACs
Cadastrar uma nova AC
Editar uma AC
Excluir uma AC
Gerar QRCode
CRUD de AC N2

As ACs N2 possuem relacionamento com uma AC principal.

Permite:

Listar ACs N2
Cadastrar uma AC N2
Selecionar a AC relacionada
Editar
Excluir
Gerar QRCode
CRUD de AR

As Autoridades de Registro possuem relacionamento com uma AC N2.

Permite:

Listar ARs
Cadastrar uma AR
Selecionar a AC N2 relacionada
Editar
Excluir
Gerar QRCode
Importação do JSON

O sistema permite importar a estrutura do site do ITI através de um arquivo .json.

A estrutura do arquivo segue uma hierarquia:

AC Raiz
└── AC 1º Nível
    └── AC 2º Nível
        ├── AR
        ├── AR
        └── AR

O sistema lê essa estrutura e cria os registros correspondentes no banco de dados, mantendo os relacionamentos entre AC, AC N2 e AR.

A importação pode ser feita pela opção:

/import

O sistema também apresenta um resumo da importação realizada.

QRCode

Cada registro possui a opção Gerar QRCode.

Ao clicar no botão, é aberto um modal contendo o QRCode e o link correspondente ao registro.

A geração dos códigos é feita utilizando a biblioteca:

chillerlan/php-qrcode
Principais rotas
Rota	Função
/login	Login
/register	Cadastro de usuário
/acs	CRUD de AC
/n2s	CRUD de AC N2
/ars	CRUD de AR
/import	Importação do JSON
Estrutura do banco

Os principais relacionamentos utilizados no projeto são:

AC
│
└── AC N2
     │
     └── AR

Ou seja:

Uma AC pode possuir várias ACs N2.
Uma AC N2 pertence a uma AC.
Uma AC N2 pode possuir várias ARs.
Uma AR pertence a uma AC N2.
Banco de dados

Durante o desenvolvimento, o projeto utiliza SQLite para facilitar a execução no GitHub Codespaces.

A aplicação também foi desenvolvida utilizando recursos compatíveis com MySQL. Para utilizar MySQL, basta configurar as variáveis de banco no arquivo .env.

Exemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud
DB_USERNAME=root
DB_PASSWORD=

Depois, basta executar:

php artisan migrate

Não é necessário alterar a lógica da aplicação para fazer essa troca.

Estrutura principal do projeto

Algumas das pastas mais importantes são:

app/
├── Http/
│   └── Controllers/
└── Models/

database/
└── migrations/

resources/
└── views/

routes/
└── web.php

Os Models representam as entidades do sistema, os Controllers concentram as regras das requisições e as Views são responsáveis pelas telas da aplicação.

Projeto

Este projeto foi desenvolvido utilizando Laravel, buscando manter uma estrutura simples e organizada, com foco nos requisitos do desafio e na facilidade de manutenção.
