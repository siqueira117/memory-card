<?php

/**
 * Script de Teste Rápido - Memory Card
 * 
 * Execute: php test-sistema.php
 */

echo "\n🔍 TESTE RÁPIDO DO SISTEMA MEMORY CARD\n";
echo str_repeat("=", 50) . "\n\n";

// Verificar se está na raiz do projeto Laravel
if (!file_exists('artisan')) {
    echo "❌ ERRO: Execute este script na raiz do projeto Laravel!\n\n";
    exit(1);
}

$testes = [
    'passed' => 0,
    'failed' => 0,
    'warnings' => 0
];

// Teste 1: Verificar arquivo de configuração IGDB
echo "1️⃣ Verificando configuração IGDB...\n";
if (file_exists('config/igdb.php')) {
    echo "   ✅ Arquivo config/igdb.php encontrado\n";
    $testes['passed']++;
    
    $config = file_get_contents('config/igdb.php');
    if (strpos($config, 'vfxqyb2qy5afp12dua3s3kl7tc1f5m') !== false) {
        echo "   ⚠️  AVISO: Credenciais default detectadas!\n";
        echo "   📝 Recomendação: Atualize com suas próprias credenciais\n";
        $testes['warnings']++;
    }
} else {
    echo "   ❌ Arquivo config/igdb.php não encontrado\n";
    $testes['failed']++;
}

// Teste 2: Verificar .env
echo "\n2️⃣ Verificando variáveis de ambiente...\n";
if (file_exists('.env')) {
    echo "   ✅ Arquivo .env encontrado\n";
    $testes['passed']++;
    
    $env = file_get_contents('.env');
    
    if (strpos($env, 'TWITCH_CLIENT_ID=') !== false) {
        echo "   ✅ TWITCH_CLIENT_ID configurado\n";
        $testes['passed']++;
    } else {
        echo "   ⚠️  TWITCH_CLIENT_ID não encontrado no .env\n";
        $testes['warnings']++;
    }
    
    if (strpos($env, 'TWITCH_CLIENT_SECRET=') !== false) {
        echo "   ✅ TWITCH_CLIENT_SECRET configurado\n";
        $testes['passed']++;
    } else {
        echo "   ⚠️  TWITCH_CLIENT_SECRET não encontrado no .env\n";
        $testes['warnings']++;
    }
} else {
    echo "   ❌ Arquivo .env não encontrado\n";
    echo "   📝 Copie o arquivo .env.example para .env\n";
    $testes['failed']++;
}

// Teste 3: Verificar arquivos CSS atualizados
echo "\n3️⃣ Verificando arquivos CSS corrigidos...\n";
if (file_exists('public/css/layout.css')) {
    $css = file_get_contents('public/css/layout.css');
    
    // Verificar se a cor do input foi atualizada
    if (strpos($css, '--input-color: #2a2a30;') !== false) {
        echo "   ✅ Cor dos inputs atualizada (--input-color: #2a2a30)\n";
        $testes['passed']++;
    } else {
        echo "   ❌ Cor dos inputs não foi atualizada\n";
        $testes['failed']++;
    }
    
    // Verificar se form-control-modern foi adicionado
    if (strpos($css, '.form-control-modern') !== false) {
        echo "   ✅ Estilos .form-control-modern adicionados\n";
        $testes['passed']++;
    } else {
        echo "   ⚠️  Estilos .form-control-modern não encontrados\n";
        $testes['warnings']++;
    }
    
    // Verificar se a cor de foco foi atualizada
    if (strpos($css, 'background-color: #32323a;') !== false) {
        echo "   ✅ Cor de foco dos inputs atualizada\n";
        $testes['passed']++;
    } else {
        echo "   ❌ Cor de foco não foi atualizada\n";
        $testes['failed']++;
    }
} else {
    echo "   ❌ Arquivo public/css/layout.css não encontrado\n";
    $testes['failed']++;
}

// Teste 4: Verificar modal-add-game.blade.php
echo "\n4️⃣ Verificando modal de adicionar jogo...\n";
if (file_exists('resources/views/components/modal-add-game.blade.php')) {
    echo "   ✅ Arquivo modal-add-game.blade.php encontrado\n";
    $testes['passed']++;
    
    $modal = file_get_contents('resources/views/components/modal-add-game.blade.php');
    
    if (strpos($modal, '.input-icon-wrapper') !== false) {
        echo "   ✅ Estilos .input-icon-wrapper adicionados\n";
        $testes['passed']++;
    } else {
        echo "   ⚠️  Estilos .input-icon-wrapper não encontrados\n";
        $testes['warnings']++;
    }
} else {
    echo "   ❌ Arquivo modal-add-game.blade.php não encontrado\n";
    $testes['failed']++;
}

// Teste 5: Verificar GameController
echo "\n5️⃣ Verificando GameController...\n";
if (file_exists('app/Http/Controllers/GameController.php')) {
    echo "   ✅ GameController encontrado\n";
    $testes['passed']++;
    
    $controller = file_get_contents('app/Http/Controllers/GameController.php');
    
    if (strpos($controller, 'public function searchGames') !== false) {
        echo "   ✅ Método searchGames() existe\n";
        $testes['passed']++;
    } else {
        echo "   ❌ Método searchGames() não encontrado\n";
        $testes['failed']++;
    }
} else {
    echo "   ❌ GameController não encontrado\n";
    $testes['failed']++;
}

// Teste 6: Verificar rotas
echo "\n6️⃣ Verificando rotas...\n";
if (file_exists('routes/web.php')) {
    echo "   ✅ Arquivo routes/web.php encontrado\n";
    $testes['passed']++;
    
    $routes = file_get_contents('routes/web.php');
    
    // A rota pode estar escrita de várias formas:
    // - Route::get('/api/games/search'
    // - Route::get('/games/search' (dentro de Route::prefix('api'))
    if (strpos($routes, "/games/search") !== false || strpos($routes, "api.games.search") !== false) {
        echo "   ✅ Rota /api/games/search configurada\n";
        $testes['passed']++;
    } else {
        echo "   ❌ Rota /api/games/search não encontrada\n";
        echo "   💡 Dica: Verifique se a rota está dentro de Route::prefix('api')\n";
        $testes['failed']++;
    }
} else {
    echo "   ❌ Arquivo routes/web.php não encontrado\n";
    $testes['failed']++;
}

// Teste 7: Verificar pacote IGDB Laravel
echo "\n7️⃣ Verificando dependências...\n";
if (file_exists('vendor/marcreichel/igdb-laravel')) {
    echo "   ✅ Pacote marcreichel/igdb-laravel instalado\n";
    $testes['passed']++;
} else {
    echo "   ❌ Pacote marcreichel/igdb-laravel não encontrado\n";
    echo "   📝 Execute: composer require marcreichel/igdb-laravel\n";
    $testes['failed']++;
}

// Teste 8: Verificar permissões de storage
echo "\n8️⃣ Verificando permissões...\n";
if (is_writable('storage/logs')) {
    echo "   ✅ Diretório storage/logs tem permissão de escrita\n";
    $testes['passed']++;
} else {
    echo "   ⚠️  Diretório storage/logs sem permissão de escrita\n";
    echo "   📝 Execute: chmod -R 775 storage\n";
    $testes['warnings']++;
}

// Resumo
echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 RESUMO DOS TESTES\n";
echo str_repeat("=", 50) . "\n";
echo "✅ Testes Aprovados: " . $testes['passed'] . "\n";
echo "⚠️  Avisos: " . $testes['warnings'] . "\n";
echo "❌ Testes Falharam: " . $testes['failed'] . "\n";

$total = $testes['passed'] + $testes['warnings'] + $testes['failed'];
$porcentagem = $total > 0 ? round(($testes['passed'] / $total) * 100, 2) : 0;

echo "\n📈 Taxa de Sucesso: {$porcentagem}%\n";

// Recomendações finais
echo "\n" . str_repeat("=", 50) . "\n";
echo "📝 PRÓXIMOS PASSOS\n";
echo str_repeat("=", 50) . "\n";

if ($testes['failed'] > 0) {
    echo "❌ Há {$testes['failed']} teste(s) falhando!\n";
    echo "   Revise os erros acima antes de continuar.\n\n";
}

if ($testes['warnings'] > 0) {
    echo "⚠️  Há {$testes['warnings']} aviso(s)!\n";
    echo "   Recomenda-se resolver os avisos.\n\n";
}

if ($testes['failed'] === 0 && $testes['warnings'] === 0) {
    echo "🎉 Todos os testes passaram!\n\n";
    echo "✅ Próximo passo: Limpar cache e testar no navegador\n";
    echo "   Execute: php artisan cache:clear\n";
    echo "   Execute: php artisan config:clear\n";
    echo "   Execute: php artisan view:clear\n\n";
} else {
    echo "🔧 Ações recomendadas:\n\n";
    
    if ($testes['warnings'] > 0) {
        echo "1. Atualize as credenciais do IGDB no arquivo .env\n";
        echo "2. Execute: php artisan config:clear\n\n";
    }
    
    if ($testes['failed'] > 0) {
        echo "3. Verifique se todas as correções foram aplicadas\n";
        echo "4. Consulte CORRECOES_REALIZADAS.md para mais detalhes\n\n";
    }
}

echo str_repeat("=", 50) . "\n";
echo "📚 Documentação disponível:\n";
echo "   - CORRECOES_REALIZADAS.md (detalhes técnicos)\n";
echo "   - GUIA_TESTE_RAPIDO.md (guia de testes)\n";
echo str_repeat("=", 50) . "\n\n";

// Código de saída
if ($testes['failed'] > 0) {
    exit(1);
} else {
    exit(0);
}

