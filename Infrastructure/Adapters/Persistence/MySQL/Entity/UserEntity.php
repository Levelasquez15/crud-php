<?php
// Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php

class UserEntity {
    public string $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public string $status;
    public ?string $created_at;
    public ?string $updated_at;
}
