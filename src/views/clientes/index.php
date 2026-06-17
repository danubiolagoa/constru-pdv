<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Constru-PDV</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Clientes</h1>
                <a href="/clientes/novo" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-medium transition">
                    + Novo Cliente
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="/clientes" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="busca" value="<?= e($busca ?? '') ?>" placeholder="Buscar por nome, CPF/CNPJ ou email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg font-medium transition">
                        Buscar
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($clientes)): ?>
                    <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center text-gray-500">
                        Nenhum cliente encontrado.
                    </div>
                <?php else: ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-primary font-bold text-lg">
                                        <?= strtoupper(substr($cliente['nome'], 0, 2)) ?>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate"><?= e($cliente['nome']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= e($cliente['cpf_cnpj'] ?? '-') ?></p>
                                </div>
                            </div>
                            
                            <div class="mt-4 space-y-2">
                                <?php if (!empty($cliente['telefone'])): ?>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <?= e($cliente['telefone']) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($cliente['email'])): ?>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="truncate"><?= e($cliente['email']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Total de Compras</p>
                                    <p class="text-lg font-bold text-primary"><?= format_money($cliente['total_compras'] ?? 0) ?></p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="/clientes/editar/<?= e($cliente['id']) ?>" class="text-primary hover:text-primary/80 text-sm font-medium">Editar</a>
                                    <form method="POST" action="/clientes/excluir/<?= e($cliente['id']) ?>" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
