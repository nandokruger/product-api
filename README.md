# Projeto Pós Graduação Arquiteto(a) de Software (XP Educação)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

## 1. Introdução
O presente relatório documenta a implementação da API product-api, desenvolvida em Laravel 12, que satisfaz os requisitos do Desafio Final do Bootcamp de Arquiteto(a) de Software.

Nesta atividade, aplicamos conceitos de arquitetura de software, modelagem arquitetural, padrões de projeto (Clean Architecture, Repository Pattern, Service Layer), e a estruturação MVC para expor um conjunto de endpoints RESTful de CRUD, contagem e busca de produtos.

API RESTful para gerenciamento de produtos desenvolvida em Laravel, seguindo os princípios de **Clean Architecture** e **Repository Pattern**.


## 2. Arquitetura do Software

### 2.1 Visão Geral
A solução segue o padrão MVC (Model‑View‑Controller) estendido por camadas de Service e Repository, promovendo separação de responsabilidades e facilidade de manutenção.

**Model:** Representação das entidades e DTOs (Data Transfer Objects).

**Controller:** Recebe e valida requisições HTTP, delegando a lógica ao Service.

**Service:** Encapsula regras de negócio e orquestra operações entre Controller, Repository e DTO.

**Repository:** Abstrai o acesso a dados, isolando a lógica de persistência (Eloquent ORM).


### 2.2 Diagrama de Componentes (C4)

```mermaid

C4Container
    title Arquitetura de Contêineres - Product API
    Person_Ext(user, "Consumer", "Cliente ou sistema parceiro que consome a API")
    System_Boundary(s1, "Product API System") {
        Container(api, "API REST Laravel", "Laravel 12", "Exposes HTTP endpoints para CRUD de produtos")
        ContainerDb(db, "Banco de Dados", "MySQL/PostgreSQL/SQLite", "Armazena dados de produtos")
    }
    Rel(user, api, "Consome API via HTTP/JSON")
    Rel(api, db, "Lê/Grava dados", "Eloquent ORM")

````

## Diagrama UML

```mermaid
classDiagram
    class ProductController {
        +index()
        +show(id)
        +store(request)
        +update(request, id)
        +destroy(id)
        +findByName(name)
        +count()
    }
    
    class ProductService {
        +getAllProducts()
        +getProductById(id)
        +createProduct(request)
        +updateProduct(id, request)
        +deleteProduct(id)
    }
    
    class ProductRepositoryInterface {
        <<interface>>
        +getAllProducts()
        +getProductById(id)
        +getProductsByName(name)
        +deleteProduct(id)
        +createProduct(product)
        +updateProduct(product)
        +countProducts()
    }
    
    class ProductRepository {
        +getAllProducts()
        +getProductById(id)
        +getProductsByName(name)
        +deleteProduct(id)
        +createProduct(product)
        +updateProduct(product)
        +countProducts()
    }
    
    class Product {
        +id
        +name
        +description
        +price
    }
    
    ProductController --> ProductService : usa
    ProductService --> ProductRepositoryInterface : depende
    ProductService --> Product : manipula
    ProductRepository ..|> ProductRepositoryInterface : implementa
```
- **ProductController:** expõe métodos REST (index, show, store, update, destroy, findByName e count) e delega a lógica ao serviço.

- **ProductService:** centraliza a lógica de negócios e depende da ProductRepositoryInterface para garantir o desacoplamento.

- **ProductRepository:** implementação concreta que lida com a persistência de dados.

- **Product (Model):** representa a entidade de domínio com atributos essenciais (id, name e price).

- **Arquitetura:** segue princípios de SOLID e Clean Architecture, facilitando testes, manutenção e extensões futuras.


  
## 3. Estrutura de Pastas do Projeto

```plaintext
app/
├── Http/           # Controllers e rotas
├── Models/         # Entidades do banco
├── Repositories/   # Implementações de repositórios
├── Services/       # Lógica de negócio
├── Interface/      # Interface
config/             # Configurações da aplicação
database/           # Migrations
routes/             # Definição de endpoints
```
### Função de cada diretório:

- **app/Controllers:** Mapeia as rotas REST e retorna respostas JSON.

- **app/Models:** Contém a classe Product com atributos e relacionamentos.

- **app/Repositories:** Implementa ProductRepositoryInterface e ProductRepository usando Eloquent.

- **app/Services:** Contém ProductService com métodos de CRUD, contagem e buscas.
  


## 4. Explicação dos Componentes

| Componente                | Responsabilidade                                                                |
|---------------------------|---------------------------------------------------------------------------------|
| ProductController         | Recebe requisições HTTP e delega a lógica para o serviço correspondente.        |
| ProductService            | Contém a lógica de negócio e interage com o repositório por meio da interface.  |
| ProductRepository         | Implementa a interface e realiza operações de persistência com Eloquent.        |
| ProductRepositoryInterface| Define o contrato para operações de acesso a dados, promovendo desacoplamento.  |
| Product (Model)           | Representa a entidade `products` no banco de dados com seus atributos.          |
| AppServiceProvider        | Realiza a ligação (binding) entre a interface e sua implementação concreta.     |
| Rotas (routes/api.php)    | Define os endpoints da API e direciona para os métodos do controller.           |


## 5. Persistência de Dados

- **Migrations:** Definição de tabela products com campos id, name, description, price, created_at e updated_at.

- **Banco de dados:** Compatível com MySQL, PostgreSQL ou SQLite via configuração em .env.
  

## 6. Desenvolvimento da Solução

### Configuração Inicial

- Criado projeto Laravel 12 via Composer.
- Configurado `.env` e conexão com o banco de dados.

### Model e Migration

- Gerada a classe `Product` e a migration correspondente.
- Executados os comandos `php artisan migrate`.

### Repository Pattern

- Definida a interface `ProductRepositoryInterface`.
- Implementado o repositório `ProductRepository`.
- Registrado o binding no `AppServiceProvider`.

### Service Layer

- Criado o `ProductService` com os métodos:
  - `all()`
  - `findById()`
  - `findByName()`
  - `count()`
  - `create()`
  - `update()`
  - `delete()`

### Controller

- Desenvolvido o `ProductController` para lidar com as requisições HTTP e delegar as operações ao `ProductService`.

### Rotas

- Definidas as rotas da API no arquivo `routes/api.php`, mapeando os endpoints para os métodos do `ProductController`.

| Método   | URL                     | Descrição                     |
|----------|-------------------------|-------------------------------|
| `GET`    | `/api/v1/products`      | Lista todos os produtos       |
| `GET`    | `/api/v1/products/{id}` | Busca produto por ID          |
| `POST`   | `/api/v1/products`      | Cria novo produto             |
| `PUT`    | `/api/v1/products/{id}` | Atualiza produto existente    |
| `DELETE` | `/api/v1/products/{id}` | Remove produto                |

**Exemplo de Request (POST):**
```json
{
    "name": "Smartphone",
    "price": 1999.90,
    "description": "Modelo XYZ, 128GB"
}

```

# Conclusão

Nesta seção, é apresentada uma reflexão sobre a experiência no Desafio Final, considerando os tópicos solicitados.

## Aplicação dos Conhecimentos

Para a implementação da **product-api**, foram utilizados conhecimentos adquiridos no Bootcamp de Arquiteto(a) de Software, tais como:

- Aplicação dos padrões arquiteturais **MVC** e **Clean Architecture**, organizando o código em **Controllers**, **Services** e **Repositories** e **DTOs**.
- Utilização do **Repository Pattern** para isolar a lógica de persistência e facilitar testes.
- Uso do **Eloquent ORM** e **migrations** do **Laravel 12** para gestão de banco de dados.
- Validação de dados via **DTOs** para garantir consistência e segurança nas operações.

## Principais Dificuldades e Superações

O maior desafio encontrado foi orquestrar as camadas de **Service** e **Repository**, garantindo que cada responsabilidade permanecesse isolada. Para superar esse obstáculo:

- Foi realizada a refatoração do **binding de interfaces** no `AppServiceProvider` para assegurar a inversão de dependência.
- Foi implementado o **versionamento de API** (ex.: `v1`, `v2`) para facilitar a evolução futura.

## Resultados Obtidos

A API atende a todos os requisitos do enunciado, incluindo:

- CRUD de produtos.
- Endpoints adicionais, como contagem de registros (`/count`) e busca por nome.

## Lições Aprendidas

Durante o desenvolvimento, foram aprendidos:

- Aplicação prática dos princípios **SOLID**, facilitando futuras extensões.
- Melhoria nas habilidades de design de **API RESTful** e na segurança de validação de dados.

## Melhorias Futuras

Para aprimorar a solução, são sugeridas as seguintes melhorias:

- Desenvolvimento de testes de integração e unitários, validando o fluxo entre camadas e facilitando a identificação de acoplamentos indevidos.
- Implementação de autenticação e autorização (**Passport**, **Sanctum**) para controle de acesso.
- Monitoramento de métricas e logs (**Laravel Telescope** ou ferramentas externas) para observabilidade.
- Ampliação da API para suportar novas entidades de domínio, como categorias, fornecedores e pedidos, implementando endpoints CRUD dedicados, modelagem de relacionamentos e regras de validação específicas para cada recurso, garantindo coesão e integridade no fluxo de dados.


## 🚀 Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/product-api.git

# Acesse a pasta
cd product-api

# Instale as dependências
composer install

# Configure o ambiente (copie .env.example)
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations (crie o banco antes)
php artisan migrate

```


