# Yu-Gi-Oh! Card Explorer

![PHP version](https://img.shields.io/badge/PHP-8.1%2B-777bb4?logo=php&logoColor=white)
![License MIT](https://img.shields.io/badge/license-MIT-green.svg)
![Architecture MVC](https://img.shields.io/badge/architecture-MVC-blue)

Aplicacao web para busca de cartas Yu-Gi-Oh! com foco em engenharia de software moderna: MVC, Service Layer, entidades tipadas, roteamento limpo, tratamento de erros e logging.

## Visao Geral

O projeto consome a API publica da YGOPRODeck e exibe cartas com dados completos como atributo, tipo, nivel, ATK/DEF, conjuntos e precos.

## Highlights

| Pilar | Implementacao | Beneficio para portfolio |
| --- | --- | --- |
| Arquitetura | MVC com Front Controller | Demonstra dominio de separacao de responsabilidades |
| Integracao externa | Service Layer com Guzzle | Comunicacao HTTP resiliente e testavel |
| Modelo de dados | Entidade `Card` com getters e regras encapsuladas | Remove arrays soltos e melhora manutencao |
| Observabilidade | Monolog em `logs/app.log` | Facilita diagnostico em producao |
| Configuracao | Dotenv com fallback de configuracoes | Ambientes desacoplados de codigo |
| Roteamento | URLs limpas (`/` e `/search`) com router dedicado | UX melhor e arquitetura moderna |
| Frontend | Bootstrap 5 + tema dark premium | Interface profissional e consistente |

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

## Changelog

### v2.0.0 - Senior Refactor

- Migracao de estrutura procedural para arquitetura MVC.
- Introducao de Service Layer para consumo da YGOPRODeck API.
- Adocao de entidades tipadas (`Card`) no fluxo de dados.
- Implementacao de roteamento limpo com router dedicado.
- Adicao de logging de erros com Monolog.
- Implementacao de tratamento amigavel de erros para o usuario final.
- Consolidacao de assets no `public/` e tema visual premium.

### v1.0.0 - Legacy Base

- Primeira versao funcional com busca e exibicao de cartas via API.

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
