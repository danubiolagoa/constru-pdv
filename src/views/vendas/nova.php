<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Nova Venda</h1>
        <a href="/vendas" class="btn-outline">Voltar</a>
    </div>

    <form id="form-venda" method="POST" action="/vendas" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="itens" id="itens-input">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Produtos</h2>
                    <input type="text" id="busca-produto" placeholder="Buscar produto por nome ou SKU..."
                           class="input w-full mb-4">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="table-base">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-right">Preco</th>
                                    <th class="text-right">Estoque</th>
                                    <th class="w-24">Qtd</th>
                                    <th class="w-20"></th>
                                </tr>
                            </thead>
                            <tbody id="lista-produtos">
                                <?php foreach ($produtos as $p): ?>
                                <tr class="hover:bg-gray-50 produto-row" data-id="<?= e($p['id']) ?>"
                                    data-nome="<?= e($p['nome']) ?>" data-preco="<?= e($p['preco_venda']) ?>"
                                    data-unidade="<?= e($p['unidade_medida']) ?>">
                                    <td>
                                        <p class="font-medium text-gray-800"><?= e($p['nome']) ?></p>
                                        <p class="text-xs text-gray-400"><?= e($p['sku']) ?></p>
                                    </td>
                                    <td class="text-right font-medium"><?= format_money((float)$p['preco_venda']) ?></td>
                                    <td class="text-right text-sm"><?= e($p['estoque_atual']) ?> <?= e($p['unidade_medida']) ?></td>
                                    <td>
                                        <input type="number" min="0" max="<?= e($p['estoque_atual']) ?>" step="0.01"
                                               class="input text-sm w-full qtd-input" value="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn-primary btn-sm adicionar-btn w-full"
                                                data-estoque="<?= e($p['estoque_atual']) ?>">
                                            +
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Carrinho</h2>
                    <div class="overflow-x-auto">
                        <table class="table-base">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-right">Qtd</th>
                                    <th class="text-right">Preco Unit.</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="w-16"></th>
                                </tr>
                            </thead>
                            <tbody id="carrinho-body">
                                <tr id="carrinho-vazio">
                                    <td colspan="5" class="text-center text-gray-400 py-8">
                                        Nenhum produto adicionado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Cliente</h2>
                    <select name="cliente_id" class="input w-full">
                        <option value="">Consumidor Final</option>
                        <?php foreach ($clientes as $c): ?>
                        <option value="<?= e($c['id']) ?>"><?= e($c['nome']) ?> (<?= e($c['cpf_cnpj']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumo</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span id="resumo-subtotal" class="font-medium">R$ 0,00</span>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Desconto</label>
                            <input type="text" name="desconto" id="desconto-input" value="0,00"
                                   class="input text-sm w-full">
                        </div>
                        <div class="flex justify-between pt-3 border-t font-bold text-lg">
                            <span>Total</span>
                            <span id="resumo-total" class="text-primary">R$ 0,00</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Pagamento</h2>
                    <select name="forma_pagamento" class="input w-full mb-4">
                        <option value="dinheiro">Dinheiro</option>
                        <option value="credito">Cartao de Credito</option>
                        <option value="debito">Cartao de Debito</option>
                        <option value="pix">PIX</option>
                        <option value="fiado">Fiado</option>
                        <option value="boleto">Boleto</option>
                        <option value="combinado">Combinado</option>
                    </select>
                    <button type="submit" class="btn-primary w-full text-lg py-3">
                        Finalizar Venda
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let carrinho = [];

function formatMoney(valor) {
    return 'R$ ' + valor.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function parseMoney(str) {
    return parseFloat(str.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
}

function atualizarCarrinho() {
    const tbody = document.getElementById('carrinho-body');
    const vazio = document.getElementById('carrinho-vazio');
    let subtotal = 0;

    if (carrinho.length === 0) {
        tbody.innerHTML = '<tr id="carrinho-vazio"><td colspan="5" class="text-center text-gray-400 py-8">Nenhum produto adicionado</td></tr>';
        document.getElementById('resumo-subtotal').textContent = 'R$ 0,00';
        document.getElementById('resumo-total').textContent = 'R$ 0,00';
        document.getElementById('itens-input').value = '[]';
        return;
    }

    let html = '';
    carrinho.forEach((item, idx) => {
        const st = item.quantidade * item.preco;
        subtotal += st;
        html += '<tr>' +
            '<td class="font-medium text-gray-800">' + item.nome + '</td>' +
            '<td class="text-right">' + item.quantidade + '</td>' +
            '<td class="text-right">' + formatMoney(item.preco) + '</td>' +
            '<td class="text-right font-medium">' + formatMoney(st) + '</td>' +
            '<td><button type="button" class="btn-danger btn-sm" onclick="removerItem(' + idx + ')">x</button></td>' +
            '</tr>';
    });
    tbody.innerHTML = html;

    const desc = parseMoney(document.getElementById('desconto-input').value);
    const total = Math.max(0, subtotal - desc);
    document.getElementById('resumo-subtotal').textContent = formatMoney(subtotal);
    document.getElementById('resumo-total').textContent = formatMoney(total);
    document.getElementById('itens-input').value = JSON.stringify(
        carrinho.map(i => ({
            produto_id: i.id,
            quantidade: i.quantidade,
            preco_unitario: i.preco,
            subtotal: i.quantidade * i.preco
        }))
    );
}

function removerItem(idx) {
    carrinho.splice(idx, 1);
    atualizarCarrinho();
}

document.querySelectorAll('.adicionar-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('.produto-row');
        const qtdInput = row.querySelector('.qtd-input');
        const qtd = parseFloat(qtdInput.value) || 0;
        const maxEstoque = parseFloat(this.dataset.estoque) || 0;

        if (qtd <= 0) { alert('Informe uma quantidade valida.'); return; }
        if (qtd > maxEstoque) { alert('Estoque insuficiente. Max: ' + maxEstoque); return; }

        const id = parseInt(row.dataset.id);
        const existente = carrinho.findIndex(i => i.id === id);
        if (existente >= 0) {
            carrinho[existente].quantidade += qtd;
            if (carrinho[existente].quantidade > maxEstoque) {
                alert('Estoque insuficiente no total.');
                carrinho[existente].quantidade -= qtd;
                return;
            }
        } else {
            carrinho.push({
                id: id,
                nome: row.dataset.nome,
                preco: parseFloat(row.dataset.preco),
                quantidade: qtd
            });
        }
        qtdInput.value = 0;
        atualizarCarrinho();
    });
});

document.getElementById('desconto-input').addEventListener('input', atualizarCarrinho);

document.getElementById('busca-produto').addEventListener('input', function() {
    const termo = this.value.toLowerCase();
    document.querySelectorAll('.produto-row').forEach(row => {
        const nome = row.dataset.nome.toLowerCase();
        const id = row.dataset.id;
        row.style.display = nome.includes(termo) || id.includes(termo) ? '' : 'none';
    });
});

document.getElementById('form-venda').addEventListener('submit', function(e) {
    if (carrinho.length === 0) {
        e.preventDefault();
        alert('Adicione pelo menos um produto ao carrinho.');
        return;
    }
});
</script>
