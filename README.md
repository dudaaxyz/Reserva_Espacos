# 🏢 Reserva de Espaços

Sistema web desenvolvido para gerenciamento e reserva de salas, laboratórios e ambientes compartilhados, permitindo que usuários realizem agendamentos de forma rápida, organizada e segura.

---

##  Sobre o Projeto

O **Reserva de Espaços** foi desenvolvido com o objetivo de facilitar o controle de reservas de ambientes compartilhados, permitindo que usuários consultem a disponibilidade dos espaços e realizem agendamentos de forma eficiente.

O sistema possui controle de acesso por usuários e administradores, garantindo maior organização e gerenciamento das reservas.

---

##  Tecnologias Utilizadas

* PHP 8.3+
* Laravel 12
* PostgreSQL
* HTML5
* CSS3
* Tailwind CSS
* JavaScript
* Vite
* Composer
* Node.js
* Git

---

##  Funcionalidades

###  Usuários

* Cadastro e autenticação de usuários.
* Login seguro.
* Visualização das próprias reservas.
* Consulta de espaços disponíveis.

###  Reservas

* Criação de reservas.
* Cancelamento de reservas.
* Consulta de disponibilidade.
* Visualização de reservas realizadas.

###  Espaços

* Listagem de salas e ambientes.
* Informações detalhadas dos espaços.
* Controle de disponibilidade por data e horário.

###  Administração

* Gerenciamento de usuários.
* Gerenciamento de espaços.
* Visualização de todas as reservas.
* Controle de permissões administrativas.

###  Sistema

* Interface responsiva.
* Validação de formulários.
* Integração com PostgreSQL.
* Arquitetura MVC utilizando Laravel.

---

##  Pré-requisitos

Antes de executar o projeto, certifique-se de possuir os seguintes softwares instalados:

* PHP 8.3 ou superior
* Composer
* Node.js
* NPM
* PostgreSQL
* Git

---

##  Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/reserva-espacos.git
cd reserva-espacos
```

### 2. Instalar dependências do PHP

```bash
composer install
```

### 3. Instalar dependências do Frontend

```bash
npm install
```

### 4. Configurar o ambiente

Copie o arquivo de configuração:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

---

##  Configuração do Banco de Dados

Configure as credenciais do PostgreSQL no arquivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=reserva_espacos
DB_USERNAME=postgres
DB_PASSWORD=sua_senha
```

---

##  Executar as Migrations

```bash
php artisan migrate
```

---

##  Criar Usuário Administrador

Abra o Tinker:

```bash
php artisan tinker
```

Execute:

```php
App\Models\User::create([
    "name" => "Admin",
    "email" => "admin@reserva.com",
    "password" => bcrypt("admin123"),
    "is_admin" => true
]);
```

---

##  Executando o Projeto

### Iniciar o Frontend

```bash
npm run dev
```

> Mantenha este terminal em execução.

### Iniciar o Backend

Abra um novo terminal e execute:

```bash
php artisan serve
```

---

##  Acesso ao Sistema

Após iniciar os serviços, acesse:

```text
http://localhost:8000
```

---

##  Credenciais de Administrador

```text
E-mail: admin@reserva.com
Senha: admin123
```

---

##  Estrutura do Projeto

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

---

##  Equipe de Desenvolvimento

| Integrante                     | Matrícula|
| ------------------------------ | -------- |
| Maria Eduarda Cardoso Ferreira | 0172454  |
| Guilherme Oliveira Ribeiro     | 01606196 |
| Matheus Wendell de Paula Souza | 01602509 |
| Matheus Felix Gomes            | 01670143 |

---

##  Projeto Acadêmico

Projeto desenvolvido como atividade acadêmica do curso de Ciência da Computação, aplicando conceitos de desenvolvimento web, banco de dados, engenharia de software e arquitetura MVC.

---

## 📄 Licença

Este projeto foi desenvolvido para fins acadêmicos e educacionais.
