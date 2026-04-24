<?php
// Application/Services/Dto/Commands/VerifyEmailCommand.php

class VerifyEmailCommand {
    private string $token;

    public function __construct(string $token) {
        $this->token = $token;
    }

    public function getToken(): string {
        return $this->token;
    }
}
