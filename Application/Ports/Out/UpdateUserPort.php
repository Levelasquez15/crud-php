<?php
// Application/Ports/Out/UpdateUserPort.php

interface UpdateUserPort {
    public function update(UserModel $user): UserModel;
}
