<?php
$isAdmin = $user['role'] === 'admin';
?>

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

<div class="card-metric mt-6">
    <div class="w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center flex-shrink-0">
        <i data-lucide="calendar" class="w-6 h-6 text-info"></i>
    </div>
    <div>
        <p class="text-sm text-gray-500">Minhas Vendas no Mes</p>
        <p class="text-2xl font-bold text-gray-700"><?= format_money($vendasMes['valor'] ?? 0) ?></p>
        <p class="text-xs text-gray-400 mt-1"><?= $vendasMes['total'] ?? 0 ?> vendas</p>
    </div>
</div>
