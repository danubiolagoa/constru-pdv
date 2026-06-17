<?php

namespace App\Controllers;

use App\Session;

class RelatorioController
{
    public function index(): void
    {
        $content = render('relatorios/index', []);

        layout('app', $content, [
            'title' => 'Relatorios',
            'user' => Session::user(),
        ]);
    }

    public function vendas(): void
    {
        $content = render('relatorios/vendas', []);

        layout('app', $content, [
            'title' => 'Relatorio de Vendas',
            'user' => Session::user(),
        ]);
    }

    public function produtos(): void
    {
        $content = render('relatorios/produtos', []);

        layout('app', $content, [
            'title' => 'Relatorio de Produtos',
            'user' => Session::user(),
        ]);
    }

    public function caixa(): void
    {
        $content = render('relatorios/caixa', []);

        layout('app', $content, [
            'title' => 'Relatorio de Caixa',
            'user' => Session::user(),
        ]);
    }
}
