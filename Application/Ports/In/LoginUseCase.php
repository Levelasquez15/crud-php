<?php
// Application/Ports/In/LoginUseCase.php

interface LoginUseCase {
    public function execute(LoginCommand $cmd): UserModel;
}
