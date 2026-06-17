<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class EstoqueController
{
    public function index(): void
    {
        $busca = $_GET['busca'] ?? '';
        $filtro = $_GET['filtro'] ?? '';

        $sql = 'SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON c.id = p.categoria_id WHERE p.ativo = true';
        $params = [];

        if ($busca) {
            $sql .= ' AND p.nome ILIKE ?';
            $params[] = "%{$busca}%";
        }

        if ($filtro === 'baixo') {
            $sql .= ' AND p.estoque_atual <= p.estoque_minimo';
        }

        $sql .= ' ORDER BY p.nome';

        $produtos = Database::fetchAll($sql, $params);

        $totalItens = Database::fetch('SELECT COUNT(*) as total, COALESCE(SUM(estoque_atual), 0) as quantidade FROM produtos WHERE ativo = true');

        $entradaHoje = Database::fetch(
            "SELECT COALESCE(SUM(quantidade), 0) as total 
             FROM movimentacoes_estoque 
             WHERE tipo = 'entrada' AND DATE(created_at) = CURRENT_DATE"
        );

        $saidaHoje = Database::fetch(
            "SELECT COALESCE(SUM(quantidade), 0) as total 
             FROM movimentacoes_estoque 
             WHERE tipo = 'saida' AND DATE(created_at) = CURRENT_DATE"
        );

        $estoqueBaixo = Database::fetch(
            'SELECT COUNT(*) as total FROM produtos WHERE estoque_atual <= estoque_minimo AND ativo = true'
        );

        $content = render('estoque/index', [
            'produtos' => $produtos,
            'busca' => $busca,
            'filtro' => $filtro,
            'totalItens' => $totalItens,
            'entradaHoje' => $entradaHoje,
            'saidaHoje' => $saidaHoje,
            'estoqueBaixo' => $estoqueBaixo,
        ]);

        layout('app', $content, [
            'title' => 'Controle de Estoque',
            'user' => Session::user(),
        ]);
    }

    public function movimentar(): void
    {
        $user = Session::user();

        $produtoId = (int) ($_POST['produto_id'] ?? 0);
        $tipo = $_POST['tipo'] ?? '';
        $quantidade = (float) str_replace(',', '.', $_POST['quantidade'] ?? 0);
        $motivo = trim($_POST['motivo'] ?? '');

        if (!$produtoId || !in_array($tipo, ['entrada', 'saida']) || $quantidade <= 0) {
            Session::flash('error', 'Dados invalidos para movimentacao.');
            redirect('/estoque');
        }

        $produto = Database::fetch('SELECT * FROM produtos WHERE id = ?', [$produtoId]);

        if (!$produto) {
            Session::flash('error', 'Produto nao encontrado.');
            redirect('/estoque');
        }

        if ($tipo === 'saida' && $produto['estoque_atual'] < $quantidade) {
            Session::flash('error', 'Estoque insuficiente.');
            redirect('/estoque');
        }

        Database::beginTransaction();

        try {
            $novoEstoque = $tipo === 'entrada'
                ? $produto['estoque_atual'] + $quantidade
                : $produto['estoque_atual'] - $quantidade;

            Database::update('produtos', [
                'estoque_atual' => $novoEstoque,
                'updated_at' => date('Y-m-d H:i:s'),
            ], 'id = ?', [$produtoId]);

            Database::insert('movimentacoes_estoque', [
                'produto_id' => $produtoId,
                'tipo' => $tipo,
                'quantidade' => $quantidade,
                'motivo' => $motivo,
                'usuario_id' => $user['id'],
            ]);

            Database::commit();

            Session::flash('success', 'Estoque atualizado com sucesso!');
        } catch (\Throwable $e) {
            Database::rollback();
            Session::flash('error', 'Erro ao movimentar estoque.');
        }

        redirect('/estoque');
    }

    public function historico(): void
    {
        $produtoId = $_GET['produto_id'] ?? null;

        $sql = "SELECT m.*, p.nome as produto_nome, u.nome as usuario_nome 
                FROM movimentacoes_estoque m 
                JOIN produtos p ON p.id = m.produto_id 
                LEFT JOIN usuarios u ON u.id = m.usuario_id";
        $params = [];

        if ($produtoId) {
            $sql .= ' WHERE m.produto_id = ?';
            $params[] = $produtoId;
        }

        $sql .= ' ORDER BY m.created_at DESC LIMIT 100';

        $movimentacoes = Database::fetchAll($sql, $params);

        $content = render('estoque/historico', [
            'movimentacoes' => $movimentacoes,
            'produtoId' => $produtoId,
        ]);

        layout('app', $content, [
            'title' => 'Historico de Estoque',
            'user' => Session::user(),
        ]);
    }
}
