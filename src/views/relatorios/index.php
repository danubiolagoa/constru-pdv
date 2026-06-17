<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Constru-PDV</title>
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
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Relatórios</h1>
                <p class="text-gray-600 mt-1">Gere relatórios detalhados do seu negócio</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Período</h2>
                <form method="GET" action="/relatorios" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                        <input type="date" name="data_inicio" value="<?= e($dataInicio ?? date('Y-m-01')) ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                        <input type="date" name="data_fim" value="<?= e($dataFim ?? date('Y-m-d')) ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg font-medium transition">
                        Aplicar Filtro
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/relatorios/vendas?data_inicio=<?= e($dataInicio ?? date('Y-m-01')) ?>&data_fim=<?= e($dataFim ?? date('Y-m-d')) ?>" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition">
                            <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Relatório de Vendas</h3>
                            <p class="text-sm text-gray-500">Análise detalhada de vendas</p>
                        </div>
                    </div>
                </a>

                <a href="/relatorios/produtos?data_inicio=<?= e($dataInicio ?? date('Y-m-01')) ?>&data_fim=<?= e($dataFim ?? date('Y-m-d')) ?>" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-accent/10 rounded-full flex items-center justify-center group-hover:bg-accent/20 transition">
                            <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Relatório de Produtos</h3>
                            <p class="text-sm text-gray-500">Produtos mais vendidos e estoque</p>
                        </div>
                    </div>
                </a>

                <a href="/relatorios/caixa?data_inicio=<?= e($dataInicio ?? date('Y-m-01')) ?>&data_fim=<?= e($dataFim ?? date('Y-m-d')) ?>" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Relatório de Caixa</h3>
                            <p class="text-sm text-gray-500">Fluxo de caixa e movimentações</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
