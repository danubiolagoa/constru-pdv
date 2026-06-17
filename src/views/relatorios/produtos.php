<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Produtos</h1>
        <p class="text-gray-600 mt-1">Produtos mais vendidos e estoque</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="/relatorios/produtos" class="flex flex-wrap gap-4 items-end">
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Produtos Mais Vendidos</h2>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Produto</th>
                        <th class="px-6 py-3 text-right">Qtd Vendida</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($maisVendidos ?? [] as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium"><?= e($item['produto_nome'] ?? $item['nome'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-right"><?= e($item['quantidade'] ?? 0) ?></td>
                        <td class="px-6 py-4 text-right font-medium">
                            R$ <?= e(number_format((float) ($item['total'] ?? 0), 2, ',', '.')) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($maisVendidos)): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            Nenhuma venda no período.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Estoque Atual</h2>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Produto</th>
                        <th class="px-6 py-3 text-right">Estoque</th>
                        <th class="px-6 py-3 text-right">Preço</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($estoqueAtual ?? [] as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium"><?= e($item['nome'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-right"><?= e($item['estoque'] ?? 0) ?></td>
                        <td class="px-6 py-4 text-right">
                            R$ <?= e(number_format((float) ($item['preco_venda'] ?? 0), 2, ',', '.')) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($estoqueAtual)): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            Nenhum produto cadastrado.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
