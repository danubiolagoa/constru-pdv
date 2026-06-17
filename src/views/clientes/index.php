<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Clientes</h1>
            <p class="text-sm text-gray-500">Gerencie seus clientes</p>
        </div>
        <a href="/clientes/novo" class="btn-primary">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Novo Cliente
        </a>
    </div>

    <div class="card">
        <form method="GET" action="/clientes" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="busca" value="<?= e($busca ?? '') ?>" placeholder="Buscar por nome, CPF/CNPJ ou email..." class="input">
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($clientes)): ?>
            <div class="col-span-full card py-12 text-center text-gray-500">
                <i data-lucide="users" class="w-12 h-12 mx-auto text-gray-300 mb-4"></i>
                <p>Nenhum cliente encontrado.</p>
            </div>
        <?php else: ?>
            <?php foreach ($clientes as $cliente): ?>
                <div class="card hover:shadow-lg transition-all duration-200 group">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary to-primary/70 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-white font-bold text-lg">
                                <?= strtoupper(substr($cliente['nome'], 0, 2)) ?>
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?= e($cliente['nome']) ?></h3>
                            <p class="text-sm text-gray-500 font-mono"><?= e($cliente['cpf_cnpj'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2.5">
                        <?php if (!empty($cliente['telefone'])): ?>
                            <div class="flex items-center gap-3 text-sm text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                <i data-lucide="phone" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                                <span><?= e($cliente['telefone']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($cliente['email'])): ?>
                            <div class="flex items-center gap-3 text-sm text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                <i data-lucide="mail" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                                <span class="truncate"><?= e($cliente['email']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Total de Compras</p>
                            <p class="text-lg font-bold text-primary"><?= format_money($cliente['total_compras'] ?? 0) ?></p>
                        </div>
                        <div class="flex gap-1">
                            <a href="/clientes/editar/<?= e($cliente['id']) ?>" class="btn-icon btn-ghost text-primary hover:bg-primary/10" title="Editar">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="/clientes/excluir/<?= e($cliente['id']) ?>" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-icon btn-ghost text-danger hover:bg-danger/10" title="Excluir">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
