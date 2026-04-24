<?php
// Application/Ports/In/GetUserByIdUseCase.php

interface GetUserByIdUseCase {
    public function execute(GetUserByIdQuery $q): UserModel;
}
