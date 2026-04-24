<?php
// Application/Ports/In/UpdateUserUseCase.php

interface UpdateUserUseCase {
    public function execute(UpdateUserCommand $cmd): UserModel;
}
