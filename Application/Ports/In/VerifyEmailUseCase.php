<?php
// Application/Ports/In/VerifyEmailUseCase.php

interface VerifyEmailUseCase {
    public function execute(VerifyEmailCommand $command): UserModel;
}
