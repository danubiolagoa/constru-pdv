<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Constru-PDV</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Produtos</h1>
                <a href="/produtos/novo" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-medium transition">
                    + Novo Produto
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="/produtos" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="busca" value="<?= e($busca ?? '') ?>" placeholder="Buscar por nome ou SKU..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="w-48">
                        <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Todas Categorias</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= e($cat['id']) ?>" <?= ($categoria ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= e($cat['nome']) ?>
                                </option>
                            <?php endforeach; ?>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($produtos)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    Nenhum produto encontrado.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produtos as $produto): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <?php if (!empty($produto['foto'])): ?>
                                            <img src="<?= e($produto['foto']) ?>" alt="<?= e($produto['nome']) ?>" class="w-12 h-12 object-cover rounded">
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= e($produto['nome']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= e($produto['sku']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= e($produto['categoria_nome'] ?? '-') ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= format_money($produto['preco_venda']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= e($produto['estoque_atual']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $estoqueAtual = $produto['estoque_atual'];
                                        $estoqueMinimo = $produto['estoque_minimo'];
                                        if ($estoqueAtual > $estoqueMinimo * 1.5):
                                        ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Normal</span>
                                        <?php elseif ($estoqueAtual > $estoqueMinimo): ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Baixo</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Crítico</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="/produtos/editar/<?= e($produto['id']) ?>" class="text-primary hover:text-primary/80 font-medium">Editar</a>
                                            <form method="POST" action="/produtos/excluir/<?= e($produto['id']) ?>" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($paginacao)): ?>
                <div class="flex justify-center gap-2 mt-6">
                    <?php if ($paginacao['pagina_atual'] > 1): ?>
                        <a href="?pagina=<?= $paginacao['pagina_atual'] - 1 ?>&busca=<?= e($busca ?? '') ?>&categoria=<?= e($categoria ?? '') ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Anterior</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
                        <a href="?pagina=<?= $i ?>&busca=<?= e($busca ?? '') ?>&categoria=<?= e($categoria ?? '') ?>" class="px-4 py-2 <?= $i == $paginacao['pagina_atual'] ? 'bg-primary text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?> rounded-lg">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($paginacao['pagina_atual'] < $paginacao['total_paginas']): ?>
                        <a href="?pagina=<?= $paginacao['pagina_atual'] + 1 ?>&busca=<?= e($busca ?? '') ?>&categoria=<?= e($categoria ?? '') ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Próxima</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
