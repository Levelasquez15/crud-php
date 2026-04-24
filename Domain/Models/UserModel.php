<?php
// Domain/Models/UserModel.php
require_once __DIR__ . '/../ValueObjects/UserId.php';
require_once __DIR__ . '/../ValueObjects/UserName.php';
require_once __DIR__ . '/../ValueObjects/UserEmail.php';
require_once __DIR__ . '/../ValueObjects/UserPassword.php';
require_once __DIR__ . '/../Enums/UserRoleEnum.php';
require_once __DIR__ . '/../Enums/UserStatusEnum.php';

class UserModel {
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;
    private string $role;
    private string $status;

    public function __construct(UserId $id, UserName $name, UserEmail $email, UserPassword $password, string $role, string $status) {
        UserRoleEnum::ensureIsValid($role);
        UserStatusEnum::ensureIsValid($status);

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }

    public static function create(UserId $id, UserName $name, UserEmail $email, UserPassword $password, string $role): self {
        return new self($id, $name, $email, $password, $role, UserStatusEnum::PENDING);
    }

    // Getters
    public function id(): UserId { return $this->id; }
    public function name(): UserName { return $this->name; }
    public function email(): UserEmail { return $this->email; }
    public function password(): UserPassword { return $this->password; }
    public function role(): string { return $this->role; }
    public function status(): string { return $this->status; }

    // State changes (Inmutabilidad)
    public function activate(): self {
        return new self($this->id, $this->name, $this->email, $this->password, $this->role, UserStatusEnum::ACTIVE);
    }
    public function deactivate(): self {
        return new self($this->id, $this->name, $this->email, $this->password, $this->role, UserStatusEnum::INACTIVE);
    }
    public function block(): self {
        return new self($this->id, $this->name, $this->email, $this->password, $this->role, UserStatusEnum::BLOCKED);
    }

    // Data changes
    public function changeName(UserName $newName): self {
        return new self($this->id, $newName, $this->email, $this->password, $this->role, $this->status);
    }
    public function changeEmail(UserEmail $newEmail): self {
        return new self($this->id, $this->name, $newEmail, $this->password, $this->role, $this->status);
    }
    public function changePassword(UserPassword $newPassword): self {
        return new self($this->id, $this->name, $this->email, $newPassword, $this->role, $this->status);
    }
    public function changeRole(string $newRole): self {
        return new self($this->id, $this->name, $this->email, $this->password, $newRole, $this->status);
    }
}
