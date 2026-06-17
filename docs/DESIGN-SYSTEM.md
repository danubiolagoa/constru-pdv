# Design System - Constru-PDV

## Paleta de Cores

### Cores Primarias

| Token | Hex | Uso |
|-------|-----|-----|
| `primary` | `#2D5F4A` | Verde Floresta - cor principal |
| `primary-light` | `#3D7A62` | Hover, estados ativos |
| `primary-dark` | `#1E4233` | Hover escuro, presses |

### Cores Secundarias (Accent)

| Token | Hex | Uso |
|-------|-----|-----|
| `accent` | `#D4883A` | Ambar Terroso - acoes PDV, destaques |
| `accent-light` | `#E8A85C` | Hover claro |
| `accent-dark` | `#B8722E` | Hover escuro, textos sobre branco |

### Neutros

| Token | Hex | Uso |
|-------|-----|-----|
| `gray-50` | `#F8F9FA` | Background principal |
| `gray-100` | `#F1F3F5` | Background secundario |
| `gray-200` | `#E9ECEF` | Bordas, divisores |
| `gray-300` | `#DEE2E6` | Inputs inativos |
| `gray-400` | `#ADB5BD` | Texto placeholder |
| `gray-500` | `#6C757D` | Texto secundario |
| `gray-600` | `#495057` | Texto principal |
| `gray-700` | `#343A40` | Titulos |
| `gray-800` | `#212529` | Texto escuro |

### Semanticas

| Token | Hex | Uso |
|-------|-----|-----|
| `success` | `#2B8A3E` | Verde sucesso |
| `warning` | `#E67700` | Alerta estoque baixo |
| `danger` | `#C92A2A` | Erro, cancelamento |
| `info` | `#1971C2` | Informacao |

---

## Tipografia

### Familias

- **Principal:** Inter (Google Fonts)
- **Monospace:** JetBrains Mono (valores monetarios)

### Escala

| Token | Size | Weight | Uso |
|-------|------|--------|-----|
| `text-xs` | 12px | 400 | Labels auxiliares |
| `text-sm` | 14px | 400 | Corpo secundario |
| `text-base` | 16px | 400 | Corpo principal |
| `text-lg` | 18px | 500 | Subtitulos |
| `text-xl` | 20px | 600 | Titulos de secao |
| `text-2xl` | 24px | 600 | Titulos de pagina |
| `text-3xl` | 30px | 700 | Hero/Dashboard |
| `text-4xl` | 36px | 700 | Valores em destaque |
| `money-lg` | 28px | 700 | Total PDV (mono) |
| `money-base` | 18px | 600 | Precos em lista (mono) |

### Configuracoes

- **Line-height:** 1.5 para corpo, 1.2 para titulos
- **Letter-spacing:** -0.02em para titulos, normal para corpo

---

## Espacamento

Escala baseada em 4px:

| Token | Valor | Uso |
|-------|-------|-----|
| `space-1` | 4px | Micro gaps entre icones e texto |
| `space-2` | 8px | Padding interno de badges |
| `space-3` | 12px | Padding de inputs compactos |
| `space-4` | 16px | Padding padrao de cards |
| `space-5` | 20px | Gap entre secoes |
| `space-6` | 24px | Padding lateral de containers |
| `space-8` | 32px | Gap entre cards |
| `space-10` | 40px | Margem de pagina |
| `space-12` | 48px | Separacao de secoes grandes |
| `space-16` | 64px | Padding de pagina desktop |

---

## Sombras e Elevacao

| Token | Valor | Uso |
|-------|-------|-----|
| `shadow-sm` | `0 1px 2px rgba(0,0,0,0.05)` | Cards estaticos |
| `shadow-md` | `0 4px 6px rgba(0,0,0,0.07)` | Dropdowns, popovers |
| `shadow-lg` | `0 10px 15px rgba(0,0,0,0.1)` | Modais |
| `shadow-xl` | `0 20px 25px rgba(0,0,0,0.15)` | Overlays |

---

## Border Radius

| Token | Valor | Uso |
|-------|-------|-----|
| `radius-sm` | 4px | Badges, tags |
| `radius-md` | 8px | Inputs, botoes |
| `radius-lg` | 12px | Cards, modais |
| `radius-xl` | 16px | Containers grandes |
| `radius-full` | 9999px | Avatares, pills |

---

## Componentes

### Botoes

```css
/* Primary */
.btn-primary {
    background: #2D5F4A;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
}
.btn-primary:hover { background: #1E4233; }

/* Accent (acoes PDV) */
.btn-accent {
    background: #D4883A;
    color: white;
}

/* Outline */
.btn-outline {
    border: 2px solid #2D5F4A;
    color: #2D5F4A;
}

/* Ghost */
.btn-ghost {
    color: #495057;
}
.btn-ghost:hover { background: #F1F3F5; }

/* Danger */
.btn-danger {
    background: #C92A2A;
    color: white;
}

/* Tamanhos */
.btn-sm { padding: 6px 12px; font-size: 14px; }
.btn-lg { padding: 12px 24px; font-size: 18px; }
.btn-icon { padding: 8px; border-radius: 8px; }
```

### Inputs

```css
.input-base {
    border: 1px solid #DEE2E6;
    border-radius: 8px;
    padding: 10px 12px;
}
.input-base:focus {
    border-color: #2D5F4A;
    box-shadow: 0 0 0 3px rgba(45, 95, 74, 0.1);
}

.input-search { /* Com icone de lupa */ }
.input-money { font-family: 'JetBrains Mono'; text-align: right; }
.input-error { border-color: #C92A2A; }
```

### Cards

```css
.card-base {
    background: white;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    border-radius: 12px;
    padding: 16px;
}

.card-metric { /* Com icone, valor grande, variacao % */ }
.card-product { /* Imagem, nome, preco, estoque, acoes */ }
```

### Tabelas

```css
.table-base {
    /* Cabecalho bg-gray-50, linhas hover */
    /* Zebra striping sutil, sticky header */
}
```

### Modais

| Tamanho | Largura | Uso |
|---------|---------|-----|
| `modal-sm` | 400px | Confirmacoes |
| `modal-md` | 600px | Formularios |
| `modal-lg` | 800px | Detalhes, PDV rapido |
| `modal-full` | 95vw | PDV completo |

### Badges/Tags

| Tipo | Estilo | Uso |
|------|--------|-----|
| `badge-ok` | Verde claro | Em estoque |
| `badge-warn` | Amarelo claro | Estoque baixo |
| `badge-error` | Vermelho claro | Sem estoque |
| `badge-info` | Azul claro | Pendente |

---

## Icones

**Biblioteca:** Lucide Icons (https://lucide.dev/)

### Icones-chave

**Navegacao:**
- LayoutDashboard, ShoppingCart, Package, Users, BarChart3, Settings, LogOut

**PDV:**
- ScanBarcode, Search, Plus, Minus, Trash2, CreditCard, Banknote, Smartphone

**Acoes:**
- Edit, Trash2, Eye, Download, Upload, Plus, Filter, RefreshCw

**Status:**
- CheckCircle2, AlertTriangle, XCircle, Clock, TrendingUp, TrendingDown

**Construcao:**
- HardHat, Hammer, Paintbrush, Wrench

---

## Layout Base

### Estrutura (Shell)

```
┌──────────────────────────────────────────────────────────────────┐
│ ┌──────────┐ ┌─────────────────────────────────────────────────┐ │
│ │          │ │  Header (56px)                                  │ │
│ │          │ │  ┌─────────────────────────────┐ ┌───────────┐  │ │
│ │  SIDEBAR │ │  │ Breadcrumb / Titulo pagina  │ │ User Menu │  │ │
│ │  (240px) │ │  └─────────────────────────────┘ └───────────┘  │ │
│ │          │ ├─────────────────────────────────────────────────┤ │
│ │  Logo    │ │                                                  │ │
│ │  ─────   │ │  Conteudo Principal                             │ │
│ │  Nav     │ │  (padding: 24px)                                │ │
│ │  Items   │ │                                                  │ │
│ │          │ │                                                  │ │
│ │          │ │                                                  │ │
│ │          │ │                                                  │ │
│ │  ─────   │ │                                                  │ │
│ │  Logout  │ │                                                  │ │
│ └──────────┘ └─────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────────┘
```

**Sidebar:** `bg-gray-800 text-white` (colapsavel para 64px com apenas icones)
**Header:** `bg-white shadow-sm border-b border-gray-200`
**Content:** `bg-gray-50 min-h-[calc(100vh-56px)]`

---

## Navegacao por Perfil

### Admin
- Dashboard
- Produtos
- Estoque
- Vendas
- Clientes
- Usuarios
- Relatorios
- Configuracoes

### Vendedor
- PDV (Nova Venda)
- Minhas Vendas
- Meus Clientes
- Meu Perfil

---

## Atalhos de Teclado

### Globais
- `Ctrl+K` - Busca global
- `Ctrl+N` - Novo (produto/cliente/venda)
- `Escape` - Fechar modal/dropdown
- `?` - Abrir modal de atalhos

### PDV
- `F2` - Focar busca de produto
- `F4` - Selecionar cliente
- `F8` - Aplicar desconto
- `F12` - Finalizar venda
- `Esc` - Cancelar venda atual
- `↑↓` - Navegar itens da venda
- `Del` - Remover item selecionado

---

## Responsividade

### Breakpoints

| Breakpoint | Largura | Uso |
|------------|---------|-----|
| `sm` | 640px | Mobile (nao prioritario) |
| `md` | 768px | Tablet (conferencia de estoque) |
| `lg` | 1024px | Laptop |
| `xl` | 1280px | Desktop (uso principal) |
| `2xl` | 1536px | Monitores grandes |

### Adaptacoes

**Desktop (xl+):**
- Sidebar expandida (240px)
- PDV com painel lateral fixo
- Tabelas com todas as colunas
- Dashboard com 4 cards por linha

**Tablet (md-lg):**
- Sidebar colapsada (64px, apenas icones)
- PDV com painel abaixo (scroll)
- Tabelas com colunas essenciais
- Dashboard com 2 cards por linha

**Mobile (sm-md):**
- Sidebar como drawer (hamburger menu)
- PDV simplificado
- Tabelas como cards empilhados
- Dashboard com 1 card por linha

---

## Acessibilidade (WCAG 2.1 AA)

### Contraste

- Texto primario `#212529` em `#F8F9FA` = 15.4:1
- Primary `#2D5F4A` em branco = 7.2:1
- Para textos em Accent, usar Accent-Dark `#B8722E` (4.6:1)

### Tamanhos de Toque

- Area minima: 44x44px
- Botoes base: min-height 44px
- Inputs: min-height 44px
- Linhas de tabela: min-height 48px

### Focus Visible

```css
:focus-visible {
    outline: 2px solid #2D5F4A;
    outline-offset: 2px;
}
```

---

## Micro-interacoes

### Transicoes

```css
/* Padrao */
transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);

/* Hover em cards */
hover: shadow-md transform translateY(-1px);

/* Hover em botoes */
hover: brightness(95%);
active: transform scale(0.98);

/* Sidebar colapsar */
transition: width 300ms ease-in-out;
```

### Loading States

- **Skeleton Screen:** Para tabelas e listas
- **Spinner inline:** Para botoes durante acao
- **Progress bar:** Para uploads
- **Toast:** Para feedback de acoes

### Toasts

- Posicao: top-right
- Duracao: 3s (sucesso), 5s (warning), persistente (error)
- Animacao: slide-in da direita, fade-out ao fechar

### PDV Especifico

- Item adicionado: flash verde sutil na linha (200ms)
- Total atualizado: numeros animam com contagem rapida (300ms)
- Pagamento confirmado: overlay + modal de sucesso com checkmark
- Busca de produto: resultados com fade-in staggered (50ms cada)

---

## Categorias Pre-definidas de Produtos

1. **Construcao** - cimento, areia, brita, argamassa
2. **Ceramica** - tijolos, blocos, telhas
3. **Tintas** - tintas, solventes, acessorios pintura
4. **Hidraulica** - tubos, conexoes, registros
5. **Eletrica** - fios, disjuntores, tomadas
6. **Ferramentas** - manuais, eletricas, EPIs
7. **Acabamento** - pisos, revestimentos, loucas
8. **Metais** - ferro, aco, vergalhoes
