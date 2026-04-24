<?php
// Application/Ports/In/GetAllUsersUseCase.php

interface GetAllUsersUseCase {
    public function execute(GetAllUsersQuery $q): array;
}
