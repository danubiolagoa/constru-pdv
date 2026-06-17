<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda #<?= e($venda['id']) ?> - Constru-PDV</title>
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
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Venda #<?= e($venda['id']) ?></h1>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Imprimir
                    </button>
                    <?php if ($venda['status'] != 'cancelada' && (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')): ?>
                        <button onclick="document.getElementById('modal-cancelar').classList.remove('hidden')" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">
                            Cancelar Venda
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Número</h3>
                        <p class="text-lg font-semibold text-gray-900">#<?= e($venda['id']) ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Data</h3>
                        <p class="text-lg font-semibold text-gray-900"><?= date('d/m/Y H:i', strtotime($venda['created_at'])) ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Vendedor</h3>
                        <p class="text-lg font-semibold text-gray-900"><?= e($venda['vendedor_nome'] ?? '-') ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Cliente</h3>
                        <p class="text-lg font-semibold text-gray-900"><?= e($venda['cliente_nome'] ?? '-') ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Itens da Venda</h2>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900"><?= e($item['produto_nome']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-right"><?= e($item['quantidade']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-right"><?= format_money($item['preco_unitario']) ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right"><?= format_money($item['subtotal']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumo</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium"><?= format_money($venda['subtotal']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Desconto</span>
                            <span class="font-medium text-red-600">- <?= format_money($venda['desconto'] ?? 0) ?></span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-primary"><?= format_money($venda['total']) ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Pagamentos</h2>
                    <div class="space-y-3">
                        <?php if (empty($pagamentos)): ?>
                            <p class="text-gray-500">Nenhum pagamento registrado.</p>
                        <?php else: ?>
                            <?php foreach ($pagamentos as $pagamento): ?>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900"><?= e($pagamento['forma_pagamento']) ?></p>
                                        <?php if (!empty($pagamento['observacao'])): ?>
                                            <p class="text-sm text-gray-500"><?= e($pagamento['observacao']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <span class="font-bold text-primary"><?= format_money($pagamento['valor']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="flex justify-start">
                <a href="/vendas" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <div id="modal-cancelar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Cancelar Venda</h3>
            <form method="POST" action="/vendas/cancelar/<?= e($venda['id']) ?>">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo do Cancelamento</label>
                    <textarea name="motivo" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Informe o motivo..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modal-cancelar').classList.add('hidden')" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                        Voltar
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Confirmar Cancelamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
