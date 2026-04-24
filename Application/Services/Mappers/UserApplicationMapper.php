<?php
// Application/Services/Mappers/UserApplicationMapper.php

class UserApplicationMapper {
    public static function fromCreateCommandToModel(CreateUserCommand $cmd): UserModel {
        return UserModel::create(
            new UserId($cmd->id()),
            new UserName($cmd->name()),
            new UserEmail($cmd->email()),
            UserPassword::fromPlainText($cmd->plainPassword()),
            $cmd->role()
        );
    }
}
