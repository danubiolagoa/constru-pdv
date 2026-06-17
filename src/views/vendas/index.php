<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas - Constru-PDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D5F4A',
                        accent: '#D4883A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Histórico de Vendas</h1>
                <a href="/vendas/nova" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-medium transition">
                    + Nova Venda
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="/vendas" class="flex flex-wrap gap-4">
                    <div class="w-48">
                        <input type="date" name="data_inicio" value="<?= e($dataInicio ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="w-48">
                        <input type="date" name="data_fim" value="<?= e($dataFim ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="w-48">
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Todos Status</option>
                            <option value="concluida" <?= ($status ?? '') == 'concluida' ? 'selected' : '' ?>>Concluída</option>
                            <option value="pendente" <?= ($status ?? '') == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                            <option value="cancelada" <?= ($status ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg font-medium transition">
                        Filtrar
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagamento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($vendas)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    Nenhuma venda encontrada.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($vendas as $venda): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">#<?= e($venda['id']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('d/m/Y H:i', strtotime($venda['created_at'])) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= e($venda['cliente_nome'] ?? '-') ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= e($venda['vendedor_nome'] ?? '-') ?></td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= format_money($venda['total']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= e($venda['forma_pagamento'] ?? '-') ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($venda['status'] == 'concluida'): ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Concluída</span>
                                        <?php elseif ($venda['status'] == 'pendente'): ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pendente</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Cancelada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="/vendas/<?= e($venda['id']) ?>" class="text-primary hover:text-primary/80 font-medium">Ver Detalhes</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
