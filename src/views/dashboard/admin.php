<?php $isAdmin = $user['role'] === 'admin'; ?>

<?php if ($isAdmin): ?>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="dollar-sign" class="w-6 h-6 text-success"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Vendas Hoje</p>
            <p class="text-2xl font-bold text-gray-700"><?= format_money($vendasHoje['valor'] ?? 0) ?></p>
            <p class="text-xs text-gray-400 mt-1"><?= $vendasHoje['total'] ?? 0 ?> vendas</p>
        </div>
    </div>

    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="calendar" class="w-6 h-6 text-info"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Vendas no Mes</p>
            <p class="text-2xl font-bold text-gray-700"><?= format_money($vendasMes['valor'] ?? 0) ?></p>
            <p class="text-xs text-gray-400 mt-1"><?= $vendasMes['total'] ?? 0 ?> vendas</p>
        </div>
    </div>

    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="package" class="w-6 h-6 text-accent"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Produtos Ativos</p>
            <p class="text-2xl font-bold text-gray-700"><?= number_format($totalProdutos['total'] ?? 0) ?></p>
        </div>
    </div>

    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="users" class="w-6 h-6 text-primary"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Clientes</p>
            <p class="text-2xl font-bold text-gray-700"><?= number_format($totalClientes['total'] ?? 0) ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card lg:col-span-2">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="trending-up" class="w-5 h-5 text-primary"></i>
            Vendas - Ultimos 7 dias
        </h3>
        <canvas id="vendasChart" height="200"></canvas>
    </div>

    <div class="card">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-5 h-5 text-accent"></i>
            Formas de Pagamento
        </h3>
        <canvas id="pagamentoChart" height="200" class="mx-auto max-w-[220px]"></canvas>
        <div id="pagamentoLegenda" class="mt-4 space-y-2 text-sm"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="alert-triangle" class="w-5 h-5 text-warning"></i>
            Estoque Baixo
        </h3>
        <?php if (empty($estoqueBaixo)): ?>
            <div class="empty-state py-6">
                <i data-lucide="check-circle" class="w-8 h-8 text-success mb-2"></i>
                <p class="text-sm text-gray-500">Estoque em dia!</p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($estoqueBaixo as $produto): ?>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-700"><?= e($produto['nome']) ?></p>
                            <p class="text-xs text-gray-500">Min: <?= $produto['estoque_minimo'] ?></p>
                        </div>
                        <span class="badge-danger"><?= $produto['estoque_atual'] ?> un</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-info"></i>
            Top Produtos
        </h3>
        <canvas id="topProdutosChart" height="180"></canvas>
    </div>

    <div class="card">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="activity" class="w-5 h-5 text-success"></i>
            Metas do Dia
        </h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Meta de Vendas</span>
                    <span class="font-semibold">
                        <?= format_money($vendasHoje['valor'] ?? 0) ?> / R$ 1.000,00
                    </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-primary h-3 rounded-full transition-all duration-500" style="width: <?= min(100, (($vendasHoje['valor'] ?? 0) / 1000) * 100) ?>%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1"><?= round(min(100, (($vendasHoje['valor'] ?? 0) / 1000) * 100)) ?>% concluido</p>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Ticket Medio</span>
                    <span class="font-semibold">
                        R$ <?= number_format($vendasMes['total'] > 0 ? ($vendasMes['valor'] / $vendasMes['total']) : 0, 2, ',', '.') ?>
                    </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-accent h-3 rounded-full transition-all duration-500" style="width: <?= min(100, ($vendasMes['total'] > 0 ? ($vendasMes['valor'] / $vendasMes['total']) : 0) / 100 * 100) ?>%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($topProdutos)): ?>
<div class="card">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i data-lucide="trophy" class="w-5 h-5 text-accent"></i>
        Top 5 Produtos do Mes
    </h3>
    <div class="space-y-3">
        <?php foreach ($topProdutos as $i => $produto): ?>
            <div class="flex items-center gap-4">
                <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">
                    <?= $i + 1 ?>
                </span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-700"><?= e($produto['nome']) ?></p>
                    <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                        <div class="bg-primary h-2 rounded-full" style="width: <?= ($produto['total_valor'] / max(array_column($topProdutos, 'total_valor')) * 100) ?>%"></div>
                    </div>
                </div>
                <span class="text-sm font-mono font-semibold text-gray-700"><?= format_money($produto['total_valor']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const vendasCtx = document.getElementById('vendasChart');
    if (vendasCtx && typeof Chart !== 'undefined') {
        const vendasData = <?= json_encode($vendasSemana) ?>;
        const labels = vendasData.map(v => {
            const d = new Date(v.data + 'T12:00:00');
            return d.toLocaleDateString('pt-BR', { weekday: 'short', day: '2-digit' });
        });
        const values = vendasData.map(v => parseFloat(v.valor));
        const counts = vendasData.map(v => v.total);

        new Chart(vendasCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Vendas (R$)',
                        data: values,
                        backgroundColor: 'rgba(45, 95, 74, 0.7)',
                        borderColor: '#2D5F4A',
                        borderWidth: 1,
                        borderRadius: 4,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Qtd Vendas',
                        data: counts,
                        backgroundColor: 'rgba(212, 136, 58, 0.6)',
                        borderColor: '#D4883A',
                        borderWidth: 1,
                        borderRadius: 4,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } } },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { callback: v => v + ' vendas' }
                    }
                }
            }
        });
    }

    const pagCtx = document.getElementById('pagamentoChart');
    if (pagCtx && typeof Chart !== 'undefined') {
        const pagData = <?= json_encode($pagamentos ?? []) ?>;
        const colors = ['#2D5F4A', '#D4883A', '#1971C2', '#C92A2A', '#2B8A3E'];
        const labels = pagData.map(v => v.forma_pagamento);
        const values = pagData.map(v => parseFloat(v.valor));

        new Chart(pagCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors.slice(0, labels.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                }
            }
        });

        const legenda = document.getElementById('pagamentoLegenda');
        if (legenda) {
            const total = values.reduce((a, b) => a + b, 0);
            pagData.forEach((v, i) => {
                const pct = total > 0 ? ((v.valor / total) * 100).toFixed(1) : 0;
                legenda.innerHTML += `
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full" style="background:${colors[i]}"></span>
                            <span class="text-gray-600 capitalize">${v.forma_pagamento.replace('_', ' ')}</span>
                        </div>
                        <span class="font-medium">${pct}%</span>
                    </div>`;
            });
        }
    }

    const topCtx = document.getElementById('topProdutosChart');
    if (topCtx && typeof Chart !== 'undefined') {
        const topData = <?= json_encode($topProdutos) ?>;
        const topLabels = topData.map(v => v.nome.length > 15 ? v.nome.substring(0, 15) + '...' : v.nome);
        const topValues = topData.map(v => parseFloat(v.total_valor));

        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels: topLabels,
                datasets: [{
                    label: 'Valor (R$)',
                    data: topValues,
                    backgroundColor: 'rgba(45, 95, 74, 0.6)',
                    borderColor: '#2D5F4A',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') } },
                    y: { ticks: { font: { size: 11 } } }
                }
            }
        });
    }
});
</script>

<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="dollar-sign" class="w-6 h-6 text-success"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Minhas Vendas Hoje</p>
            <p class="text-2xl font-bold text-gray-700"><?= format_money($vendasHoje['valor'] ?? 0) ?></p>
            <p class="text-xs text-gray-400 mt-1"><?= $vendasHoje['total'] ?? 0 ?> vendas</p>
        </div>
    </div>

    <div class="card-metric">
        <div class="w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center flex-shrink-0">
            <i data-lucide="calendar" class="w-6 h-6 text-info"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Minhas Vendas no Mes</p>
            <p class="text-2xl font-bold text-gray-700"><?= format_money($vendasMes['valor'] ?? 0) ?></p>
            <p class="text-xs text-gray-400 mt-1"><?= $vendasMes['total'] ?? 0 ?> vendas</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="empty-state">
        <i data-lucide="shopping-cart" class="w-12 h-12 text-gray-300 mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-600 mb-2">Pronto para vender?</h3>
        <p class="text-gray-500 mb-4">Acesse a area de vendas para registrar uma nova venda.</p>
        <a href="/vendas" class="btn-accent btn-lg">
            <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i>
            Nova Venda
        </a>
    </div>
</div>
<?php endif; ?>
