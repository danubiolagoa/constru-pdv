<?php

namespace App\Middleware;

use App\Session;

class AdminMiddleware
{
    public function handle(): bool
    {
        if (!Session::isAdmin()) {
            Session::flash('error', 'Acesso negado. Voce precisa ser administrador.');
            header('Location: /dashboard');
            exit;
        }

        return true;
    }
}
