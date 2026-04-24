<?php
// Application/Ports/Out/GetUserByIdPort.php

interface GetUserByIdPort {
    public function getById(UserId $id): ?UserModel;
}
