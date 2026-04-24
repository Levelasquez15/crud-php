<?php
// Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php

class UserPersistenceMapper {
    public function fromModelToDto(UserModel $model): UserPersistenceDto {
        return new UserPersistenceDto(
            $model->id()->value(),
            $model->name()->value(),
            $model->email()->value(),
            $model->password()->value(), // Raw hash stored in VO
            $model->role(),
            $model->status()
        );
    }

    public function fromEntityToModel(UserEntity $entity): UserModel {
        // Important: use fromHash() to avoid re-hashing the DB stored hash.
        return new UserModel(
            new UserId($entity->id),
            new UserName($entity->name),
            new UserEmail($entity->email),
            UserPassword::fromHash($entity->password),
            $entity->role,
            $entity->status
        );
    }

    public function fromRowToEntity(array $row): UserEntity {
        $entity = new UserEntity();
        $entity->id = $row['id'];
        $entity->name = $row['name'];
        $entity->email = $row['email'];
        $entity->password = $row['password'];
        $entity->role = $row['role'];
        $entity->status = $row['status'];
        $entity->created_at = $row['created_at'] ?? null;
        $entity->updated_at = $row['updated_at'] ?? null;
        return $entity;
    }

    public function fromRowsToModels(array $rows): array {
        $models = [];
        foreach ($rows as $row) {
            $entity = $this->fromRowToEntity($row);
            $models[] = $this->fromEntityToModel($entity);
        }
        return $models;
    }
}
