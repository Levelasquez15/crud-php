<?php
// Application/Services/LoginService.php

class LoginService implements LoginUseCase {
    private GetUserByEmailPort $getUserByEmailPort;

    public function __construct(GetUserByEmailPort $getUserByEmailPort) {
        $this->getUserByEmailPort = $getUserByEmailPort;
    }

    public function execute(LoginCommand $cmd): UserModel {
        $email = new UserEmail($cmd->email());
        $user = $this->getUserByEmailPort->getByEmail($email);

        if ($user === null || !$user->password()->verifyPlain($cmd->plainPassword())) {
            throw InvalidCredentialsException::becauseCredentialsAreInvalid();
        }

        if ($user->status() !== UserStatusEnum::ACTIVE) {
            throw InvalidCredentialsException::becauseUserIsNotActive();
        }

        return $user;
    }
}
