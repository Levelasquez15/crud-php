<?php
// Application/Services/Dto/LoginCommand.php

class LoginCommand {
    private string $email;
    private string $plainPassword;

    public function __construct(string $email, string $plainPassword) {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
    }

    public function email(): string { return $this->email; }
    public function plainPassword(): string { return $this->plainPassword; }
}
