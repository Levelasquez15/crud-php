<?php
// Infrastructure/Adapters/Persistence/MySQL/Config/Migration.php

class Migration {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addEmailVerificationColumns(): void {
        try {
            $this->pdo->exec("
                ALTER TABLE users 
                ADD COLUMN IF NOT EXISTS email_verified_at DATETIME NULL,
                ADD COLUMN IF NOT EXISTS email_verification_token VARCHAR(255) NULL UNIQUE,
                ADD COLUMN IF NOT EXISTS created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                ADD COLUMN IF NOT EXISTS updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
            ");
        } catch (PDOException $e) {
            throw new RuntimeException("Error en migración: " . $e->getMessage());
        }
    }
}
