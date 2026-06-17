<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class ConfiguracaoController
{
    public function index(): void
    {
        $configs = Database::fetchAll('SELECT * FROM configuracoes');
        $configMap = [];
        foreach ($configs as $c) {
            $configMap[$c['chave']] = $c['valor'];
        }

        $content = render('configuracoes/index', ['configs' => $configMap]);

        layout('app', $content, [
            'title' => 'Configuracoes',
            'user' => Session::user(),
        ]);
    }

    public function store(): void
    {
        $campos = [
            'loja_nome', 'loja_cnpj', 'loja_telefone', 'loja_email',
            'loja_endereco', 'loja_cidade', 'loja_estado', 'loja_cep',
        ];

        foreach ($campos as $campo) {
            $valor = trim($_POST[$campo] ?? '');

            $existe = Database::fetch('SELECT id FROM configuracoes WHERE chave = ?', [$campo]);

            if ($existe) {
                Database::update('configuracoes', [
                    'valor' => $valor,
                    'updated_at' => date('Y-m-d H:i:s'),
                ], 'chave = ?', [$campo]);
            } else {
                Database::insert('configuracoes', [
                    'chave' => $campo,
                    'valor' => $valor,
                ]);
            }
        }

        Session::flash('success', 'Configuracoes salvas com sucesso!');
        redirect('/configuracoes');
    }
}
