<?php
// Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php

class UserPersistenceDto {
    public string $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public string $status;
    public ?string $emailVerificationToken;
    public ?string $emailVerifiedAt;

    public function __construct(string $id, string $name, string $email, string $password, string $role, string $status, ?string $emailVerificationToken = null, ?string $emailVerifiedAt = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
        $this->emailVerificationToken = $emailVerificationToken;
        $this->emailVerifiedAt = $emailVerifiedAt;
    }
}
