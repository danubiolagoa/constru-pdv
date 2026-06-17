<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class UsuarioController
{
    public function index(): void
    {
        $usuarios = Database::fetchAll(
            'SELECT id, nome, email, role, ativo, created_at FROM usuarios ORDER BY nome'
        );

        $content = render('usuarios/index', ['usuarios' => $usuarios]);

        layout('app', $content, [
            'title' => 'Usuarios',
            'user' => Session::user(),
        ]);
    }

    public function create(): void
    {
        $content = render('usuarios/form', ['usuario' => null]);

        layout('app', $content, [
            'title' => 'Novo Usuario',
            'user' => Session::user(),
        ]);
    }

    public function store(): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'senha' => $_POST['senha'] ?? '',
            'role' => $_POST['role'] ?? 'vendedor',
        ];

        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            Session::flash('error', 'Todos os campos sao obrigatorios.');
            $_SESSION['old_input'] = $data;
            redirect('/usuarios/novo');
        }

        $existe = Database::fetch('SELECT id FROM usuarios WHERE email = ?', [$data['email']]);
        if ($existe) {
            Session::flash('error', 'Email ja cadastrado.');
            $_SESSION['old_input'] = $data;
            redirect('/usuarios/novo');
        }

        $senhaHash = password_hash($data['senha'], PASSWORD_BCRYPT);

        Database::insert('usuarios', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha_hash' => $senhaHash,
            'role' => $data['role'],
            'ativo' => true,
        ]);

        Session::flash('success', 'Usuario cadastrado com sucesso!');
        redirect('/usuarios');
    }

    public function edit(string $id): void
    {
        $usuario = Database::fetch(
            'SELECT id, nome, email, role, ativo FROM usuarios WHERE id = ?',
            [$id]
        );

        if (!$usuario) {
            Session::flash('error', 'Usuario nao encontrado.');
            redirect('/usuarios');
        }

        $content = render('usuarios/form', ['usuario' => $usuario]);

        layout('app', $content, [
            'title' => 'Editar Usuario',
            'user' => Session::user(),
        ]);
    }

    public function update(string $id): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'vendedor',
            'ativo' => isset($_POST['ativo']),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($_POST['senha'])) {
            $data['senha_hash'] = password_hash($_POST['senha'], PASSWORD_BCRYPT);
        }

        if (empty($data['nome']) || empty($data['email'])) {
            Session::flash('error', 'Nome e email sao obrigatorios.');
            redirect("/usuarios/{$id}/editar");
        }

        Database::update('usuarios', $data, 'id = ?', [$id]);

        Session::flash('success', 'Usuario atualizado com sucesso!');
        redirect('/usuarios');
    }

    public function destroy(string $id): void
    {
        $currentUser = Session::user();

        if ((int) $id === $currentUser['id']) {
            Session::flash('error', 'Voce nao pode desativar sua propria conta.');
            redirect('/usuarios');
        }

        Database::update('usuarios', ['ativo' => false], 'id = ?', [$id]);

        Session::flash('success', 'Usuario desativado com sucesso!');
        redirect('/usuarios');
    }
}
