<?php
// Infrastructure/Adapters/Mail/MailerConfig.php

class MailerConfig {
    private string $host = 'smtp.gmail.com';
    private int $port = 465;
    private string $username;
    private string $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getHost(): string {
        return $this->host;
    }

    public function getPort(): int {
        return $this->port;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }
}
