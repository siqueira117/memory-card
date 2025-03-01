<?php

namespace MemoryCard\Database;

use MemoryCard\Helpers\Log;

class ConnectionDB {
    static protected \PDO $connection;

    public static function getConnection(): ?\PDO 
    {
        $logger = Log::init('dbConnection');
        if (isset(self::$connection)) {
            $logger->info("Retornando conexão existente com o banco");
            return self::$connection;
        }

        try {
            $logger->info("Banco de dados sendo criado");

            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
            $dotenv->load();

            $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname=memorycard;";

            $pdo = new \PDO($dsn, $_ENV["DB_USER"], $_ENV["DB_PASS"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        
            if (!$pdo) throw new \PDOException("Não foi possível realizar conexão");

            self::$connection = $pdo;

            return self::$connection;
        } catch (\PDOException $e) {
            $logger->error("ERRO ao realizar conexão com o banco: " . $e->getMessage());

            return null;
        }
    }
}