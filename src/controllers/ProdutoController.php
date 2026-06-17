<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class ProdutoController
{
    public function index(): void
    {
        $busca = $_GET['busca'] ?? '';
        $categoria = $_GET['categoria'] ?? '';

        $sql = 'SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON c.id = p.categoria_id WHERE p.ativo = true';
        $params = [];

        if ($busca) {
            $sql .= ' AND (p.nome ILIKE ? OR p.sku ILIKE ? OR p.codigo_barras ILIKE ?)';
            $params[] = "%{$busca}%";
            $params[] = "%{$busca}%";
            $params[] = "%{$busca}%";
        }

        if ($categoria) {
            $sql .= ' AND p.categoria_id = ?';
            $params[] = $categoria;
        }

        $sql .= ' ORDER BY p.nome';

        $produtos = Database::fetchAll($sql, $params);
        $categorias = Database::fetchAll('SELECT * FROM categorias ORDER BY nome');

        $content = render('produtos/index', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'busca' => $busca,
            'categoria' => $categoria,
        ]);

        layout('app', $content, [
            'title' => 'Produtos',
            'user' => Session::user(),
        ]);
    }

    public function create(): void
    {
        $categorias = Database::fetchAll('SELECT * FROM categorias ORDER BY nome');

        $content = render('produtos/form', [
            'categorias' => $categorias,
            'produto' => null,
        ]);

        layout('app', $content, [
            'title' => 'Novo Produto',
            'user' => Session::user(),
        ]);
    }

    public function store(): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'sku' => trim($_POST['sku'] ?? '') ?: null,
            'codigo_barras' => trim($_POST['codigo_barras'] ?? '') ?: null,
            'preco_venda' => (float) str_replace(',', '.', $_POST['preco_venda'] ?? 0),
            'unidade_medida' => $_POST['unidade_medida'] ?? 'un',
            'estoque_atual' => (float) str_replace(',', '.', $_POST['estoque_atual'] ?? 0),
            'estoque_minimo' => (float) str_replace(',', '.', $_POST['estoque_minimo'] ?? 0),
            'categoria_id' => !empty($_POST['categoria_id']) ? (int) $_POST['categoria_id'] : null,
        ];

        if (empty($data['nome']) || $data['preco_venda'] <= 0) {
            Session::flash('error', 'Nome e preco sao obrigatorios.');
            $_SESSION['old_input'] = $data;
            redirect('/produtos/novo');
        }

        Database::insert('produtos', $data);

        Session::flash('success', 'Produto cadastrado com sucesso!');
        redirect('/produtos');
    }

    public function edit(string $id): void
    {
        $produto = Database::fetch('SELECT * FROM produtos WHERE id = ?', [$id]);

        if (!$produto) {
            Session::flash('error', 'Produto nao encontrado.');
            redirect('/produtos');
        }

        $categorias = Database::fetchAll('SELECT * FROM categorias ORDER BY nome');

        $content = render('produtos/form', [
            'categorias' => $categorias,
            'produto' => $produto,
        ]);

        layout('app', $content, [
            'title' => 'Editar Produto',
            'user' => Session::user(),
        ]);
    }

    public function update(string $id): void
    {
        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'sku' => trim($_POST['sku'] ?? '') ?: null,
            'codigo_barras' => trim($_POST['codigo_barras'] ?? '') ?: null,
            'preco_venda' => (float) str_replace(',', '.', $_POST['preco_venda'] ?? 0),
            'unidade_medida' => $_POST['unidade_medida'] ?? 'un',
            'estoque_minimo' => (float) str_replace(',', '.', $_POST['estoque_minimo'] ?? 0),
            'categoria_id' => !empty($_POST['categoria_id']) ? (int) $_POST['categoria_id'] : null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (empty($data['nome']) || $data['preco_venda'] <= 0) {
            Session::flash('error', 'Nome e preco sao obrigatorios.');
            redirect("/produtos/{$id}/editar");
        }

        Database::update('produtos', $data, 'id = ?', [$id]);

        Session::flash('success', 'Produto atualizado com sucesso!');
        redirect('/produtos');
    }

    public function destroy(string $id): void
    {
        Database::update('produtos', ['ativo' => false], 'id = ?', [$id]);

        Session::flash('success', 'Produto removido com sucesso!');
        redirect('/produtos');
    }
}
