<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Vendas</h1>
        <p class="text-gray-600 mt-1">Análise detalhada de vendas</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="/relatorios/vendas" class="flex flex-wrap gap-4 items-end">
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

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Venda</th>
                    <th class="px-6 py-3">Cliente</th>
                    <th class="px-6 py-3">Data</th>
                    <th class="px-6 py-3 text-right">Valor</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($vendas ?? [] as $venda): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium"><?= e($venda['codigo']) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= e($venda['cliente_nome'] ?? 'Consumidor') ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= e(date('d/m/Y H:i', strtotime($venda['created_at']))) ?></td>
                    <td class="px-6 py-4 text-right font-medium"><?= e('R$ ' . number_format((float) $venda['total'], 2, ',', '.')) ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if ($venda['status'] === 'cancelada'): ?>
                            <span class="badge-danger">Cancelada</span>
                        <?php else: ?>
                            <span class="text-sm font-medium text-green-600">Concluída</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="/vendas/<?= e($venda['id']) ?>" class="text-primary hover:text-primary/80 text-sm font-medium">
                            Detalhes
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($vendas)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        Nenhuma venda encontrada no período.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
