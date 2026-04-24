<?php
// Application/Ports/In/CreateUserUseCase.php

interface CreateUserUseCase {
    public function execute(CreateUserCommand $cmd): UserModel;
}
