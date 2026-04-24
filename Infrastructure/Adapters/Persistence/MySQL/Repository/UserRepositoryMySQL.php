<?php
// Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php

class UserRepositoryMySQL implements 
    SaveUserPort, 
    UpdateUserPort, 
    DeleteUserPort, 
    GetUserByIdPort, 
    GetUserByEmailPort, 
    GetAllUsersPort,
    VerifyEmailPort
{
    private PDO $pdo;
    private UserPersistenceMapper $mapper;

    public function __construct(PDO $pdo, UserPersistenceMapper $mapper) {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(UserModel $user, ?string $emailVerificationToken = null): UserModel {
        $dto = $this->mapper->fromModelToDto($user);
        $sql = "INSERT INTO users (id, name, email, password, role, status, email_verification_token, created_at, updated_at) 
                VALUES (:id, :name, :email, :password, :role, :status, :token, NOW(), NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $dto->id,
            ':name' => $dto->name,
            ':email' => $dto->email,
            ':password' => $dto->password,
            ':role' => $dto->role,
            ':status' => $dto->status,
            ':token' => $emailVerificationToken,
        ]);
        
        $savedUser = $this->getById(new UserId($dto->id));
        if ($savedUser === null) {
            throw new RuntimeException('The user could not be recovered after save.');
        }
        
        return $savedUser;
    }

    public function savePasswordResetToken(string $email, string $token): void {
        $sql  = "UPDATE users 
                 SET password_reset_token = :token, 
                     password_reset_expires_at = DATE_ADD(NOW(), INTERVAL 1 HOUR)
                 WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token, ':email' => $email]);
    }

    public function findByPasswordResetToken(string $token): ?array {
        $sql  = "SELECT * FROM users 
                 WHERE password_reset_token = :token 
                   AND password_reset_expires_at > NOW() 
                 LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function updatePasswordAndClearToken(string $id, string $hashedPassword): void {
        $sql  = "UPDATE users 
                 SET password = :password, 
                     password_reset_token = NULL, 
                     password_reset_expires_at = NULL,
                     updated_at = NOW()
                 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':password' => $hashedPassword, ':id' => $id]);
    }

    public function update(UserModel $user): UserModel {
        $dto = $this->mapper->fromModelToDto($user);
        $sql = "UPDATE users 
                SET name = :name, email = :email, password = :password, role = :role, status = :status, updated_at = NOW() 
                WHERE id = :id";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $dto->id,
            ':name' => $dto->name,
            ':email' => $dto->email,
            ':password' => $dto->password,
            ':role' => $dto->role,
            ':status' => $dto->status,
        ]);
        
        return $this->getById(new UserId($dto->id));
    }

    public function delete(UserId $id): void {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id->value()]);
    }

    public function getById(UserId $id): ?UserModel {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id->value()]);
        $row = $stmt->fetch();
        
        if (!$row) return null;
        
        $entity = $this->mapper->fromRowToEntity($row);
        return $this->mapper->fromEntityToModel($entity);
    }

    public function getByEmail(UserEmail $email): ?UserModel {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email->value()]);
        $row = $stmt->fetch();
        
        if (!$row) return null;
        
        $entity = $this->mapper->fromRowToEntity($row);
        return $this->mapper->fromEntityToModel($entity);
    }

    public function getAll(): array {
        $sql = "SELECT * FROM users ORDER BY name ASC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();
        
        return $this->mapper->fromRowsToModels($rows);
    }

    public function findByToken(string $token): ?UserModel {
        $sql = "SELECT * FROM users WHERE email_verification_token = :token LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        $entity = $this->mapper->fromRowToEntity($row);
        return $this->mapper->fromEntityToModel($entity);
    }

    public function markAsVerified(string $id): void {
        $sql = "UPDATE users SET email_verified_at = NOW(), email_verification_token = NULL, status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':status' => UserStatusEnum::ACTIVE,
        ]);
    }
}
