<?php

namespace App\Middleware;

use App\Session;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Voce precisa estar logado para acessar esta pagina.');
            header('Location: /login');
            exit;
        }

        return true;
    }
}
