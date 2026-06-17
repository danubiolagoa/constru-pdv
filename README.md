# Constru-PDV

Sistema de Ponto de Venda (PDV) para lojas de materiais de construcao.
Deploy: [constru-pdv.vercel.app](https://constru-pdv.vercel.app)

**Login avaliacao:** admin@construpdv.com / admin123

## Tecnologias

- **Backend:** PHP 8.2+ (MVC proprio, sem framework)
- **Banco de Dados:** Neon PostgreSQL (serverless)
- **Frontend:** Tailwind CSS + JavaScript vanilla
- **Icones:** Lucide Icons
- **Graficos:** Chart.js
- **Deploy:** Vercel (via `vercel-php`)

## Funcionalidades

### Modulos Principais
- Autenticacao (login/logout/sessao)
- Dashboard Admin (metricas, graficos Chart.js, alertas de estoque)
- Dashboard Vendedor (resumo pessoal)
- CRUD de Produtos (SKU, codigo barras, unidade medida, estoque)
- Controle de Estoque (entrada/saida, alertas, historico, grafico)
- Gestao de Vendas (historico, filtros, detalhes, cancelamento)
- Gestao de Clientes (CPF/CNPJ, historico de compras)
- Gestao de Usuarios (admin/vendedor)
- Relatorios (vendas por periodo, produtos mais vendidos, fluxo de caixa)
- Configuracoes da Loja (inclui meta de vendas diaria)

### Tabelas do Banco (14)
usuarios, categorias, produtos, clientes, vendas, itens_venda, pagamentos,
movimentacoes_estoque, orcamentos, crediario, caixa, logs_auditoria, configuracoes

## Design System

- **Paleta:** Verde Floresta `#2D5F4A` + Ambar Terroso `#D4883A`
- **Tipografia:** Inter (corpo) + JetBrains Mono (valores monetarios)
- **Layout:** Sidebar + Header fixo, conteudo fluido

Ver [docs/DESIGN-SYSTEM.md](docs/DESIGN-SYSTEM.md) para especificacoes completas.

## Instalacao

```bash
git clone https://github.com/danubiolagoa/constru-pdv.git
cd constru-pdv
composer install
npm install
npm run build
```

## Configuracao

1. Copie `.env.example` para `.env`
2. Configure as variaveis de ambiente:

```env
DB_HOST=seu-host.neon.tech
DB_NAME=neondb
DB_USER=seu_usuario
DB_PASSWORD=sua_senha
DB_PORT=5432

APP_URL=http://localhost:8000
APP_ENV=development
```

3. Execute as migrations:

```bash
php migrate.php
```

4. Inicie o servidor:

```bash
php -S localhost:8000 -t public
```

## Estrutura do Projeto

```
constru-pdv/
├── public/              # Arquivos publicos
│   ├── css/            # CSS compilado (Tailwind)
│   ├── js/             # JavaScript
│   ├── img/            # Imagens
│   └── index.php       # Entry point
├── src/
│   ├── Controllers/    # Controladores
│   ├── Models/         # Models (banco de dados)
│   ├── Views/          # Templates PHP
│   │   ├── layouts/    # Layouts base (app, auth)
│   │   └── components/ # Componentes reutilizaveis (sidebar)
│   ├── Middleware/     # Middlewares (auth, admin, guest)
│   └── helpers/        # Funcoes auxiliares (env, csrf, render)
├── config/             # Configuracoes (app, database, routes)
├── database/           # Migrations e seeds
├── docs/               # Documentacao
├── .env.example        # Template de variaveis de ambiente
├── vercel.json         # Deploy Vercel (vercel-php + @vercel/static)
└── migrate.php         # Script de migracao do banco
```

## Fases de Implementacao

Ver [docs/PLANO.md](docs/PLANO.md) para o plano completo de desenvolvimento.

### Pos-MVP (apos aprovacao do cliente)

- Atalhos de teclado, leitor de codigo de barras, desconto, recibo
- Devolucao parcial, exportacao PDF/CSV
- Controle de caixa, orcamentos, fiado/crediario
- Multiplas formas de pagamento, importacao CSV

| Fase | Foco | Status |
|------|------|--------|
| 1-7 | MVP (versao 1.0) | Concluido |
| 8 | Pos-MVP (apos aprovacao do cliente) | Pendente |

## Licenca

MIT
