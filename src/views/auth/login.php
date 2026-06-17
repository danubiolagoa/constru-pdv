<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-primary mb-4">
            <i data-lucide="hard-hat" class="w-8 h-8 text-white"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-700">Constru-PDV</h1>
        <p class="text-gray-500 mt-1">Sistema de Vendas</p>
    </div>

    <div class="bg-white rounded-xl shadow-xl p-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Entrar</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-danger/10 text-danger px-4 py-3 rounded-md mb-4 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span class="text-sm"><?= e($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="email" class="label">Email</label>
                <div class="relative">
                    <i data-lucide="mail" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" id="email" name="email" value="<?= e(old('email', 'admin@construpdv.com')) ?>"
                           class="input pl-10" placeholder="seu@email.com" required autofocus>
                </div>
            </div>

            <div>
                <label for="senha" class="label">Senha</label>
                <div class="relative">
                    <i data-lucide="lock" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" id="senha" name="senha" value="admin123"
                           class="input pl-10 pr-10" placeholder="Sua senha" required>
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i data-lucide="eye" class="w-4 h-4" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="lembrar" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="text-sm text-gray-600">Lembrar-me</span>
                </label>
            </div>

            <button type="submit" class="btn-primary w-full btn-lg">
                Entrar
            </button>
        </form>
    </div>

    <p class="text-center text-sm text-gray-400 mt-6">
        Constru-PDV &copy; <?= date('Y') ?>
    </p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const toggle = document.getElementById('togglePassword');
        const senhaInput = document.getElementById('senha');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggle) {
            toggle.addEventListener('click', function() {
                const type = senhaInput.type === 'password' ? 'text' : 'password';
                senhaInput.type = type;
                eyeIcon.setAttribute('data-lucide', type === 'password' ? 'eye' : 'eye-off');
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        }
    });
</script>
