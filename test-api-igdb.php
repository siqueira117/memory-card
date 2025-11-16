#!/usr/bin/env php
<?php

/**
 * Teste Rápido da API IGDB
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n";
echo "═══════════════════════════════════════════════\n";
echo "  🎮 TESTE DA API IGDB\n";
echo "═══════════════════════════════════════════════\n";
echo "\n";

echo "Testando busca por 'Mario'...\n\n";

try {
    $games = \MarcReichel\IGDBLaravel\Models\Game::search('mario')
        ->select(['name', 'cover'])
        ->limit(5)
        ->get();
    
    if ($games->count() > 0) {
        echo "✅ API funcionando perfeitamente!\n\n";
        echo "🎮 Jogos encontrados:\n";
        echo "─────────────────────────────────────────────\n";
        
        foreach ($games as $game) {
            echo "  • " . $game->name . "\n";
        }
        
        echo "\n";
        echo "🎉 SUCESSO! O problema foi resolvido!\n";
        echo "\n";
        echo "Agora você pode:\n";
        echo "  1. Acessar o sistema no navegador\n";
        echo "  2. Buscar jogos normalmente\n";
        echo "  3. Adicionar jogos à coleção\n";
        
    } else {
        echo "⚠️  Nenhum jogo encontrado na busca\n";
        echo "   (Mas a API está funcionando!)\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Erro ao buscar jogos:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "\n";
    echo "🔍 Detalhes do erro:\n";
    echo "   Arquivo: " . $e->getFile() . "\n";
    echo "   Linha: " . $e->getLine() . "\n";
    
    if ($e instanceof \MarcReichel\IGDBLaravel\Exceptions\AuthenticationException) {
        echo "\n";
        echo "💡 DICAS:\n";
        echo "   1. Verifique se as credenciais estão corretas no .env\n";
        echo "   2. Execute: php artisan config:clear\n";
        echo "   3. Execute: php verificar-credenciais.php\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════════════\n";
echo "\n";

