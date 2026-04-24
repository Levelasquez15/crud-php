<?php
// Application/Services/GetUserByIdService.php

class GetUserByIdService implements GetUserByIdUseCase {
    private GetUserByIdPort $getUserByIdPort;

    public function __construct(GetUserByIdPort $getUserByIdPort) {
        $this->getUserByIdPort = $getUserByIdPort;
    }

    public function execute(GetUserByIdQuery $q): UserModel {
        $userId = new UserId($q->id());
        $user = $this->getUserByIdPort->getById($userId);

        if ($user === null) {
            throw UserNotFoundException::becauseIdWasNotFound($q->id());
        }

        return $user;
    }
}
