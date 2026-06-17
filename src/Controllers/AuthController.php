<?php

namespace App\Controllers;

use App\Models\User;
use App\Session;

class AuthController
{
    public function showLogin(): void
    {
        $error = Session::flash('error');
        $content = render('auth/login', [
            'error' => $error,
        ]);
        layout('auth', $content);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $lembrar = isset($_POST['lembrar']);

        if (empty($email) || empty($senha)) {
            Session::flash('error', 'Preencha todos os campos.');
            $_SESSION['old_input'] = ['email' => $email];
            redirect('/login');
        }

        $user = User::findByEmail($email);

        if (!$user || !User::verifyPassword($senha, $user['senha_hash'])) {
            Session::flash('error', 'Email ou senha incorretos.');
            $_SESSION['old_input'] = ['email' => $email];
            redirect('/login');
        }

        if (!$user['ativo']) {
            Session::flash('error', 'Sua conta esta desativada.');
            redirect('/login');
        }

        Session::regenerate();
        Session::set('user', [
            'id' => $user['id'],
            'nome' => $user['nome'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);

        if ($lembrar) {
            $lifetime = (int) env('SESSION_LIFETIME', 28800);
            session_set_cookie_params($lifetime);
        }

        redirect('/dashboard');
    }

    public function logout(): void
    {
        Session::destroy();
        redirect('/login');
    }
}
