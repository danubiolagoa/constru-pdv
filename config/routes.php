<?php

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProdutoController;
use App\Controllers\ClienteController;
use App\Controllers\VendaController;
use App\Controllers\EstoqueController;
use App\Controllers\UsuarioController;
use App\Controllers\RelatorioController;
use App\Controllers\ConfiguracaoController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\GuestMiddleware;

/** @var Router $router */

$router->get('/', function () {
    if (\App\Session::isAuthenticated()) {
        header('Location: /dashboard');
    } else {
        header('Location: /login');
    }
    exit;
});

$router->group('', function (Router $router) {
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
}, [GuestMiddleware::class]);

$router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);

$router->group('', function (Router $router) {
    $router->get('/dashboard', [DashboardController::class, 'index']);

    $router->get('/produtos', [ProdutoController::class, 'index']);
    $router->get('/produtos/novo', [ProdutoController::class, 'create']);
    $router->post('/produtos', [ProdutoController::class, 'store']);
    $router->post('/produtos/salvar', [ProdutoController::class, 'store']);
    $router->get('/produtos/editar/{id}', [ProdutoController::class, 'edit']);
    $router->post('/produtos/atualizar/{id}', [ProdutoController::class, 'update']);
    $router->post('/produtos/excluir/{id}', [ProdutoController::class, 'destroy']);
    $router->get('/produtos/{id}/editar', [ProdutoController::class, 'edit']);
    $router->post('/produtos/{id}', [ProdutoController::class, 'update']);
    $router->post('/produtos/{id}/excluir', [ProdutoController::class, 'destroy']);

    $router->get('/clientes', [ClienteController::class, 'index']);
    $router->get('/clientes/novo', [ClienteController::class, 'create']);
    $router->post('/clientes', [ClienteController::class, 'store']);
    $router->post('/clientes/salvar', [ClienteController::class, 'store']);
    $router->get('/clientes/editar/{id}', [ClienteController::class, 'edit']);
    $router->post('/clientes/atualizar/{id}', [ClienteController::class, 'update']);
    $router->post('/clientes/excluir/{id}', [ClienteController::class, 'destroy']);
    $router->get('/clientes/{id}/editar', [ClienteController::class, 'edit']);
    $router->post('/clientes/{id}', [ClienteController::class, 'update']);
    $router->post('/clientes/{id}/excluir', [ClienteController::class, 'destroy']);

    $router->get('/vendas', [VendaController::class, 'index']);
    $router->get('/vendas/nova', [VendaController::class, 'create']);
    $router->get('/vendas/{id}', [VendaController::class, 'show']);
    $router->post('/vendas', [VendaController::class, 'store']);
    $router->post('/vendas/cancelar/{id}', [VendaController::class, 'cancel']);
    $router->post('/vendas/{id}/cancelar', [VendaController::class, 'cancel']);

    $router->get('/estoque', [EstoqueController::class, 'index']);
    $router->post('/estoque/movimentar', [EstoqueController::class, 'movimentar']);
    $router->get('/estoque/historico', [EstoqueController::class, 'historico']);

    $router->get('/relatorios', [RelatorioController::class, 'index']);
    $router->get('/relatorios/vendas', [RelatorioController::class, 'vendas']);
    $router->get('/relatorios/produtos', [RelatorioController::class, 'produtos']);
    $router->get('/relatorios/caixa', [RelatorioController::class, 'caixa']);
}, [AuthMiddleware::class]);

$router->group('', function (Router $router) {
    $router->get('/usuarios', [UsuarioController::class, 'index']);
    $router->get('/usuarios/novo', [UsuarioController::class, 'create']);
    $router->post('/usuarios', [UsuarioController::class, 'store']);
    $router->post('/usuarios/salvar', [UsuarioController::class, 'store']);
    $router->get('/usuarios/editar/{id}', [UsuarioController::class, 'edit']);
    $router->post('/usuarios/atualizar/{id}', [UsuarioController::class, 'update']);
    $router->post('/usuarios/excluir/{id}', [UsuarioController::class, 'destroy']);
    $router->get('/usuarios/{id}/editar', [UsuarioController::class, 'edit']);
    $router->post('/usuarios/{id}', [UsuarioController::class, 'update']);
    $router->post('/usuarios/{id}/excluir', [UsuarioController::class, 'destroy']);

    $router->get('/configuracoes', [ConfiguracaoController::class, 'index']);
    $router->post('/configuracoes', [ConfiguracaoController::class, 'store']);
    $router->post('/configuracoes/salvar', [ConfiguracaoController::class, 'store']);
}, [AuthMiddleware::class, AdminMiddleware::class]);
