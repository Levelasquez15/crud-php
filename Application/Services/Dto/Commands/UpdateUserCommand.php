<?php
// Application/Services/Dto/UpdateUserCommand.php

class UpdateUserCommand {
    private string $id;
    private string $name;
    private string $email;
    private string $plainPassword;
    private string $role;
    private string $status;

    public function __construct(string $id, string $name, string $email, string $plainPassword, string $role, string $status) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->role = $role;
        $this->status = $status;
    }

    public function id(): string { return $this->id; }
    public function name(): string { return $this->name; }
    public function email(): string { return $this->email; }
    public function plainPassword(): string { return $this->plainPassword; }
    public function role(): string { return $this->role; }
    public function status(): string { return $this->status; }
}
