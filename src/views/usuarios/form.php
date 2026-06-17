<?php extract($data ?? []); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($usuario) ? 'Editar' : 'Novo' ?> Usuário - Constru-PDV</title>
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
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <?= isset($usuario) ? 'Editar Usuário' : 'Novo Usuário' ?>
                </h1>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="<?= isset($usuario) ? '/usuarios/atualizar/' . e($usuario['id']) : '/usuarios/salvar' ?>">
                    <?= csrf_field() ?>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                            <input type="text" name="nome" value="<?= e(old('nome', $usuario['nome'] ?? '')) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="<?= e(old('email', $usuario['email'] ?? '')) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Senha <?= isset($usuario) ? '(deixe em branco para manter a atual)' : '' ?>
                            </label>
                            <input type="password" name="senha" <?= isset($usuario) ? '' : 'required' ?> class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Perfil</label>
                            <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="vendedor" <?= old('role', $usuario['role'] ?? '') == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
                                <option value="admin" <?= old('role', $usuario['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="ativo" id="ativo" value="1" <?= old('ativo', $usuario['ativo'] ?? 1) ? 'checked' : '' ?> class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="ativo" class="ml-2 text-sm font-medium text-gray-700">Usuário Ativo</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="/usuarios" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
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
