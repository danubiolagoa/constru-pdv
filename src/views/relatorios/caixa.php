<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Caixa</h1>
        <p class="text-gray-600 mt-1">Fluxo de caixa e movimentações</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="/relatorios/caixa" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="text-sm font-medium text-gray-700 mb-1 block">Data Início</label>
                <input type="date" name="data_inicio" value="<?= e($_GET['data_inicio'] ?? date('Y-m-01')) ?>" class="input">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-1 block">Data Fim</label>
                <input type="date" name="data_fim" value="<?= e($_GET['data_fim'] ?? date('Y-m-d')) ?>" class="input">
            </div>
            <button type="submit" class="btn-primary">Filtrar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Total de Vendas</p>
            <p class="text-2xl font-bold text-primary">
                R$ <?= e(number_format((float) ($resumo['total_vendas'] ?? 0), 2, ',', '.')) ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Qtd de Vendas</p>
            <p class="text-2xl font-bold text-gray-800"><?= e($resumo['quantidade'] ?? 0) ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Ticket Médio</p>
            <p class="text-2xl font-bold text-accent">
                R$ <?= e(number_format((float) ($resumo['ticket_medio'] ?? 0), 2, ',', '.')) ?>
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Movimentações</h2>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Data</th>
                    <th class="px-6 py-3">Descrição</th>
                    <th class="px-6 py-3 text-right">Valor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($movimentacoes ?? [] as $mov): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600"><?= e(date('d/m/Y H:i', strtotime($mov['created_at']))) ?></td>
                    <td class="px-6 py-4 font-medium"><?= e($mov['descricao'] ?? $mov['codigo'] ?? '-') ?></td>
                    <td class="px-6 py-4 text-right font-medium text-green-600">
                        + R$ <?= e(number_format((float) ($mov['total'] ?? 0), 2, ',', '.')) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($movimentacoes)): ?>
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                        Nenhuma movimentação no período.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
