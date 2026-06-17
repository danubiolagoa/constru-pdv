<?php

namespace App\Controllers;

use App\Database;
use App\Session;

class VendaController
{
    public function create(): void
    {
        $clientes = Database::fetchAll(
            'SELECT id, nome, cpf_cnpj FROM clientes ORDER BY nome'
        );

        $produtos = Database::fetchAll(
            'SELECT id, nome, sku, preco_venda, unidade_medida, estoque_atual 
             FROM produtos WHERE ativo = true AND estoque_atual > 0 ORDER BY nome'
        );

        $content = render('vendas/nova', [
            'clientes' => $clientes,
            'produtos' => $produtos,
        ]);

        layout('app', $content, [
            'title' => 'Nova Venda',
            'user' => Session::user(),
        ]);
    }

    public function index(): void
    {
        $status = $_GET['status'] ?? '';
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        $sql = "SELECT v.*, c.nome as cliente_nome, u.nome as vendedor_nome 
                FROM vendas v 
                LEFT JOIN clientes c ON c.id = v.cliente_id 
                LEFT JOIN usuarios u ON u.id = v.vendedor_id 
                WHERE DATE(v.created_at) BETWEEN ? AND ?";
        $params = [$dataInicio, $dataFim];

        if ($status) {
            $sql .= ' AND v.status = ?';
            $params[] = $status;
        }

        $sql .= ' ORDER BY v.created_at DESC';

        $vendas = Database::fetchAll($sql, $params);

        $content = render('vendas/index', [
            'vendas' => $vendas,
            'status' => $status,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        layout('app', $content, [
            'title' => 'Vendas',
            'user' => Session::user(),
        ]);
    }

    public function show(string $id): void
    {
        $venda = Database::fetch(
            "SELECT v.*, c.nome as cliente_nome, c.cpf_cnpj, u.nome as vendedor_nome 
             FROM vendas v 
             LEFT JOIN clientes c ON c.id = v.cliente_id 
             LEFT JOIN usuarios u ON u.id = v.vendedor_id 
             WHERE v.id = ?",
            [$id]
        );

        if (!$venda) {
            Session::flash('error', 'Venda nao encontrada.');
            redirect('/vendas');
        }

        $itens = Database::fetchAll(
            "SELECT iv.*, p.nome as produto_nome, p.unidade_medida 
             FROM itens_venda iv 
             JOIN produtos p ON p.id = iv.produto_id 
             WHERE iv.venda_id = ?",
            [$id]
        );

        $pagamentos = Database::fetchAll(
            'SELECT * FROM pagamentos WHERE venda_id = ?',
            [$id]
        );

        $content = render('vendas/show', [
            'venda' => $venda,
            'itens' => $itens,
            'pagamentos' => $pagamentos,
        ]);

        layout('app', $content, [
            'title' => "Venda #{$venda['numero']}",
            'user' => Session::user(),
        ]);
    }

    public function store(): void
    {
        $user = Session::user();

        $clienteId = !empty($_POST['cliente_id']) ? (int) $_POST['cliente_id'] : null;
        $itens = json_decode($_POST['itens'] ?? '[]', true);
        $desconto = (float) str_replace(',', '.', $_POST['desconto'] ?? 0);
        $formaPagamento = $_POST['forma_pagamento'] ?? 'dinheiro';

        if (empty($itens)) {
            Session::flash('error', 'Adicione pelo menos um produto.');
            redirect('/vendas');
        }

        Database::beginTransaction();

        try {
            $subtotal = 0;
            foreach ($itens as $item) {
                $subtotal += $item['subtotal'];
            }

            $total = $subtotal - $desconto;

            $numero = 'V' . str_pad(
                (string) (Database::fetch("SELECT COALESCE(MAX(CAST(SUBSTRING(numero FROM 2) AS INTEGER)), 0) + 1 as next FROM vendas")['next'] ?? 1),
                6,
                '0',
                STR_PAD_LEFT
            );

            $vendaId = Database::insert('vendas', [
                'numero' => $numero,
                'cliente_id' => $clienteId,
                'vendedor_id' => $user['id'],
                'subtotal' => $subtotal,
                'desconto' => $desconto,
                'total' => $total,
                'forma_pagamento' => $formaPagamento,
                'status' => 'concluida',
            ]);

            foreach ($itens as $item) {
                Database::insert('itens_venda', [
                    'venda_id' => $vendaId,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                    'desconto' => $item['desconto'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                Database::query(
                    'UPDATE produtos SET estoque_atual = estoque_atual - ?, updated_at = NOW() WHERE id = ?',
                    [$item['quantidade'], $item['produto_id']]
                );

                Database::insert('movimentacoes_estoque', [
                    'produto_id' => $item['produto_id'],
                    'tipo' => 'saida',
                    'quantidade' => $item['quantidade'],
                    'motivo' => "Venda {$numero}",
                    'usuario_id' => $user['id'],
                    'venda_id' => $vendaId,
                ]);
            }

            Database::commit();

            Session::flash('success', "Venda {$numero} registrada com sucesso!");
            redirect("/vendas/{$vendaId}");
        } catch (\Throwable $e) {
            Database::rollback();
            Session::flash('error', 'Erro ao registrar venda: ' . $e->getMessage());
            redirect('/vendas');
        }
    }

    public function cancel(string $id): void
    {
        if (!Session::isAdmin()) {
            Session::flash('error', 'Apenas administradores podem cancelar vendas.');
            redirect("/vendas/{$id}");
        }

        $motivo = trim($_POST['motivo'] ?? '');

        if (empty($motivo)) {
            Session::flash('error', 'Informe o motivo do cancelamento.');
            redirect("/vendas/{$id}");
        }

        $venda = Database::fetch('SELECT * FROM vendas WHERE id = ?', [$id]);

        if (!$venda || $venda['status'] === 'cancelada') {
            Session::flash('error', 'Venda nao encontrada ou ja cancelada.');
            redirect('/vendas');
        }

        Database::beginTransaction();

        try {
            Database::update('vendas', [
                'status' => 'cancelada',
                'motivo_cancelamento' => $motivo,
                'updated_at' => date('Y-m-d H:i:s'),
            ], 'id = ?', [$id]);

            $itens = Database::fetchAll('SELECT * FROM itens_venda WHERE venda_id = ?', [$id]);

            foreach ($itens as $item) {
                Database::query(
                    'UPDATE produtos SET estoque_atual = estoque_atual + ?, updated_at = NOW() WHERE id = ?',
                    [$item['quantidade'], $item['produto_id']]
                );

                Database::insert('movimentacoes_estoque', [
                    'produto_id' => $item['produto_id'],
                    'tipo' => 'entrada',
                    'quantidade' => $item['quantidade'],
                    'motivo' => "Cancelamento venda {$venda['numero']}",
                    'usuario_id' => Session::user()['id'],
                    'venda_id' => $id,
                ]);
            }

            Database::commit();

            Session::flash('success', 'Venda cancelada e estoque restaurado.');
            redirect("/vendas/{$id}");
        } catch (\Throwable $e) {
            Database::rollback();
            Session::flash('error', 'Erro ao cancelar venda.');
            redirect("/vendas/{$id}");
        }
    }
}
