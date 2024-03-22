<h1 align="center">
  🐘🎯 Hexagonal Architecture, DDD & CQRS in PHP
</h1>

<p align="center">
  Librarify is a <strong>PHP application using Domain-Driven Design (DDD) and Command Query Responsibility Segregation
  (CQRS) principles</strong> keeping the code as simple as possible.
</p>

## 🚀 Environment Setup

### 🐳 Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/serodas/librarify-php-ddd.git`
3. Move to the project folder: `cd librarify-php-ddd`

### 🛠️ Environment configuration

1. Create a local environment file (`cp .env .env.local`) if you want to modify any parameter

### 🔥 Application execution

1. Install all the dependencies and bring up the project with Docker executing: `make build`
2. Then you'll have 1 app available (1 API):
   1. [Librarify Backend](apps/librarify/backend): http://localhost:8030/health-check

### ✅ Tests execution

1. Install the dependencies if you haven't done it previously: `make deps`
2. Execute PHPUnit and Behat tests: `make test`

## 👩‍💻 Project explanation

This project tries to be a library platform. It's decoupled from any framework, but it has
some Symfony implementation.

### ⛱️ Bounded Contexts

* [Librarify](src/Librarify): Place to look in if you wanna see some code 🙂. Library platform with books, authors, categories, and so on.

### 🎯 Hexagonal Architecture

This repository follows the Hexagonal Architecture pattern. Also, it's structured using `modules`.
<!-- With this, we can see that the current structure of a Bounded Context is: -->

#### Repository pattern
Our repositories try to be as simple as possible usually only containing 2 methods `search` and `save`.
If we need some query with more filters we use the `Specification` pattern also known as `Criteria` pattern. So we add a
`searchByCriteria` method.

### Command Bus
There is 1 implementations of the [command bus](src/Shared/Domain/Bus/Command/CommandBus.php).
1. [Sync](src/Shared/Infrastructure/Bus/Command/InMemorySymfonyCommandBus.php) using the Symfony Message Bus

### Query Bus
The [Query Bus](src/Shared/Infrastructure/Bus/Query/InMemorySymfonyQueryBus.php) uses the Symfony Message Bus.

### Event Bus
The [Event Bus](src/Shared/Infrastructure/Bus/Event/InMemory/InMemorySymfonyEventBus.php) uses the Symfony Message Bus.
The [MySql Bus](src/Shared/Infrastructure/Bus/Event/MySql/MySqlDoctrineEventBus.php) uses a MySql+Pulling as a bus.
The [RabbitMQ Bus](src/Shared/Infrastructure/Bus/Event/RabbitMq/RabbitMqEventBus.php) uses RabbitMQ C extension.

### Reference
Based on https://github.com/CodelyTV/php-ddd-example.git