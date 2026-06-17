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

### Fase 1 - Fundacao (Base do sistema)

**Objetivo:** Estrutura basica do projeto funcionando com autenticacao e layout.

```
Progresso
● [ ] Estrutura do projeto (MVC, roteamento, autoload)
● [ ] Conexao com Neon PostgreSQL
● [ ] Sistema de autenticacao (login/logout/sessao)
● [ ] Layout base (sidebar, header, componentes)
● [ ] Design system (Tailwind config, cores, tipografia)
● [ ] Migration do banco de dados (tabelas core)
● [ ] Middleware de autenticacao e permissoes
```

**Entregaveis:**
- Projeto rodando localmente
- Login funcional
- Layout base com sidebar e header
- Banco de dados conectado

---

### Fase 2 - Cadastros Basicos

**Objetivo:** CRUD completo das entidades principais.

```
Progresso
● [ ] CRUD de Produtos (com categorias e foto)
● [ ] CRUD de Clientes (CPF/CNPJ, contato)
● [ ] CRUD de Usuarios (admin e vendedor)
● [ ] CRUD de Categorias de produtos
● [ ] Sistema de busca e filtros
```

**Entregaveis:**
- Produtos cadastrados com foto e categoria
- Clientes cadastrados com CPF/CNPJ
- Usuarios com roles definidos
- Busca funcional em todas as listas

---

### Fase 3 - PDV (Coracao do sistema)

**Objetivo:** Sistema de venda rapida funcional e otimizado.

```
Progresso
● [ ] Tela do PDV com busca rapida de produtos
● [ ] Carrinho de compras (adicionar/remover/alterar qtd)
● [ ] Selecao de cliente (opcional)
● [ ] Aplicacao de desconto (% ou valor fixo)
● [ ] Finalizacao de venda (forma de pagamento)
● [ ] Atalhos de teclado (F2, F4, F8, F12)
● [ ] Suporte a leitor de codigo de barras
● [ ] Baixa automatica de estoque
● [ ] Impressao de recibo
```

**Entregaveis:**
- PDV funcional e rapido
- Atalhos de teclado funcionando
- Venda registrada no banco
- Estoque atualizado automaticamente

---

### Fase 4 - Estoque e Vendas

**Objetivo:** Controle completo de estoque e gestao de vendas.

```
Progresso
● [ ] Controle de estoque (entrada/saida manual)
● [ ] Alertas de estoque baixo
● [ ] Historico de movimentacoes
● [ ] Gestao de vendas (historico, filtros)
● [ ] Cancelamento de venda (com reposicao de estoque)
● [ ] Devolucao parcial
```

**Entregaveis:**
- Estoque controlado com historico
- Alertas visuais de estoque baixo
- Vendas com historico completo
- Cancelamentos e devolucoes funcionais

---

### Fase 5 - Dashboard e Relatorios

**Objetivo:** Visualizacao de dados e relatorios exportaveis.

```
Progresso
● [ ] Dashboard Admin (metricas, graficos)
● [ ] Dashboard Vendedor (resumo pessoal)
● [ ] Relatorio de vendas por periodo
● [ ] Relatorio de produtos mais vendidos
● [ ] Relatorio de fluxo de caixa
● [ ] Exportacao PDF/CSV
```

**Entregaveis:**
- Dashboards com graficos interativos
- Relatorios gerados e exportaveis
- Metricas em tempo real

---

### Fase 6 - Funcionalidades Avancadas

**Objetivo:** Features extras que agregam valor ao sistema.

```
Progresso
● [ ] Controle de caixa (abertura/fechamento)
● [ ] Orcamentos/Pre-vendas
● [ ] Fiado/Crediario proprio
● [ ] Multiplas formas de pagamento
● [ ] Precos por unidade de medida (m3, m2, kg)
● [ ] Desconto por quantidade
● [ ] Importacao de produtos (CSV)
● [ ] Logs de auditoria
```

**Entregaveis:**
- Todas as features extras funcionais
- Sistema completo para uso em producao

---

### Fase 7 - Polimento e Deploy

**Objetivo:** Preparar para producao e fazer deploy.

```
Progresso
● [ ] Configuracoes da loja
● [ ] Empty states e micro-interacoes
● [ ] Toasts e feedback visual
● [ ] Testes manuais (QA)
● [ ] Documentacao (README)
● [ ] Deploy na Vercel
● [ ] Repositorio GitHub publico
```

**Entregaveis:**
- Sistema polido e profissional
- Deploy funcionando na Vercel
- Repositorio publico no GitHub
- Documentacao completa

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

### Fase 1
- [ ] Projeto roda localmente com `php -S localhost:8000 -t public`
- [ ] Login funcional com sessao de 8h
- [ ] Layout base com sidebar navegavel
- [ ] Banco Neon conectado e migrations executadas

### Fase 2
- [ ] CRUD completo de produtos com upload de foto
- [ ] CRUD de clientes com validacao de CPF/CNPJ
- [ ] CRUD de usuarios com roles
- [ ] Busca funcional em todas as listas

### Fase 3
- [ ] PDV funcional com busca rapida
- [ ] Atalhos de teclado funcionando (F2, F4, F8, F12)
- [ ] Venda registrada e estoque atualizado
- [ ] Recibo imprimivel

### Fase 4
- [ ] Estoque com historico completo
- [ ] Alertas visuais de estoque baixo
- [ ] Cancelamento de venda restaura estoque
- [ ] Devolucao parcial funcional

### Fase 5
- [ ] Dashboards com graficos Chart.js
- [ ] Relatorios exportaveis em PDF/CSV
- [ ] Metricas em tempo real

### Fase 6
- [ ] Controle de caixa funcional
- [ ] Orcamentos com conversao em venda
- [ ] Fiado com controle de pagamentos
- [ ] Multiplas formas de pagamento na venda

### Fase 7
- [ ] Deploy funcionando na Vercel
- [ ] Repositorio publico no GitHub
- [ ] Documentacao completa
- [ ] QA realizado
