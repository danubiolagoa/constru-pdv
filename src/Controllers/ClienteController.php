<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class ClienteController
{
    public function index(): void
    {
        $busca = $_GET['busca'] ?? '';

        $sql = "SELECT c.*, COALESCE(SUM(v.total), 0) as total_compras
                FROM clientes c
                LEFT JOIN vendas v ON v.cliente_id = c.id AND v.status = 'concluida'";
        $params = [];

        if ($busca) {
            $sql .= ' WHERE c.nome ILIKE ? OR c.cpf_cnpj ILIKE ? OR c.telefone ILIKE ?';
            $params[] = "%{$busca}%";
            $params[] = "%{$busca}%";
            $params[] = "%{$busca}%";
        }

        $sql .= ' GROUP BY c.id ORDER BY c.nome';

        $clientes = Database::fetchAll($sql, $params);

        $content = render('clientes/index', [
            'clientes' => $clientes,
            'busca' => $busca,
        ]);

        layout('app', $content, [
            'title' => 'Clientes',
            'user' => Session::user(),
        ]);
    }

    public function create(): void
    {
        $content = render('clientes/form', ['cliente' => null]);

        layout('app', $content, [
            'title' => 'Novo Cliente',
            'user' => Session::user(),
        ]);
    }

    public function store(): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'cpf_cnpj' => trim($_POST['cpf_cnpj'] ?? '') ?: null,
            'telefone' => trim($_POST['telefone'] ?? '') ?: null,
            'email' => trim($_POST['email'] ?? '') ?: null,
            'endereco' => trim($_POST['endereco'] ?? '') ?: null,
            'limite_credito' => (float) str_replace(',', '.', $_POST['limite_credito'] ?? 0),
        ];

        if (empty($data['nome'])) {
            Session::flash('error', 'Nome e obrigatorio.');
            $_SESSION['old_input'] = $data;
            redirect('/clientes/novo');
        }

        Database::insert('clientes', $data);

        Session::flash('success', 'Cliente cadastrado com sucesso!');
        redirect('/clientes');
    }

    public function edit(string $id): void
    {
        $cliente = Database::fetch('SELECT * FROM clientes WHERE id = ?', [$id]);

        if (!$cliente) {
            Session::flash('error', 'Cliente nao encontrado.');
            redirect('/clientes');
        }

        $content = render('clientes/form', ['cliente' => $cliente]);

        layout('app', $content, [
            'title' => 'Editar Cliente',
            'user' => Session::user(),
        ]);
    }

    public function update(string $id): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'cpf_cnpj' => trim($_POST['cpf_cnpj'] ?? '') ?: null,
            'telefone' => trim($_POST['telefone'] ?? '') ?: null,
            'email' => trim($_POST['email'] ?? '') ?: null,
            'endereco' => trim($_POST['endereco'] ?? '') ?: null,
            'limite_credito' => (float) str_replace(',', '.', $_POST['limite_credito'] ?? 0),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (empty($data['nome'])) {
            Session::flash('error', 'Nome e obrigatorio.');
            redirect("/clientes/{$id}/editar");
        }

        Database::update('clientes', $data, 'id = ?', [$id]);

        Session::flash('success', 'Cliente atualizado com sucesso!');
        redirect('/clientes');
    }

    public function destroy(string $id): void
    {
        Database::delete('clientes', 'id = ?', [$id]);

        Session::flash('success', 'Cliente removido com sucesso!');
        redirect('/clientes');
    }
}
