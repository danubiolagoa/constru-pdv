<?php

function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

function view(string $template, array $data = []): void
{
    extract($data);
    
    $templatePath = BASE_PATH . "/src/views/{$template}.php";
    
    if (!file_exists($templatePath)) {
        throw new Exception("Template not found: {$template}");
    }
    
    require $templatePath;
}

function layout(string $name, string $content, array $data = []): void
{
    $data['content'] = $content;
    extract($data);
    
    $layoutPath = BASE_PATH . "/src/views/layouts/{$name}.php";
    
    if (!file_exists($layoutPath)) {
        throw new Exception("Layout not found: {$name}");
    }
    
    require $layoutPath;
}

function render(string $template, array $data = []): string
{
    extract($data);
    
    $templatePath = BASE_PATH . "/src/views/{$template}.php";
    
    if (!file_exists($templatePath)) {
        throw new Exception("Template not found: {$template}");
    }
    
    ob_start();
    require $templatePath;
    return ob_get_clean();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

function verify_csrf(): bool
{
    $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function old(string $key, string $default = ''): string
{
    $value = $_SESSION['old_input'][$key] ?? $default;
    unset($_SESSION['old_input'][$key]);
    return $value;
}

function flash(string $key, mixed $value = null): mixed
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    
    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function format_money(float $value): string
{
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function format_date(string $date, string $format = 'd/m/Y'): string
{
    return date($format, strtotime($date));
}

function format_datetime(string $date, string $format = 'd/m/Y H:i'): string
{
    return date($format, strtotime($date));
}

function slug(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text ?: 'n-a';
}

function sanitize(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function e(string $value): string
{
    return sanitize($value);
}

function dd(mixed ...$vars): void
{
    echo '<pre style="background:#1e1e1e;color:#d4d4d4;padding:16px;border-radius:8px;overflow:auto;">';
    foreach ($vars as $var) {
        var_dump($var);
        echo "\n";
    }
    echo '</pre>';
    exit;
}
