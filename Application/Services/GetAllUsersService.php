<?php
// Application/Services/GetAllUsersService.php

class GetAllUsersService implements GetAllUsersUseCase {
    private GetAllUsersPort $getAllUsersPort;

    public function __construct(GetAllUsersPort $getAllUsersPort) {
        $this->getAllUsersPort = $getAllUsersPort;
    }

    public function execute(GetAllUsersQuery $q): array {
        return $this->getAllUsersPort->getAll();
    }
}
