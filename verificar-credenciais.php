<?php

/**
 * Script de Verificação de Credenciais da Twitch/IGDB
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n";
echo "═══════════════════════════════════════════════\n";
echo "  🔐 VERIFICAÇÃO DE CREDENCIAIS TWITCH/IGDB\n";
echo "═══════════════════════════════════════════════\n";
echo "\n";

// 1. Verificar se as variáveis de ambiente estão definidas
echo "1️⃣  Verificando variáveis de ambiente...\n";
echo "─────────────────────────────────────────────\n";

$clientId = env('TWITCH_CLIENT_ID');
$clientSecret = env('TWITCH_CLIENT_SECRET');

if (empty($clientId)) {
    echo "❌ TWITCH_CLIENT_ID: NÃO CONFIGURADO\n";
    echo "   ⚠️  Adicione no arquivo .env:\n";
    echo "   TWITCH_CLIENT_ID=sua_chave_aqui\n\n";
} else {
    echo "✅ TWITCH_CLIENT_ID: " . substr($clientId, 0, 10) . "..." . " (Configurado)\n";
}

if (empty($clientSecret)) {
    echo "❌ TWITCH_CLIENT_SECRET: NÃO CONFIGURADO\n";
    echo "   ⚠️  Adicione no arquivo .env:\n";
    echo "   TWITCH_CLIENT_SECRET=seu_secret_aqui\n\n";
} else {
    echo "✅ TWITCH_CLIENT_SECRET: " . substr($clientSecret, 0, 10) . "..." . " (Configurado)\n";
}

echo "\n";

// 2. Verificar se as configurações do config foram carregadas
echo "2️⃣  Verificando configurações do Laravel...\n";
echo "─────────────────────────────────────────────\n";

$configClientId = config('igdb.credentials.client_id');
$configClientSecret = config('igdb.credentials.client_secret');

if (empty($configClientId)) {
    echo "❌ Config Client ID: NÃO CARREGADO\n";
    echo "   💡 Execute: php artisan config:clear\n\n";
} else {
    echo "✅ Config Client ID: " . substr($configClientId, 0, 10) . "...\n";
}

if (empty($configClientSecret)) {
    echo "❌ Config Client Secret: NÃO CARREGADO\n";
    echo "   💡 Execute: php artisan config:clear\n\n";
} else {
    echo "✅ Config Client Secret: " . substr($configClientSecret, 0, 10) . "...\n";
}

echo "\n";

// 3. Testar conexão com a API da Twitch
if (!empty($clientId) && !empty($clientSecret)) {
    echo "3️⃣  Testando conexão com a API da Twitch...\n";
    echo "─────────────────────────────────────────────\n";
    
    try {
        // Usar o cliente HTTP do Laravel (Guzzle)
        $client = new \GuzzleHttp\Client([
            'verify' => false, // Desabilitar verificação SSL temporariamente para teste
            'timeout' => 10,
        ]);
        
        $response = $client->post('https://id.twitch.tv/oauth2/token', [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'client_credentials'
            ]
        ]);
        
        $httpCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        if ($httpCode === 200) {
            $data = json_decode($body, true);
            if (isset($data['access_token'])) {
                echo "✅ Conexão com Twitch: SUCESSO!\n";
                echo "   Token obtido: " . substr($data['access_token'], 0, 15) . "...\n";
                echo "   Expira em: " . $data['expires_in'] . " segundos\n";
                echo "\n";
                echo "🎉 TUDO FUNCIONANDO!\n";
                echo "\n";
                echo "Você pode testar agora:\n";
                echo "  php test-sistema.php\n";
            } else {
                echo "⚠️  Resposta inesperada da API\n";
                echo "   " . $body . "\n";
            }
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        echo "❌ Erro ao conectar com Twitch (HTTP " . $e->getResponse()->getStatusCode() . ")\n";
        $errorBody = $e->getResponse()->getBody()->getContents();
        $error = json_decode($errorBody, true);
        
        if (isset($error['message'])) {
            echo "   Mensagem: " . $error['message'] . "\n";
            
            if (strpos($error['message'], 'Invalid client') !== false || $e->getResponse()->getStatusCode() === 400) {
                echo "\n";
                echo "🔍 DIAGNÓSTICO:\n";
                echo "   As credenciais estão INCORRETAS!\n";
                echo "\n";
                echo "📋 COMO CORRIGIR:\n";
                echo "   1. Acesse: https://dev.twitch.tv/console/apps\n";
                echo "   2. Clique no seu aplicativo\n";
                echo "   3. Copie o 'Client ID'\n";
                echo "   4. Clique em 'New Secret' para gerar um novo Client Secret\n";
                echo "   5. Atualize o arquivo .env com as novas credenciais:\n";
                echo "      TWITCH_CLIENT_ID=seu_novo_client_id\n";
                echo "      TWITCH_CLIENT_SECRET=seu_novo_client_secret\n";
                echo "   6. Execute: php artisan config:clear\n";
                echo "   7. Execute este script novamente: php verificar-credenciais.php\n";
            }
        } else {
            echo "   Resposta: " . $errorBody . "\n";
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo "❌ Erro de rede: " . $e->getMessage() . "\n";
        echo "\n";
        echo "🔍 POSSÍVEIS CAUSAS:\n";
        echo "   - Firewall bloqueando a conexão\n";
        echo "   - Problema de internet\n";
        echo "   - Problema com certificado SSL\n";
    } catch (Exception $e) {
        echo "❌ Erro ao testar conexão: " . $e->getMessage() . "\n";
    }
} else {
    echo "⚠️  Não foi possível testar a conexão (credenciais faltando)\n";
}

echo "\n";
echo "═══════════════════════════════════════════════\n";
echo "  Verificação completa!\n";
echo "═══════════════════════════════════════════════\n";
echo "\n";

