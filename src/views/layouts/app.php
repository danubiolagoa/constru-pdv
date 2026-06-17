<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Dashboard') ?> - Constru-PDV</title>
    <link rel="stylesheet" href="/css/output.css">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <link rel="icon" type="image/svg+xml" href="/img/logo.svg">
</head>
<body class="bg-gray-50 min-h-screen">

    <?php require BASE_PATH . '/src/views/components/sidebar.php'; ?>

    <header class="header" style="left: 240px;">
        <div class="flex items-center gap-4">
            <button id="toggleSidebar" class="btn-icon btn-ghost">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <h1 class="text-xl font-semibold text-gray-700"><?= e($title ?? '') ?></h1>
        </div>

        <div class="flex items-center gap-4">
            <?php if ($success = flash('success')): ?>
                <div class="toast-success" id="toast-success">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span><?= e($success) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($error = flash('error')): ?>
                <div class="toast-error" id="toast-error">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                    <span><?= e($error) ?></span>
                </div>
            <?php endif; ?>

            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-sm font-semibold">
                    <?= strtoupper(substr($user['nome'], 0, 1)) ?>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-medium text-gray-700"><?= e($user['nome']) ?></p>
                    <p class="text-xs text-gray-500"><?= e($user['role'] === 'admin' ? 'Administrador' : 'Vendedor') ?></p>
                </div>
                <form action="/logout" method="POST" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-icon btn-ghost text-gray-500 hover:text-danger" title="Sair">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="main-content">
        <?= $content ?>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const toast = document.getElementById('toast-success') || document.getElementById('toast-error');
            if (toast) {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('sidebar-collapsed');
                    const header = document.querySelector('.header');
                    const main = document.querySelector('.main-content');
                    if (sidebar.classList.contains('sidebar-collapsed')) {
                        header.style.left = '64px';
                        main.style.marginLeft = '64px';
                    } else {
                        header.style.left = '240px';
                        main.style.marginLeft = '240px';
                    }
                });
            }
        });
    </script>
</body>
</html>
