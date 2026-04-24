<?php
// Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserWebRequest.php

class CreateUserWebRequest {
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(string $id, string $name, string $email, string $password, string $role) {
        $this->id = $id;
        $this->name = trim($name);
        $this->email = trim(strtolower($email));
        $this->password = $password;
        $this->role = trim($role);
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRole(): string { return $this->role; }
}
