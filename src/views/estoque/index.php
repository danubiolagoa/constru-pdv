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

    <div class="card overflow-x-auto">
        <table class="table-base w-full">
            <thead>
                <tr>
                    <th class="min-w-[200px]">Produto</th>
                    <th class="text-right whitespace-nowrap">Estoque Atual</th>
                    <th class="text-right whitespace-nowrap hidden md:table-cell">Estoque Minimo</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-8">Nenhum produto encontrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <?php
                            $estoqueAtual = (float)$produto['estoque_atual'];
                            $estoqueMinimo = (float)$produto['estoque_minimo'];
                            $ratio = $estoqueMinimo > 0 ? $estoqueAtual / $estoqueMinimo : 999;
                            $statusClass = $ratio <= 1 ? 'badge-danger' : ($ratio <= 1.5 ? 'badge-warning' : 'badge-success');
                            $statusText = $ratio <= 1 ? 'Critico' : ($ratio <= 1.5 ? 'Baixo' : 'Normal');
                        ?>
                        <tr class="<?= $ratio <= 1 ? 'bg-danger/5' : '' ?>">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full flex-shrink-0 <?= $statusClass === 'badge-danger' ? 'bg-red-600' : ($statusClass === 'badge-warning' ? 'bg-yellow-500' : 'bg-green-500') ?>"></div>
                                    <span class="font-medium text-gray-800 truncate"><?= e($produto['nome']) ?></span>
                                </div>
                            </td>
                            <td class="text-right font-semibold whitespace-nowrap <?= $ratio <= 1 ? 'text-danger' : ($ratio <= 1.5 ? 'text-warning' : 'text-gray-800') ?>">
                                <?= e((string)$produto['estoque_atual']) ?>
                            </td>
                            <td class="text-right text-gray-500 whitespace-nowrap hidden md:table-cell"><?= e((string)$produto['estoque_minimo']) ?></td>
                            <td><span class="<?= $statusClass ?>"><?= $statusText ?></span></td>
                            <td>
                                <div class="flex gap-2 whitespace-nowrap">
                                    <button type="button" class="btn-primary btn-sm" data-movimentacao="entrada" data-produto-id="<?= e((string)$produto['id']) ?>" data-produto-nome="<?= e($produto['nome']) ?>">
                                        <i data-lucide="plus" class="w-3.5 h-3.5 mr-1"></i>Entrada
                                    </button>
                                    <button type="button" class="btn-danger btn-sm" data-movimentacao="saida" data-produto-id="<?= e((string)$produto['id']) ?>" data-produto-nome="<?= e($produto['nome']) ?>">
                                        <i data-lucide="minus" class="w-3.5 h-3.5 mr-1"></i>Saida
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
