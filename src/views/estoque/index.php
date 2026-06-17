<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Controle de Estoque</h1>
            <p class="text-sm text-gray-500">Acompanhe saldos, entradas, saidas e alertas.</p>
        </div>
        <a href="/estoque/historico" class="btn-outline">Ver Historico</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="card-metric">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-primary"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total de Itens</p>
                <p class="text-2xl font-bold text-gray-800"><?= e((string)($totalItens['total'] ?? 0)) ?></p>
            </div>
        </div>

        <div class="card-metric">
            <div class="w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center">
                <i data-lucide="arrow-up" class="w-6 h-6 text-success"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Entradas Hoje</p>
                <p class="text-2xl font-bold text-success"><?= e((string)($entradaHoje['total'] ?? 0)) ?></p>
            </div>
        </div>

        <div class="card-metric">
            <div class="w-12 h-12 rounded-lg bg-danger/10 flex items-center justify-center">
                <i data-lucide="arrow-down" class="w-6 h-6 text-danger"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Saidas Hoje</p>
                <p class="text-2xl font-bold text-danger"><?= e((string)($saidaHoje['total'] ?? 0)) ?></p>
            </div>
        </div>

        <div class="card-metric">
            <div class="w-12 h-12 rounded-lg bg-warning/10 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-warning"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Estoque Baixo</p>
                <p class="text-2xl font-bold text-warning"><?= e((string)($estoqueBaixo['total'] ?? 0)) ?></p>
            </div>
        </div>
    </div>

    <div class="card">
        <canvas id="estoqueChart" height="200" class="mb-4"></canvas>
    </div>

    <div class="card">
        <form method="GET" action="/estoque" class="flex flex-wrap gap-4">
            <input type="text" name="busca" value="<?= e($busca ?? '') ?>" placeholder="Buscar produto..." class="input flex-1 min-w-[220px]">
            <select name="filtro" class="input w-56">
                <option value="">Todos</option>
                <option value="baixo" <?= ($filtro ?? '') === 'baixo' ? 'selected' : '' ?>>Estoque baixo</option>
            </select>
            <button type="submit" class="btn-primary">Filtrar</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Atual</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Estoque Minimo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acoes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Nenhum produto encontrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <?php
                            $estoqueAtual = (float)$produto['estoque_atual'];
                            $estoqueMinimo = (float)$produto['estoque_minimo'];
                            $ratio = $estoqueMinimo > 0 ? $estoqueAtual / $estoqueMinimo : 999;
                            $statusClass = $ratio <= 1 ? 'Critico' : ($ratio <= 1.5 ? 'Baixo' : 'Normal');
                            $statusTag = $ratio <= 1 ? 'bg-red-100 text-red-800' : ($ratio <= 1.5 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                        ?>
                        <tr class="hover:bg-gray-50 <?= $ratio <= 1 ? 'bg-red-50' : '' ?>">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full flex-shrink-0 <?= $ratio <= 1 ? 'bg-red-600' : ($ratio <= 1.5 ? 'bg-yellow-500' : 'bg-green-500') ?>"></div>
                                    <span class="text-sm font-medium text-gray-900 truncate"><?= e($produto['nome']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap <?= $ratio <= 1 ? 'text-red-700' : ($ratio <= 1.5 ? 'text-yellow-700' : 'text-gray-900') ?>">
                                <?= number_format($produto['estoque_atual'], 2, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right whitespace-nowrap hidden md:table-cell"><?= number_format($produto['estoque_minimo'], 2, ',', '.') ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full <?= $statusTag ?>"><?= $statusText ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button type="button" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-primary text-white hover:bg-primary/90 transition" data-movimentacao="entrada" data-produto-id="<?= e((string)$produto['id']) ?>" data-produto-nome="<?= e($produto['nome']) ?>">
                                        <i data-lucide="plus" class="w-3 h-3 mr-1"></i>Entrada
                                    </button>
                                    <button type="button" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-red-600 text-white hover:bg-red-700 transition" data-movimentacao="saida" data-produto-id="<?= e((string)$produto['id']) ?>" data-produto-nome="<?= e($produto['nome']) ?>">
                                        <i data-lucide="minus" class="w-3 h-3 mr-1"></i>Saida
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('estoqueChart');
    if (ctx && typeof Chart !== 'undefined') {
        <?php
            $prodNomes = array_map(fn($p) => $p['nome'], array_slice($produtos ?? [], 0, 10));
            $prodAtuais = array_map(fn($p) => (float)$p['estoque_atual'], array_slice($produtos ?? [], 0, 10));
            $prodMinimos = array_map(fn($p) => (float)$p['estoque_minimo'], array_slice($produtos ?? [], 0, 10));
        ?>
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($prodNomes) ?>,
                datasets: [
                    {
                        label: 'Atual',
                        data: <?= json_encode($prodAtuais) ?>,
                        backgroundColor: 'rgba(45, 95, 74, 0.7)',
                        borderColor: '#2D5F4A',
                        borderWidth: 1,
                    },
                    {
                        label: 'Minimo',
                        data: <?= json_encode($prodMinimos) ?>,
                        backgroundColor: 'rgba(212, 136, 58, 0.6)',
                        borderColor: '#D4883A',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
</div>

<div id="modal-movimentacao" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-4" id="modal-titulo">Registrar Movimentacao</h3>
        <form method="POST" action="/estoque/movimentar" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="produto_id" id="modal-produto-id">
            <input type="hidden" name="tipo" id="modal-tipo">
            <div>
                <label class="label">Produto</label>
                <p class="font-medium text-gray-800" id="modal-produto-nome"></p>
            </div>
            <div>
                <label class="label">Quantidade</label>
                <input type="number" name="quantidade" min="0.01" step="0.01" required class="input">
            </div>
            <div>
                <label class="label">Motivo</label>
                <textarea name="motivo" rows="3" required class="input" placeholder="Informe o motivo..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="cancelar-movimentacao" class="btn-outline">Cancelar</button>
                <button type="submit" class="btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('[data-movimentacao]').forEach((button) => {
    button.addEventListener('click', () => {
        const modal = document.getElementById('modal-movimentacao');
        document.getElementById('modal-tipo').value = button.dataset.movimentacao;
        document.getElementById('modal-produto-id').value = button.dataset.produtoId;
        document.getElementById('modal-produto-nome').textContent = button.dataset.produtoNome;
        document.getElementById('modal-titulo').textContent = button.dataset.movimentacao === 'entrada' ? 'Registrar Entrada' : 'Registrar Saida';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
});

document.getElementById('cancelar-movimentacao')?.addEventListener('click', () => {
    const modal = document.getElementById('modal-movimentacao');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});
</script>
