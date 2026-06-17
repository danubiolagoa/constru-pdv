# Constru-PDV

Sistema de Ponto de Venda (PDV) para lojas de materiais de construcao.

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
- Dashboard Admin (metricas, graficos, alertas)
- Dashboard Vendedor (PDV rapido)
- Cadastro de Produtos (CRUD completo)
- Controle de Estoque (entrada/saida, alertas)
- Gestao de Vendas (historico, cancelamentos)
- Gestao de Clientes (CPF/CNPJ, historico)
- Gestao de Usuarios (permissoes)
- Relatorios (vendas, estoque, fluxo de caixa)
- Configuracoes da Loja

### Features Extras
- Orcamentos/Pre-vendas
- Fiado/Crediario proprio
- Multiplas formas de pagamento
- Precos por unidade de medida (m3, m2, kg)
- Desconto por quantidade
- Importacao de produtos (CSV)
- Controle de caixa (abertura/fechamento)
- Logs de auditoria
- Codigo de barras (leitor fisico)
- Recibo/Cupom nao fiscal

## Design System

- **Paleta:** Verde Floresta `#2D5F4A` + Ambar Terroso `#D4883A`
- **Tipografia:** Inter (corpo) + JetBrains Mono (valores monetarios)
- **Layout:** Sidebar + Header fixo, conteudo fluido
- **PDV:** Atalhos de teclado (F2, F4, F8, F12), auto-focus, suporte a leitor

Ver [docs/DESIGN-SYSTEM.md](docs/DESIGN-SYSTEM.md) para especificacoes completas.

## Instalacao

```bash
git clone https://github.com/SEU_USUARIO/constru-pdv.git
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
│   ├── css/            # CSS compilado
│   ├── js/             # JavaScript
│   ├── img/            # Imagens
│   └── index.php       # Entry point
├── src/
│   ├── controllers/    # Controladores
│   ├── models/         # Models (banco de dados)
│   ├── views/          # Templates PHP
│   │   ├── layouts/    # Layouts base
│   │   └── components/ # Componentes reutilizaveis
│   ├── middleware/     # Middlewares
│   └── helpers/        # Funcoes auxiliares
├── config/             # Configuracoes
├── database/           # Migrations e seeds
├── docs/               # Documentacao
└── vercel.json         # Deploy Vercel
```

## Fases de Implementacao

Ver [docs/PLANO.md](docs/PLANO.md) para o plano completo de desenvolvimento.

| Fase | Foco | Status |
|------|------|--------|
| 1 | Fundacao (estrutura, DB, auth, layout) | Em andamento |
| 2 | Cadastros Basicos | Pendente |
| 3 | PDV (venda rapida) | Pendente |
| 4 | Estoque e Vendas | Pendente |
| 5 | Dashboard e Relatorios | Pendente |
| 6 | Features Avancadas | Pendente |
| 7 | Polimento e Deploy | Pendente |

## Licenca

MIT
