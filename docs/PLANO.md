# Plano de Desenvolvimento - Constru-PDV

## Visao Geral

Sistema PDV completo para lojas de materiais de construcao, desenvolvido em PHP puro com Neon PostgreSQL.

## Stack Tecnica

| Camada | Tecnologia | Justificativa |
|--------|-----------|---------------|
| Backend | PHP 8.2+ (MVC puro) | Leve, sem dependencias pesadas, compativel com Vercel |
| Banco | Neon PostgreSQL | Serverless, free tier generoso, escalavel, backup automatico |
| Frontend | Tailwind CSS + JS vanilla | Interface leve, sem framework pesado |
| Icones | Lucide Icons | Open-source, consistente |
| Graficos | Chart.js | Leve, boa documentacao |
| Deploy | Vercel (via `vercel-php`) | Deploy rapido, SSL gratis |
| Repo | GitHub publico | Open source |

## Modulos do Sistema

1. **Autenticacao** - Login/logout/sessao com roles (admin, vendedor)
2. **Dashboard Admin** - Metricas, graficos, alertas de estoque
3. **Dashboard Vendedor** - PDV rapido otimizado para balcao
4. **Cadastro de Produtos** - CRUD com categorias, foto, SKU, codigo de barras
5. **Controle de Estoque** - Entrada/saida, alertas, historico
6. **Gestao de Vendas** - Historico, cancelamentos, devolucoes
7. **Gestao de Clientes** - CPF/CNPJ, historico, limite de credito
8. **Gestao de Usuarios** - Admin, vendedor, permissoes
9. **Relatorios** - Vendas, estoque, fluxo de caixa, export PDF/CSV
10. **Configuracoes** - Dados da loja, impostos, pagamentos

## Features Extras

- Orcamentos/Pre-vendas
- Fiado/Crediario proprio
- Multiplas formas de pagamento na mesma venda
- Precos por unidade de medida (m3, m2, kg, unidade)
- Desconto por quantidade
- Importacao de produtos (CSV)
- Controle de caixa (abertura/fechamento)
- Logs de auditoria
- Codigo de barras (leitor fisico)
- Recibo/Cupom nao fiscal

---

## Fases de Implementacao

### Fase 1 - Fundacao (Base do sistema) ✅

**Objetivo:** Estrutura basica do projeto funcionando com autenticacao e layout.

```
Progresso
● [x] Estrutura do projeto (MVC, roteamento, autoload)
● [x] Conexao com Neon PostgreSQL
● [x] Sistema de autenticacao (login/logout/sessao)
● [x] Layout base (sidebar, header, componentes)
● [x] Design system (Tailwind config, cores, tipografia)
● [x] Migration do banco de dados (tabelas core)
● [x] Middleware de autenticacao e permissoes
```

**Entregaveis:**
- Projeto rodando localmente e na Vercel
- Login funcional
- Layout base com sidebar e header
- Banco de dados conectado

---

### Fase 2 - Cadastros Basicos ✅

**Objetivo:** CRUD completo das entidades principais.

```
Progresso
● [x] CRUD de Produtos (com busca e filtros)
● [x] CRUD de Clientes (CPF/CNPJ, contato, total compras)
● [x] CRUD de Usuarios (admin e vendedor)
● [x] Categorias via seed (usadas em produtos)
● [x] Sistema de busca e filtros
```

**Entregaveis:**
- Produtos cadastrados com estoque e precos
- Clientes cadastrados com historico de compras
- Usuarios com roles definidos
- Busca funcional em todas as listas

---

### Fase 3 - PDV (Coracao do sistema) ✅

**Objetivo:** Sistema de venda rapida funcional e otimizado.

```
Progresso
● [x] Tela do PDV com busca rapida de produtos
● [x] Carrinho de compras (adicionar/remover/alterar qtd)
● [x] Selecao de cliente (opcional)
● [x] Finalizacao de venda (forma de pagamento)
● [x] Baixa automatica de estoque
```

**Entregaveis:**
- PDV funcional
- Venda registrada no banco
- Estoque atualizado automaticamente

---

### Fase 4 - Estoque e Vendas ✅

**Objetivo:** Controle completo de estoque e gestao de vendas.

```
Progresso
● [x] Controle de estoque (entrada/saida manual com modal)
● [x] Alertas de estoque baixo (tags coloridas: Critico/Baixo/Normal)
● [x] Historico de movimentacoes
● [x] Gestao de vendas (historico, filtros por data/status)
● [x] Cancelamento de venda (com reposicao de estoque)
```

**Entregaveis:**
- Estoque controlado com historico e grafico
- Alertas visuais de estoque baixo com indicador por cor
- Vendas com historico completo e detalhes
- Cancelamentos funcionais

---

### Fase 5 - Dashboard e Relatorios ✅

**Objetivo:** Visualizacao de dados e relatorios exportaveis.

```
Progresso
● [x] Dashboard Admin (metricas, graficos Chart.js)
● [x] Dashboard Vendedor (resumo pessoal)
● [x] Relatorio de vendas por periodo
● [x] Relatorio de produtos mais vendidos
● [x] Relatorio de fluxo de caixa
```

**Entregaveis:**
- Dashboard com graficos interativos (barras dupla, rosca, horizontal)
- Metas de vendas via configuracao
- Relatorios com dados reais do banco

---

### Fase 6 - Funcionalidades Avancadas (infraestrutura)

**Objetivo:** Features extras que agregam valor ao sistema.

```
Progresso
● [x] Precos por unidade de medida (un, kg, m2, m3, m, l, cx, pct)
● [x] Logs de auditoria (tabela criada)
```

**Obs:** As demais features avancadas foram movidas para a Fase 8 (pos-MVP).

---

### Fase 7 - Polimento e Deploy ✅

**Objetivo:** Preparar para producao e fazer deploy.

```
Progresso
● [x] Configuracoes da loja (dados, meta de vendas)
● [x] Empty states e micro-interacoes
● [x] Toasts e feedback visual
● [x] Testes manuais (QA via Playwright)
● [x] Documentacao (README, DESIGN-SYSTEM, PLANO)
● [x] Deploy na Vercel (vercel-php + @vercel/static)
● [x] Repositorio GitHub publico
```

**Entregaveis:**
- Sistema polido e profissional
- Deploy funcionando na Vercel: https://constru-pdv.vercel.app
- Repositorio publico: https://github.com/danubiolagoa/constru-pdv
- Documentacao completa

---

---

### Fase 8 - Pos-MVP (aprovacao do cliente)

**Objetivo:** Melhorias e features solicitadas apos validacao do MVP.

```
Progresso
● [ ] Atalhos de teclado (F2, F4, F8, F12)
● [ ] Suporte a leitor de codigo de barras
● [ ] Aplicacao de desconto (% ou valor fixo)
● [ ] Impressao de recibo
● [ ] Devolucao parcial
● [ ] Exportacao PDF/CSV
● [ ] Controle de caixa (abertura/fechamento)
● [ ] Orcamentos/Pre-vendas
● [ ] Fiado/Crediario proprio
● [ ] Multiplas formas de pagamento
● [ ] Desconto por quantidade
● [ ] CRUD de Categorias de produtos
● [ ] Importacao de produtos (CSV)
```

---

## Modelo do Banco de Dados

### Tabelas Principais

```sql
-- Usuarios do sistema
usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL, -- 'admin', 'vendedor'
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Categorias de produtos
categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    icone VARCHAR(50),
    created_at TIMESTAMP DEFAULT NOW()
)

-- Produtos
produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    sku VARCHAR(50) UNIQUE,
    codigo_barras VARCHAR(50),
    preco_venda DECIMAL(10,2) NOT NULL,
    unidade_medida VARCHAR(10) DEFAULT 'un', -- 'un', 'kg', 'm2', 'm3'
    estoque_atual DECIMAL(10,2) DEFAULT 0,
    estoque_minimo DECIMAL(10,2) DEFAULT 0,
    categoria_id INTEGER REFERENCES categorias(id),
    foto_url VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Clientes
clientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf_cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT,
    limite_credito DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Vendas
vendas (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(20) UNIQUE NOT NULL,
    cliente_id INTEGER REFERENCES clientes(id),
    vendedor_id INTEGER REFERENCES usuarios(id),
    subtotal DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    forma_pagamento VARCHAR(50), -- 'pix', 'dinheiro', 'cartao', 'fiado', 'multiplo'
    status VARCHAR(20) DEFAULT 'concluida', -- 'concluida', 'pendente', 'cancelada'
    motivo_cancelamento TEXT,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Itens da venda
itens_venda (
    id SERIAL PRIMARY KEY,
    venda_id INTEGER REFERENCES vendas(id),
    produto_id INTEGER REFERENCES produtos(id),
    quantidade DECIMAL(10,2) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
)

-- Pagamentos (para multiplas formas)
pagamentos (
    id SERIAL PRIMARY KEY,
    venda_id INTEGER REFERENCES vendas(id),
    forma_pagamento VARCHAR(50) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
)

-- Movimentacoes de estoque
movimentacoes_estoque (
    id SERIAL PRIMARY KEY,
    produto_id INTEGER REFERENCES produtos(id),
    tipo VARCHAR(10) NOT NULL, -- 'entrada', 'saida'
    quantidade DECIMAL(10,2) NOT NULL,
    motivo VARCHAR(100),
    usuario_id INTEGER REFERENCES usuarios(id),
    venda_id INTEGER REFERENCES vendas(id),
    created_at TIMESTAMP DEFAULT NOW()
)

-- Orcamentos
orcamentos (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(20) UNIQUE NOT NULL,
    cliente_id INTEGER REFERENCES clientes(id),
    vendedor_id INTEGER REFERENCES usuarios(id),
    itens JSONB NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'aberto', -- 'aberto', 'convertido', 'cancelado'
    validade DATE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Fiado/Crediario
crediario (
    id SERIAL PRIMARY KEY,
    cliente_id INTEGER REFERENCES clientes(id),
    venda_id INTEGER REFERENCES vendas(id),
    valor_total DECIMAL(10,2) NOT NULL,
    valor_pago DECIMAL(10,2) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'aberto', -- 'aberto', 'pago', 'parcial'
    vencimento DATE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
)

-- Controle de caixa
caixa (
    id SERIAL PRIMARY KEY,
    data_abertura DATE NOT NULL,
    data_fechamento DATE,
    saldo_inicial DECIMAL(10,2) DEFAULT 0,
    saldo_final DECIMAL(10,2),
    vendedor_id INTEGER REFERENCES usuarios(id),
    status VARCHAR(20) DEFAULT 'aberto', -- 'aberto', 'fechado'
    created_at TIMESTAMP DEFAULT NOW()
)

-- Logs de auditoria
logs_auditoria (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id),
    acao VARCHAR(100) NOT NULL,
    tabela VARCHAR(50),
    registro_id INTEGER,
    dados_antigos JSONB,
    dados_novos JSONB,
    ip VARCHAR(45),
    created_at TIMESTAMP DEFAULT NOW()
)

-- Configuracoes da loja
configuracoes (
    id SERIAL PRIMARY KEY,
    chave VARCHAR(50) UNIQUE NOT NULL,
    valor TEXT,
    updated_at TIMESTAMP DEFAULT NOW()
)
```

---

## Criterios de Aceite

### Fase 1 ✅
- [x] Projeto roda localmente com `php -S localhost:8000 -t public`
- [x] Login funcional com sessao de 8h
- [x] Layout base com sidebar navegavel
- [x] Banco Neon conectado e migrations executadas

### Fase 2 ✅
- [x] CRUD completo de produtos
- [x] CRUD de clientes com validacao de CPF/CNPJ
- [x] CRUD de usuarios com roles
- [x] Busca funcional em todas as listas

### Fase 3 ✅
- [x] PDV funcional com busca rapida
- [x] Venda registrada e estoque atualizado

### Fase 4 ✅
- [x] Estoque com historico completo
- [x] Alertas visuais de estoque baixo
- [x] Cancelamento de venda restaura estoque

### Fase 5 ✅
- [x] Dashboards com graficos Chart.js
- [x] Metricas em tempo real

### Fase 7 ✅
- [x] Deploy funcionando na Vercel
- [x] Repositorio publico no GitHub
- [x] Documentacao completa
- [x] QA realizado

### Fase 8 (Pos-MVP)
- [ ] Atalhos de teclado funcionando (F2, F4, F8, F12)
- [ ] Suporte a leitor de codigo de barras
- [ ] Aplicacao de desconto
- [ ] Recibo imprimivel
- [ ] Devolucao parcial funcional
- [ ] Relatorios exportaveis em PDF/CSV
- [ ] Controle de caixa funcional
- [ ] Orcamentos com conversao em venda
- [ ] Fiado com controle de pagamentos
- [ ] Multiplas formas de pagamento na venda
- [ ] Desconto por quantidade
- [ ] CRUD de Categorias
- [ ] Importacao de produtos (CSV)
