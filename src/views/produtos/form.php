<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($produto) ? 'Editar' : 'Novo' ?> Produto - Constru-PDV</title>
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
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <?= isset($produto) ? 'Editar Produto' : 'Novo Produto' ?>
                </h1>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="<?= isset($produto) ? '/produtos/atualizar/' . e($produto['id']) : '/produtos/salvar' ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Produto</label>
                            <input type="text" name="nome" value="<?= e(old('nome', $produto['nome'] ?? '')) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea name="descricao" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"><?= e(old('descricao', $produto['descricao'] ?? '')) ?></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                            <select name="categoria_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Selecione...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= e($cat['id']) ?>" <?= old('categoria_id', $produto['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                        <?= e($cat['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                            <input type="text" name="sku" value="<?= e(old('sku', $produto['sku'] ?? '')) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preço de Venda</label>
                            <input type="text" name="preco_venda" value="<?= e(old('preco_venda', isset($produto['preco_venda']) ? number_format($produto['preco_venda'], 2, ',', '.') : '')) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="0,00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unidade de Medida</label>
                            <select name="unidade_medida" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="un" <?= old('unidade_medida', $produto['unidade_medida'] ?? '') == 'un' ? 'selected' : '' ?>>Unidade (un)</option>
                                <option value="kg" <?= old('unidade_medida', $produto['unidade_medida'] ?? '') == 'kg' ? 'selected' : '' ?>>Quilograma (kg)</option>
                                <option value="m2" <?= old('unidade_medida', $produto['unidade_medida'] ?? '') == 'm2' ? 'selected' : '' ?>>Metro Quadrado (m²)</option>
                                <option value="m3" <?= old('unidade_medida', $produto['unidade_medida'] ?? '') == 'm3' ? 'selected' : '' ?>>Metro Cúbico (m³)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estoque Atual</label>
                            <input type="number" name="estoque_atual" value="<?= e(old('estoque_atual', $produto['estoque_atual'] ?? '0')) ?>" required min="0" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estoque Mínimo</label>
                            <input type="number" name="estoque_minimo" value="<?= e(old('estoque_minimo', $produto['estoque_minimo'] ?? '0')) ?>" required min="0" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Código de Barras</label>
                            <input type="text" name="codigo_barras" value="<?= e(old('codigo_barras', $produto['codigo_barras'] ?? '')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto do Produto</label>
                            <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <?php if (isset($produto['foto']) && !empty($produto['foto'])): ?>
                                <div class="mt-2">
                                    <img src="<?= e($produto['foto']) ?>" alt="Foto atual" class="w-20 h-20 object-cover rounded">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="/produtos" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg font-medium transition">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
