<?php
// Application/Ports/In/DeleteUserUseCase.php

interface DeleteUserUseCase {
    public function execute(DeleteUserCommand $cmd): void;
}
