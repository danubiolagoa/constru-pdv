<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$user = \App\Session::user();
$isAdmin = $user && $user['role'] === 'admin';

$navItems = $isAdmin ? [
    '/dashboard' => ['icon' => 'layout-dashboard', 'label' => 'Dashboard'],
    '/produtos' => ['icon' => 'package', 'label' => 'Produtos'],
    '/estoque' => ['icon' => 'warehouse', 'label' => 'Estoque'],
    '/vendas' => ['icon' => 'shopping-cart', 'label' => 'Vendas'],
    '/clientes' => ['icon' => 'users', 'label' => 'Clientes'],
    '/usuarios' => ['icon' => 'user-cog', 'label' => 'Usuarios'],
    '/relatorios' => ['icon' => 'bar-chart-3', 'label' => 'Relatorios'],
    '/configuracoes' => ['icon' => 'settings', 'label' => 'Configuracoes'],
] : [
    '/dashboard' => ['icon' => 'layout-dashboard', 'label' => 'Dashboard'],
    '/vendas' => ['icon' => 'shopping-cart', 'label' => 'PDV / Vendas'],
    '/clientes' => ['icon' => 'users', 'label' => 'Clientes'],
];
?>

<aside id="sidebar" class="sidebar">
    <div class="flex items-center gap-3 px-4 py-5 border-b border-gray-700">
        <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
            <i data-lucide="hard-hat" class="w-5 h-5 text-white"></i>
        </div>
        <span class="font-bold text-lg tracking-tight sidebar-label">Constru-PDV</span>
    </div>

    <nav class="mt-4 flex flex-col gap-1 px-2">
        <?php foreach ($navItems as $path => $item): ?>
            <?php $isActive = $currentPath === $path || str_starts_with($currentPath, $path . '/'); ?>
            <a href="<?= $path ?>" class="sidebar-item <?= $isActive ? 'active' : '' ?>">
                <i data-lucide="<?= $item['icon'] ?>" class="w-5 h-5 flex-shrink-0"></i>
                <span class="sidebar-label"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
