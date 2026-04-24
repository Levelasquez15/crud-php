<?php
// Application/Ports/Out/GetUserByEmailPort.php

interface GetUserByEmailPort {
    public function getByEmail(UserEmail $email): ?UserModel;
}
