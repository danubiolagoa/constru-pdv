<?php

namespace App\Middleware;

class GuestMiddleware
{
    public function handle(): bool
    {
        if (\App\Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }

        return true;
    }
}
