<?php

namespace App\Controllers;

use App\Database;
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
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        $vendas = Database::fetchAll(
            "SELECT v.*, c.nome AS cliente_nome
             FROM vendas v
             LEFT JOIN clientes c ON c.id = v.cliente_id
             WHERE v.created_at >= ? AND v.created_at <= ?
             ORDER BY v.created_at DESC",
            [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']
        );

        $content = render('relatorios/vendas', [
            'vendas' => $vendas,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        layout('app', $content, [
            'title' => 'Relatorio de Vendas',
            'user' => Session::user(),
        ]);
    }

    public function produtos(): void
    {
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        $maisVendidos = Database::fetchAll(
            "SELECT p.nome, SUM(iv.quantidade) AS quantidade, SUM(iv.subtotal) AS total
             FROM itens_venda iv
             JOIN vendas v ON v.id = iv.venda_id
             JOIN produtos p ON p.id = iv.produto_id
             WHERE v.created_at >= ? AND v.created_at <= ? AND v.status != 'cancelada'
             GROUP BY p.id, p.nome
             ORDER BY quantidade DESC
             LIMIT 20",
            [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']
        );

        $estoqueAtual = Database::fetchAll(
            "SELECT nome, estoque, preco_venda
             FROM produtos
             ORDER BY nome"
        );

        $content = render('relatorios/produtos', [
            'maisVendidos' => $maisVendidos,
            'estoqueAtual' => $estoqueAtual,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        layout('app', $content, [
            'title' => 'Relatorio de Produtos',
            'user' => Session::user(),
        ]);
    }

    public function caixa(): void
    {
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        $resumo = Database::fetch(
            "SELECT COALESCE(SUM(total), 0) AS total_vendas,
                    COUNT(*) AS quantidade,
                    CASE WHEN COUNT(*) > 0 THEN SUM(total) / COUNT(*) ELSE 0 END AS ticket_medio
             FROM vendas
             WHERE created_at >= ? AND created_at <= ? AND status != 'cancelada'",
            [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']
        );

        $movimentacoes = Database::fetchAll(
            "SELECT v.id, v.codigo, v.total, v.created_at
             FROM vendas v
             WHERE v.created_at >= ? AND v.created_at <= ? AND v.status != 'cancelada'
             ORDER BY v.created_at DESC",
            [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']
        );

        $content = render('relatorios/caixa', [
            'resumo' => $resumo ?: ['total_vendas' => 0, 'quantidade' => 0, 'ticket_medio' => 0],
            'movimentacoes' => $movimentacoes,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        layout('app', $content, [
            'title' => 'Relatorio de Caixa',
            'user' => Session::user(),
        ]);
    }
}
