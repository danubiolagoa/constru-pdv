<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada - Constru-PDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D5F4A',
                        accent: '#D4883A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="text-center">
            <h1 class="text-8xl font-bold text-primary">404</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mt-4">Página Não Encontrada</h2>
            <p class="text-gray-600 mt-2">A página que você está procurando não existe ou foi movida.</p>
            <a href="/dashboard" class="inline-block mt-8 bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-lg font-medium transition">
                Voltar ao Dashboard
            </a>
        </div>
    </div>
</body>
</html>
