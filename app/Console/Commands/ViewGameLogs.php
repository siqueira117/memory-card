<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewGameLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:games 
                            {--type=all : Tipo de log (all, busca, cadastro, login, perfil, favorito, manual, detalhes, status, erro)}
                            {--lines=50 : Número de linhas}
                            {--tail : Modo tail (atualização em tempo real)}
                            {--today : Apenas logs de hoje}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Visualizar logs de busca e cadastro de jogos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            $this->error('❌ Arquivo de log não encontrado!');
            $this->info('📂 Caminho esperado: ' . $logFile);
            return 1;
        }

        $type = $this->option('type');
        $lines = $this->option('lines');
        $tail = $this->option('tail');
        $today = $this->option('today');

        $this->info('📊 VISUALIZADOR DE LOGS - MEMORY CARD');
        $this->line(str_repeat('═', 60));
        
        if ($tail) {
            $this->tailLogs($logFile, $type);
        } else {
            $this->showLogs($logFile, $type, $lines, $today);
        }
        
        return 0;
    }

    /**
     * Exibir logs (modo estático)
     */
    private function showLogs($logFile, $type, $lines, $today)
    {
        $content = File::get($logFile);
        $logLines = explode("\n", $content);
        
        // Filtrar por data se necessário
        if ($today) {
            $todayDate = date('Y-m-d');
            $logLines = array_filter($logLines, function($line) use ($todayDate) {
                return strpos($line, $todayDate) !== false;
            });
        }
        
        // Filtrar por tipo
        $filtered = $this->filterByType($logLines, $type);
        
        // Pegar últimas N linhas
        $filtered = array_slice($filtered, -$lines);
        
        if (empty($filtered)) {
            $this->warn('⚠️  Nenhum log encontrado com os filtros aplicados.');
            $this->info('💡 Dica: Tente sem filtros ou aguarde alguma atividade no sistema.');
            return;
        }
        
        $this->info("📋 Mostrando últimas {$lines} entradas (Tipo: {$type})");
        $this->line(str_repeat('─', 60));
        
        foreach ($filtered as $line) {
            $this->displayFormattedLine($line);
        }
        
        $this->line(str_repeat('═', 60));
        $this->info('✅ Total de entradas: ' . count($filtered));
    }

    /**
     * Tail logs (modo tempo real)
     */
    private function tailLogs($logFile, $type)
    {
        $this->info('👀 Modo TAIL ativado (Pressione Ctrl+C para sair)');
        $this->info('🔍 Filtrando por: ' . $type);
        $this->line(str_repeat('─', 60));
        
        $lastSize = filesize($logFile);
        
        while (true) {
            clearstatcache();
            $currentSize = filesize($logFile);
            
            if ($currentSize > $lastSize) {
                $file = fopen($logFile, 'r');
                fseek($file, $lastSize);
                
                while (!feof($file)) {
                    $line = fgets($file);
                    if ($line && $this->matchesType($line, $type)) {
                        $this->displayFormattedLine($line);
                    }
                }
                
                fclose($file);
                $lastSize = $currentSize;
            }
            
            usleep(500000); // 0.5 segundo
        }
    }

    /**
     * Filtrar logs por tipo
     */
    private function filterByType($lines, $type)
    {
        $tags = [
            'all' => ['[BUSCA JOGOS]', '[CADASTRO JOGO]', '[LOGIN]', '[LOGOUT]', '[REGISTRO]', 
                      '[PERFIL]', '[FAVORITO]', '[MANUAL]', '[DETALHES JOGO]', '[STATUS JOGO]'],
            'busca' => ['[BUSCA JOGOS]'],
            'cadastro' => ['[CADASTRO JOGO]'],
            'login' => ['[LOGIN]', '[LOGOUT]', '[REGISTRO]'],
            'perfil' => ['[PERFIL]'],
            'favorito' => ['[FAVORITO]'],
            'manual' => ['[MANUAL]'],
            'detalhes' => ['[DETALHES JOGO]'],
            'status' => ['[STATUS JOGO]']
        ];
        
        if ($type === 'erro') {
            return array_filter($lines, function($line) use ($tags) {
                // Verifica se contém alguma tag do sistema
                $hasTag = false;
                foreach ($tags['all'] as $tag) {
                    if (strpos($line, $tag) !== false) {
                        $hasTag = true;
                        break;
                    }
                }
                
                // E se é um erro
                $isError = strpos($line, 'ERROR') !== false || strpos($line, '❌') !== false;
                
                return $hasTag && $isError;
            });
        }
        
        if (isset($tags[$type])) {
            return array_filter($lines, function($line) use ($tags, $type) {
                foreach ($tags[$type] as $tag) {
                    if (strpos($line, $tag) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }
        
        return $lines;
    }

    /**
     * Verificar se linha corresponde ao tipo
     */
    private function matchesType($line, $type)
    {
        $tags = [
            'all' => ['[BUSCA JOGOS]', '[CADASTRO JOGO]', '[LOGIN]', '[LOGOUT]', '[REGISTRO]', 
                      '[PERFIL]', '[FAVORITO]', '[MANUAL]', '[DETALHES JOGO]', '[STATUS JOGO]'],
            'busca' => ['[BUSCA JOGOS]'],
            'cadastro' => ['[CADASTRO JOGO]'],
            'login' => ['[LOGIN]', '[LOGOUT]', '[REGISTRO]'],
            'perfil' => ['[PERFIL]'],
            'favorito' => ['[FAVORITO]'],
            'manual' => ['[MANUAL]'],
            'detalhes' => ['[DETALHES JOGO]'],
            'status' => ['[STATUS JOGO]']
        ];
        
        if ($type === 'erro') {
            $hasTag = false;
            foreach ($tags['all'] as $tag) {
                if (strpos($line, $tag) !== false) {
                    $hasTag = true;
                    break;
                }
            }
            $isError = strpos($line, 'ERROR') !== false || strpos($line, '❌') !== false;
            return $hasTag && $isError;
        }
        
        if (isset($tags[$type])) {
            foreach ($tags[$type] as $tag) {
                if (strpos($line, $tag) !== false) {
                    return true;
                }
            }
            return false;
        }
        
        return true;
    }

    /**
     * Exibir linha formatada com cores
     */
    private function displayFormattedLine($line)
    {
        // Detectar tipo de mensagem
        if (strpos($line, 'ERROR') !== false || strpos($line, '❌') !== false) {
            $this->line("<fg=red>{$line}</>");
        } elseif (strpos($line, 'WARNING') !== false || strpos($line, '⚠️') !== false) {
            $this->line("<fg=yellow>{$line}</>");
        } elseif (strpos($line, '✅') !== false || strpos($line, '🎉') !== false) {
            $this->line("<fg=green>{$line}</>");
        } elseif (strpos($line, 'INFO') !== false) {
            $this->line("<fg=cyan>{$line}</>");
        } else {
            $this->line($line);
        }
    }
}
