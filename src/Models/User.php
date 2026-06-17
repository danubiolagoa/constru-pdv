<?php

namespace App\Models;

use App\Database;

class User
{
    public static function findByEmail(string $email): array|false
    {
        return Database::fetch(
            'SELECT * FROM usuarios WHERE email = ? AND ativo = true',
            [$email]
        );
    }

    public static function findById(int $id): array|false
    {
        return Database::fetch(
            'SELECT * FROM usuarios WHERE id = ?',
            [$id]
        );
    }

    public static function all(): array
    {
        return Database::fetchAll(
            'SELECT id, nome, email, role, ativo, created_at FROM usuarios ORDER BY nome'
        );
    }

    public static function create(array $data): int|false
    {
        $data['senha_hash'] = password_hash($data['senha'], PASSWORD_BCRYPT);
        unset($data['senha']);

        return Database::insert('usuarios', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha_hash' => $data['senha_hash'],
            'role' => $data['role'] ?? 'vendedor',
            'ativo' => true,
        ]);
    }

    public static function update(int $id, array $data): int
    {
        if (!empty($data['senha'])) {
            $data['senha_hash'] = password_hash($data['senha'], PASSWORD_BCRYPT);
            unset($data['senha']);
        }

        unset($data['id'], $data['created_at']);

        return Database::update('usuarios', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::update('usuarios', ['ativo' => false], 'id = ?', [$id]);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function countByRole(string $role): int
    {
        $result = Database::fetch(
            'SELECT COUNT(*) as total FROM usuarios WHERE role = ? AND ativo = true',
            [$role]
        );
        return (int) ($result['total'] ?? 0);
    }
}
