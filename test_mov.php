<?php
session_start();
$_SESSION = [
    "csrf_token" => "testcsrf123",
    "user" => ["id" => 1, "nome" => "Admin", "email" => "admin@construpdv.com", "tipo" => "admin", "role" => "admin"]
];
$_SERVER["REQUEST_METHOD"] = "POST";
$_SERVER["REQUEST_URI"] = "/estoque/movimentar";
$_POST = ["produto_id" => "1", "tipo" => "entrada", "quantidade" => "10", "_token" => "testcsrf123", "motivo" => "Teste direto PHP"];
$_COOKIE = [];
require "vendor/autoload.php";
require "src/helpers/env.php";
loadEnv(".env");
$c = new App\Controllers\EstoqueController();
ob_start();
try {
    $c->movimentar();
    $output = ob_get_clean();
    echo "OUTPUT: " . $output . PHP_EOL;
    echo "SUCCESS: controller executou sem exception";
} catch (Throwable $e) {
    ob_end_clean();
    echo "ERRO: " . $e->getMessage() . PHP_EOL . $e->getTraceAsString();
}

