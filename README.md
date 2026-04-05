# Yu-Gi-Oh! Card Explorer

![PHP version](https://img.shields.io/badge/PHP-8.1%2B-777bb4?logo=php&logoColor=white)
![License MIT](https://img.shields.io/badge/license-MIT-green.svg)
![Architecture MVC](https://img.shields.io/badge/architecture-MVC-blue)

Aplicacao web para busca de cartas Yu-Gi-Oh! com foco em engenharia de software moderna: MVC, Service Layer, entidades tipadas, roteamento limpo, tratamento de erros e logging.

## Visao Geral

O projeto consome a API publica da YGOPRODeck e exibe cartas com dados completos como atributo, tipo, nivel, ATK/DEF, conjuntos e precos.

Destaques tecnicos:
- Arquitetura MVC com front controller.
- Service dedicada para integracao HTTP com Guzzle.
- Entidade `Card` para encapsular dados e regras de apresentacao.
- Views enxutas, focadas em renderizacao.
- Logging de erros com Monolog.
- Variaveis de ambiente com Dotenv.
- Rotas limpas (`/` e `/search`).

## Stack

- [PHP 8.1+](https://www.php.net/)
- [Guzzle](https://github.com/guzzle/guzzle)
- [Monolog](https://github.com/Seldaek/monolog)
- [Bramus Router](https://github.com/bramus/router)
- [PHP Dotenv](https://github.com/vlucas/phpdotenv)
- [Bootstrap 5](https://getbootstrap.com/)
- [YGOPRODeck API](https://db.ygoprodeck.com/api-guide/)

## Arquitetura

```text
app/
    Config/
    Controllers/
    Core/
    Entities/
    Services/
public/
    assets/
    index.php
views/
    cards/
    errors/
    layouts/
logs/
```

## Funcionalidades

- Busca por nome de carta com paginacao.
- Tela inicial e tela de resultados com tema dark premium.
- Estado para resultados vazios.
- Sanitizacao de output nas views.
- Tratamento amigavel de erro para usuario final.
- Registro tecnico de erros em arquivo de log.

## Requisitos

- PHP 8.1 ou superior
- Composer
- Extensao `curl` habilitada no PHP
- Acesso a internet para consultar a YGOPRODeck API

## Instalacao

1. Clone o repositorio:

```bash
git clone https://github.com/AndersonCav/Yu-Gi-Oh-.git
```

2. Entre na pasta do projeto:

```bash
cd Yu-Gi-Oh-
```

3. Instale as dependencias:

```bash
composer install
```

4. Crie seu arquivo de ambiente:

```bash
cp .env.example .env
```

No Windows (PowerShell):

```powershell
Copy-Item .env.example .env
```

## Execucao

### Opcao 1: servidor embutido (recomendado para desenvolvimento)

```bash
composer serve
```

Abra: `http://localhost:8000`

### Opcao 2: XAMPP/Apache

Se estiver rodando em subpasta do `htdocs`, abra:

`http://localhost/Yu-Gi-Oh-/public/`

## Rotas

- `GET /` -> pagina inicial
- `GET /search?busca=termo&pagina=1` -> resultados

## Logs e Erros

- Logs de erro da aplicacao: `logs/app.log`
- Erros tecnicos sao registrados no log.
- Usuario final recebe pagina amigavel em caso de falha.

## Qualidade de Codigo

Padroes adotados no projeto:
- PSR-4 (autoload)
- PSR-12 (estilo)
- Separacao de responsabilidades por camadas

## Screenshots

- [screenshot home aqui]
- [screenshot resultados aqui]

## Contribuicao

1. Crie um fork do projeto.
2. Crie uma branch de feature: `feature/minha-melhoria`.
3. Mantenha alteracoes pequenas e focadas.
4. Teste o fluxo principal antes de abrir PR.
5. Descreva claramente objetivo, alteracoes e impacto.

## Licenca

Este projeto esta sob a licenca MIT.

## Nota de Naming

Para clareza de produto e portfolio, recomenda-se renomear o repositorio para `yugioh-card-explorer`.
