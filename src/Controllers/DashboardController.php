<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class DashboardController
{
    public function index(): void
    {
        $user = Session::user();

        if ($user['role'] === 'admin') {
            $this->adminDashboard($user);
        } else {
            $this->vendedorDashboard($user);
        }
    }

    private function adminDashboard(array $user): void
    {
        $vendasHoje = Database::fetch(
            "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as valor 
             FROM vendas 
             WHERE DATE(created_at) = CURRENT_DATE AND status = 'concluida'"
        );

        $vendasMes = Database::fetch(
            "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as valor 
             FROM vendas 
             WHERE DATE_TRUNC('month', created_at) = DATE_TRUNC('month', CURRENT_DATE) 
             AND status = 'concluida'"
        );

        $totalProdutos = Database::fetch(
            'SELECT COUNT(*) as total FROM produtos WHERE ativo = true'
        );

        $totalClientes = Database::fetch(
            'SELECT COUNT(*) as total FROM clientes'
        );

        $estoqueBaixo = Database::fetchAll(
            'SELECT id, nome, estoque_atual, estoque_minimo 
             FROM produtos 
             WHERE estoque_atual <= estoque_minimo AND ativo = true 
             ORDER BY (estoque_atual - estoque_minimo) ASC 
             LIMIT 5'
        );

        $topProdutos = Database::fetchAll(
            "SELECT p.nome, SUM(iv.quantidade) as total_vendido, SUM(iv.subtotal) as total_valor
             FROM itens_venda iv
             JOIN produtos p ON p.id = iv.produto_id
             JOIN vendas v ON v.id = iv.venda_id
             WHERE v.status = 'concluida'
             AND DATE_TRUNC('month', v.created_at) = DATE_TRUNC('month', CURRENT_DATE)
             GROUP BY p.id, p.nome
             ORDER BY total_valor DESC
             LIMIT 5"
        );

        $vendasSemana = Database::fetchAll(
            "SELECT DATE(created_at) as data, SUM(total) as valor, COUNT(*) as total
             FROM vendas
             WHERE created_at >= CURRENT_DATE - INTERVAL '6 days'
             AND status = 'concluida'
             GROUP BY DATE(created_at)
             ORDER BY data"
        );

        $pagamentos = Database::fetchAll(
            "SELECT forma_pagamento, COUNT(*) as total, SUM(total) as valor
             FROM vendas WHERE status = 'concluida'
             GROUP BY forma_pagamento ORDER BY total DESC"
        );

        $content = render('dashboard/admin', [
            'user' => $user,
            'vendasHoje' => $vendasHoje,
            'vendasMes' => $vendasMes,
            'totalProdutos' => $totalProdutos,
            'totalClientes' => $totalClientes,
            'estoqueBaixo' => $estoqueBaixo,
            'topProdutos' => $topProdutos,
            'vendasSemana' => $vendasSemana,
            'pagamentos' => $pagamentos,
        ]);

        layout('app', $content, [
            'title' => 'Dashboard',
            'user' => $user,
        ]);
    }

    private function vendedorDashboard(array $user): void
    {
        $vendasHoje = Database::fetch(
            "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as valor 
             FROM vendas 
             WHERE vendedor_id = ? 
             AND DATE(created_at) = CURRENT_DATE 
             AND status = 'concluida'",
            [$user['id']]
        );

        $vendasMes = Database::fetch(
            "SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as valor 
             FROM vendas 
             WHERE vendedor_id = ?
             AND DATE_TRUNC('month', created_at) = DATE_TRUNC('month', CURRENT_DATE) 
             AND status = 'concluida'",
            [$user['id']]
        );

        $content = render('dashboard/vendedor', [
            'user' => $user,
            'vendasHoje' => $vendasHoje,
            'vendasMes' => $vendasMes,
        ]);

        layout('app', $content, [
            'title' => 'Dashboard',
            'user' => $user,
        ]);
    }
}
