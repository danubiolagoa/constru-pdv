<?php

require_once __DIR__ . '/src/helpers/env.php';

loadEnv(__DIR__ . '/.env');

$config = require __DIR__ . '/config/database.php';

$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s',
    $config['host'],
    $config['port'],
    $config['database'],
    $config['sslmode']
);

try {
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "Conectado ao banco de dados.\n\n";

    $migrationDir = __DIR__ . '/database/migrations';
    $files = glob($migrationDir . '/*.sql');
    sort($files);

    foreach ($files as $file) {
        $filename = basename($file);
        echo "Executando: {$filename}... ";

        $sql = file_get_contents($file);
        $pdo->exec($sql);

        echo "OK\n";
    }

    echo "\nMigrations executadas com sucesso!\n";

    $adminExists = $pdo->query("SELECT id FROM usuarios WHERE email = 'admin@construpdv.com'")->fetch();

    if (!$adminExists) {
        $senhaHash = password_hash('admin123', PASSWORD_BCRYPT);

        $pdo->exec("INSERT INTO usuarios (nome, email, senha_hash, role, ativo) VALUES ('Administrador', 'admin@construpdv.com', '{$senhaHash}', 'admin', true)");

        echo "\nUsuario admin criado:\n";
        echo "  Email: admin@construpdv.com\n";
        echo "  Senha: admin123\n";
        echo "  (ALTERE A SENHA APOS O PRIMEIRO LOGIN!)\n";
    }

    $categorias = [
        ['Construcao', 'hard-hat'],
        ['Ceramica', 'brick'],
        ['Tintas', 'paintbrush'],
        ['Hidraulica', 'droplets'],
        ['Eletrica', 'zap'],
        ['Ferramentas', 'wrench'],
        ['Acabamento', 'layers'],
        ['Metais', 'anchor'],
    ];

    $stmt = $pdo->prepare("INSERT INTO categorias (nome, icone) VALUES (?, ?) ON CONFLICT DO NOTHING");

    foreach ($categorias as [$nome, $icone]) {
        $stmt->execute([$nome, $icone]);
    }

    echo "\nCategorias padrao criadas.\n";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    exit(1);
}
